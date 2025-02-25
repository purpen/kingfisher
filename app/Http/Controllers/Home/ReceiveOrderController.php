<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\AddReceiveRequest;
use App\Models\AssetsModel;
use App\Models\AuditingModel;
use App\Models\CountersModel;
use App\Models\Distribution;
use App\Models\DistributorModel;
use App\Models\DistributorPaymentModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\PaymentAccountModel;
use App\Models\PaymentReceiptOrderDetailModel;
use App\Models\ProductsSkuModel;
use App\Models\ReceiveOrderModel;
use App\Models\SupplierModel;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReceiveOrderController extends Controller
{

    public function index(Request $request)
    {

//        $order_list = OrderModel::where(['type' => 8, 'status' => 6, 'suspend' => 0])->orderBy('id', 'desc')
//            ->paginate($this->per_page);
        $order_list = OrderModel::where('type', 8)->where('suspend', 0)->where('status', 6)->orderBy('id', 'desc')
            ->paginate($this->per_page);

        foreach ($order_list as $list) {
            $list->full_name = $list->distributor ? $list->distributor->full_name : '';
            $list->store_name = $list->distributor ? $list->distributor->store_name : '';
        }

        return view('home/receiveOrder.index', [
            'type' => '',
            'where' => '',
            'subnav' => 'auditingReceive',
            'tab_menu' => $this->tab_menu,
            'per_page' => $this->per_page,
            'order_list' => $order_list,
        ]);
    }


//    财务审核收款单
    public function ajaxCharge(Request $request)
    {
        $ids = $request->input('id');
        if (empty($ids)) {
            return ajax_json(0, '参数有误！');
        }
        $order = OrderModel::whereIn('id', $ids)->get();

        $order_model = new OrderModel();
        DB::beginTransaction();
        foreach ($order as $v) {
            // 创建订单收款单
            $model = new ReceiveOrderModel();
            if (!$receive_order = $model->orderCreateReceiveOrder($v->id)) {
                return ajax_json(0, "ID:'. $v->id .'财务审核订单创建收款单错误");
            }
            // 订单待发货状态
            if (!$order_model->changeStatus($v->id, 8)) {
                DB::rollBack();
                Log::error('Send Order ID:' . $v->id . '订单发货修改状态错误');
                return ajax_json(0, 'error', '订单发货修改状态错误');
            }

            // 创建出库单
            $out_warehouse = new OutWarehousesModel();
            if (!$out_warehouse->orderCreateOutWarehouse($v->id)) {
                DB::rollBack();
                Log::error('ID:' . $v->id . '订单发货,创建出库单错误');
                return ajax_json(0, 'error', '订单发货,创建出库单错误');
            }

            if ($v->payment_type == "在线付款" || $v->payment_type == "公司转账") {
                $statu = $receive_order->update(['status' => 1, 'received_money' => $receive_order->amount]);
                $status = $order_model->changeStatus($v->id, 8);

                // 为付款占货转付款占货
                $productSku = new ProductsSkuModel();
                $status1 = $productSku->orderDecreaseReserveCount($v->id);
                $status2 = $productSku->orderIncreasePayCount($v->id);

                if (!$statu || !$status || !$status1 || !$status2) {
                    DB::rollBack();
                    return ajax_json(0, '审核失败');
                }
            } else if ($v->payment_type == "月结") {
                $status = $order_model->changeStatus($v->id, 8);
                if (!$status) {
                    DB::rollBack();
                    return ajax_json(0, '审核失败');
                }
            }
            $financial_time = date('Y-m-d H:i:s', time());
            $financial_name = $v->user->realname;
            $aaa = DB::table('order')->where('id', $v->id)->update(['financial_time' => $financial_time, 'financial_name' => $financial_name]);
            if (!$aaa) {
                DB::rollBack();
                return ajax_json(0, '添加审核人失败');
            }
        }
        $ids = AuditingModel::where('type', 5)->select('user_id')->first();
        if ($ids) {
            //发送审核短信通知
            $dataes = new AuditingModel();
            $dataes->datas(5);
        }
        DB::commit();
        return ajax_json(1, '审核成功');
    }

    /**
     * Display a listing of the resource.
     *财务收款单
     * @return \Illuminate\Http\Response
     */
    public function receive(Request $request)
    {
        $receive = ReceiveOrderModel::where('status', 0)->paginate($this->per_page);
        $money = ReceiveOrderModel
            ::where('status', 0)
            ->where('type', 3)
            ->select(DB::raw('sum(amount) as amount_sum,sum(received_money) as received_sum '))
            ->first();
        $message = DB::table('order')
            ->join('receive_order', 'receive_order.target_id', '=', 'order.id')
            ->join('distributor', 'distributor.id', '=', 'order.distributor_id')
            ->where('receive_order.status', 0)
            ->where('order.payment_type', 4)
            ->select('receive_order.id as receive_id', 'receive_order.number', 'distributor.full_name', 'distributor.store_name', 'distributor.name', 'receive_order.amount', 'receive_order.summary', 'receive_order.type', 'receive_order.created_at', 'receive_order.status', 'order.payment_type', 'order.number as num', 'order.financial_name')
            ->get();

        return view('home/receiveOrder.receive', [
            'receive' => $receive,
            'message' => $message,
            'where' => '',
            'subnav' => 'waitReceive',
            'start_date' => '',
            'end_date' => '',
            'type' => '',
            'money' => $money,
        ]);
    }

    /**
     * 已收款
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function complete(Request $request)
    {
        $receive = ReceiveOrderModel::where('status', 1)->paginate($this->per_page);
        $money = ReceiveOrderModel
            ::where('status', 1)
            ->where('type', 3)
            ->select(DB::raw('sum(amount) as amount_sum,sum(received_money) as received_sum '))
            ->first();

        $message = DB::table('order')
            ->join('receive_order', 'receive_order.target_id', '=', 'order.id')
            ->join('distributor', 'distributor.id', '=', 'order.distributor_id')
            ->where('receive_order.status', 1)
            ->select('receive_order.id as receive_id', 'receive_order.number', 'distributor.full_name', 'distributor.store_name', 'distributor.name', 'receive_order.amount', 'receive_order.summary', 'receive_order.type', 'receive_order.created_at', 'receive_order.status', 'order.payment_type', 'order.number as num', 'order.financial_name')
            ->get();

        return view('home/receiveOrder.receive', [
            'receive' => $receive,
            'message' => $message,
            'where' => '',
            'subnav' => 'finishReceive',
            'start_date' => '',
            'end_date' => '',
            'type' => '',
            'money' => $money,
        ]);
    }


    /**
     * 批量确认收款
     * @param Request $request
     * @return string json数据
     */
    public function ajaxConfirmReceive(Request $request)
    {
        $arr_id = $request->input('arr_id');
        DB::beginTransaction();
        foreach ($arr_id as $id) {
            if (empty($id)) {
                DB::rollBack();
                return ajax_json(0, '参数错误');
            }
            $receive_order = ReceiveOrderModel::find($id);
            $order_name = OrderModel::where('id', $receive_order->target_id)->first();
            $old_financial_name = $order_name->financial_name ? $order_name->financial_name : '';
            if (!$receive_order) {
                DB::rollBack();
                return ajax_json(0, '参数错误');
            }

            if ($receive_order->amount != $receive_order->received_money) {
                DB::rollBack();
                return ajax_json(0, '收款尚未完成');
            }
            if ($receive_order->changeStatus(1)) {
                $target_id = $receive_order->target_id;
                $financial_name = $order_name->user->realname;
                //添加一个收款人 而不是修改
                $aaa = DB::table('order')->where('id', $target_id)->update(['financial_name' => $old_financial_name . '.' . $financial_name]);
                if (!$aaa) {
                    DB::rollBack();
                    return ajax_json(0, '添加审核人失败');
                }
            } else {
                DB::rollBack();
                return ajax_json(0, '确认付款失败');
            }
        }
        DB::commit();
        return ajax_json(1, '确认成功');
    }

    /**
     * 展示收款单修改页面
     * @param Request $request int id 付款单ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function editReceive(Request $request)
    {
        $id = (int)$request->input('id');
        if (empty($id)) {
            return '参数错误';
        }
        $receive = ReceiveOrderModel::find($id);
        $payment_account = PaymentAccountModel::select(['account', 'id', 'bank'])->get();
        return view('home/receiveOrder.editReceive', [
            'receive' => $receive,
            'payment_account' => $payment_account,
            'subnav' => '',
            'type' => '',
        ]);
    }

    /**
     * 修改收款单信息
     * @param Request $request
     * @return string
     */
    public function updateReceive(Request $request)
    {
        $id = (int)$request->input('id');
        $payment_account_id = (int)$request->input('payment_account_id');
        $summary = $request->input('summary');

        DB::beginTransaction();
        $receive_order = ReceiveOrderModel::find($id);
        if ($receive_order->status == 1) {
            return '已经收款不能再修改';
//            return back()->withErrors(['已经收款不能再修改！']);
        }
        //判断已付金额是否大于应付金额
        $received_money = $request->input('received_money');
        if ($receive_order->amount < $received_money) {
            DB::rollBack();
            return '参数错误';
        }

        $receive_order->received_money = $received_money;
        $receive_order->payment_account_id = $payment_account_id;
        $receive_order->summary = $summary;
        $receive_order->receive_time = $request->input('receive_time');
        if (!$receive_order->save()) {
            DB::rollBack();
            return "修改失败1";
        }
        if ($order = $receive_order->order) {
            if (!$order->changeReceivedMoney($received_money)) {
                DB::rollBack();
                return "修改失败3";
            }
        }

        DB::commit();
        return redirect('/receive/receive');
    }

    /**
     * 已收款单详情
     * @param Request $request int id 收款单ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function detailedReceive(Request $request)
    {
        $id = (int)$request->input('id');
        if (empty($id)) {
            return '参数错误';
        }
        $receive = ReceiveOrderModel::find($id);
        $payment_account = PaymentAccountModel::select(['account', 'id', 'bank'])->get();
        return view('home/receiveOrder.detailedReceive', ['receive' => $receive, 'payment_account' => $payment_account]);
    }

    /*
     * 财务收款搜索
     *
     */
    public function search(Request $request)
    {
        $where = $request->input('where');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $subnav = $request->input('subnav');
        $type = $request->input('type');

        if ($request->isMethod('get') && $request->input('time')) {
            $time = $request->input('time');
            $start_date = date("Y-m-d H:i:s", strtotime("-" . $time . " day"));
            $end_date = date("Y-m-d H:i:s");
        }

        if ($request->isMethod('get') && $request->input('receive_number')) {
            $where = $request->input('receive_number');
        }

        switch ($subnav) {
            case 'waitReceive':
                $status = 0;
                break;
            case 'finishReceive':
                $status = 1;
                break;
            default:
                $status = null;
        }
        //搜索列表
//        $receive = ReceiveOrderModel::query();
        $message = DB::table('order');
//            ->join('receive_order', 'receive_order.target_id', '=', 'order.id')
//            ->join('distributor', 'distributor.id', '=', 'order.distributor_id')
//            ->where('receive_order.number', 'like', '%' . $where . '%')
//            ->Where('receive_order.number','=',$where)
//            ->orWhere('order.number','=',$where)
//            ->orWhere('receive_order.payment_user', 'like', '%' . $where . '%')
//            ->select('receive_order.id as receive_id','receive_order.status','receive_order.created_at','receive_order.number','distributor.full_name','distributor.store_name','distributor.name','receive_order.amount','receive_order.summary','receive_order.type','receive_order.created_at','receive_order.status','order.payment_type','order.number as num','order.financial_name')
//            ->get();
        if (!empty($where)) {
            $message = $message->orWhere('receive_order.number', '=', $where);
            $message = $message->orWhere('order.number', '=', $where);
            $message = $message->orWhere('receive_order.payment_user', 'like', '%' . $where . '%');
//           $message->where('receive_order.number','=',$where)->orWhere('receive_order.payment_user', 'like', '%' . $where . '%');
        }
        if ($status !== null) {
            $message = $message->where('receive_order.status', '=', $status);
//          $receive->where($receive->status, '=', $status);
        }
        if ($start_date && $end_date) {
            $start_date = date("Y-m-d H:i:s", strtotime($start_date));
            $end_date = date("Y-m-d H:i:s", strtotime($end_date));
            $message = $message->whereBetween('receive_order.created_at', [$start_date, $end_date]);
//       $receive->whereBetween($receive->created_at, [$start_date, $end_date]);
        }
        if (!empty($type)) {
            $message = $message->where('receive_order.type', '=', $type);
////        $receive->where($receive->type, '=', $type);
        }
//        $receive = $receive->paginate($this->per_page);

        $message = $message->join('receive_order', 'receive_order.target_id', '=', 'order.id')
            ->join('distributor', 'distributor.id', '=', 'order.distributor_id')
            ->select('receive_order.id as receive_id', 'receive_order.status', 'receive_order.created_at', 'receive_order.number', 'distributor.full_name', 'distributor.store_name', 'distributor.name', 'receive_order.amount', 'receive_order.summary', 'receive_order.type', 'receive_order.created_at', 'receive_order.status', 'order.payment_type', 'order.number as num', 'order.financial_name')
            ->get();

        //收款统计
        $money = ReceiveOrderModel::query();
        if ($where) {
            $money->where('number', 'like', '%' . $where . '%')->orWhere('payment_user', 'like', '%' . $where . '%');
        }
        if ($status !== null) {
            $money->where('status', '=', $status);
        }
        if ($start_date && $end_date) {
            $start_date = date("Y-m-d H:i:s", strtotime($start_date));
            $end_date = date("Y-m-d H:i:s", strtotime($end_date));
            $money->whereBetween('created_at', [$start_date, $end_date]);
        }
        if ($type) {
            $money->where('type', '=', $type);
        }
        $money = $money->select(DB::raw('sum(amount) as amount_sum,sum(received_money) as received_sum '))->first();
        if (count($message) > 0) {
            return view('home/receiveOrder.receive', [
                'message' => $message,
                'subnav' => $subnav,
                'count' => '',
                'where' => $where,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'type' => $type,
                'money' => $money,
            ]);
        }
    }

    /**
     * 创建收款单页面
     */
    public function createReceive()
    {
        //银行账户
        $payment_account = PaymentAccountModel::select(['account', 'id', 'bank'])->get();
        return view('home/receiveOrder.create', [
            'payment_account' => $payment_account,
            'subnav' => '',
            'type' => '',
        ]);
    }

    /**
     * 保存收款单
     */
    public function storeReceive(AddReceiveRequest $request)
    {
        $number = CountersModel::get_number('SK');
        if ($number == false) {
            return view('errors.503');
        }
        $receiveOrder = new ReceiveOrderModel();
        $receiveOrder->amount = (float)$request->input('amount');
        $receiveOrder->payment_user = $request->input('payment_user');
        $receiveOrder->type = $request->input('type');
        $receiveOrder->payment_account_id = $request->input('payment_account_id');
        $receiveOrder->status = 0;  //未付款
        $receiveOrder->target_id = '';
        $receiveOrder->user_id = Auth::user()->id;
        $receiveOrder->number = $number;
        $receiveOrder->summary = $request->input('summary');
        $receiveOrder->receive_time = $request->input('receive_time');
        if (!$receiveOrder->save()) {
            return view('errors.503');
        } else {
            return redirect('/receive');
        }
    }

    /**
     * 删除收款单（自建的）
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $model = ReceiveOrderModel::find($id);
        if (!$model) {
            return ajax_json(0, 'error');
        }
        if ($model->type > 4 && $model->status == 0) {
            if (!$model->delete()) {
                return ajax_json(0, 'error');
            }
            return ajax_json(1, 'ok');
        } else {
            return ajax_json(0, 'error');
        }
    }


    //获取收款单查看详情
    public function ajaxEdit(Request $request)
    {
        $order_id = (int)$request->input('id');
        $order = OrderModel::where('id', $order_id)->first();
        if (!$order) {
            return ajax_json(0, 'error');
        }

        $distributor = $order->distributor;
        if ($distributor) {
            $order->full_name = $distributor->full_name ? $distributor->full_name : '';
            $order->business_license_number = $distributor->business_license_number ? $distributor->business_license_number : '';
            $order->bank_number = $distributor->bank_number ? $distributor->bank_number : '';
            $order->store_name = $distributor->store_name ? $distributor->store_name : '';
            $order->phone = $distributor->phone ? $distributor->phone : '';
            $order->name = $distributor->name ? $distributor->name : '';
        } else {
            $order->full_name = '';
            $order->business_license_number = '';
            $order->bank_number = '';
            $order->store_name = '';
            $order->phone = '';
            $order->name = '';
        }

        if ($order->status == 6 && $order->is_voucher == 1) {
            if ($order->assets) {
                $order->image = $order->assets->file->small;
                $order->img = $order->assets->file->p800;
            } else {
                $order->image = url('images/default/erp_product.png');
                $order->img = url('images/default/erp_product1.png');
            }
        } else {
            $order->image = '';
            $order->img = '';
        }

        return ajax_json(1, 'ok', ['order' => $order]);
    }


//    渠道收款单start


    public function receiveIndex(Request $request)
    {
        $this->tab_menu = 'default';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->channellist(null);
    }

    /**
     * 待关联人 销售确认列表
     */
//    public function guanlianrenList(Request $request)
//    {
//        $this->tab_menu = 'guanlianlish';
//        $this->per_page = $request->input('per_page', $this->per_page);
//        return $this->channellist(0);
//    }

    /**
     * 待负责人确认列表
     */
    public function saleList(Request $request)
    {
        $this->tab_menu = 'saled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->channellist(1);
    }

    /**
     * 待分销商确认列表
     */
    public function unpublishList(Request $request)
    {
        $this->tab_menu = 'unpublish';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->channellist(2);
    }


    /**
     * 待确认付款列表
     */
    public function cancList(Request $request)
    {
        $this->tab_menu = 'canceled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->channellist(3);
    }

    /**
     * 完成列表
     */
    public function overList(Request $request)
    {
        $this->tab_menu = 'overled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->channellist(4);
    }

//    渠道收款单列表
    public function channellist($status = null)
    {
        if ($status === null) {//变量值与类型完全相等
            $channel = DistributorPaymentModel::orderBy('id', 'desc')->paginate($this->per_page);
        } else {
            $channel = DistributorPaymentModel::where('status', $status)->orderBy('id', 'desc')->paginate($this->per_page);
        }
        $user = new UserModel();
        if (count($channel) > 0) {
            foreach ($channel as $k => $v) {
                $userId = UserModel::where('id', $v->distributor_user_id)->first();
                $channel[$k]['name'] = $userId->realname;
            }
        }
        return view('home/receiveOrder.channellist', ['channel' => $channel, 'tab_menu' => $this->tab_menu]);
    }

//    渠道收款单
    public function channel()
    {
        $distributor = UserModel::where('supplier_distributor_type', 1)->get();
        return view('home/receiveOrder.channel', ['distributor' => $distributor]);
    }


    //添加或追加获取促销数量
    public function ajaxNum(Request $request)
    {
        $distributor_user_id = $request->input('distributor_user_id');

        $id = $request->input('oid');
        $sku_id = $request->input('sku_id');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
//        $sku=OrderSkuRelationModel::where('sku_id',$sku_id)->get();
//        foreach ($sku as $value){
//            $sku->order_id[]=$value->order_id;
//        }
//        $seles=OrderModel::whereIn('id',$sku->order_id)->whereBetween('order.order_send_time', [$start_time, $end_time])->get();


        $sku = DB::table('order')
            ->join('order_sku_relation', 'order_sku_relation.order_id', '=', 'order.id')
            ->where(['order.distributor_id' => $distributor_user_id])
            ->where('order_sku_relation.sku_id', $sku_id)
            ->where('order_sku_relation.distributor_payment_id', '=', 0)
            ->whereBetween('order.order_send_time', [$start_time, $end_time])
            ->get();
        $seles = objectToArray($sku);


        if (count($seles) > 0) {
            $num = 0;
            foreach ($seles as $v) {
                $num += $v['quantity'];
            }

        } else {
            return ajax_json(0, 'error', '暂无数据！');
        }
        return ajax_json(1, 'ok', $num);
    }

    //编辑获取促销数量
    public function editNum(Request $request)
    {
        $distributor_user_id = $request->input('distributor_user_id');
        $id = $request->input('id');
        $sku_id = $request->input('sku_id');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        $ids = substr($id, 0, -1);
//        $id_arr = explode(',',$ids);
//        $skuids=implode(",",$sku_id);
//        $skuids = substr($sku_id,0,-1);
        $sku = DB::table('order')
            ->join('order_sku_relation', 'order_sku_relation.order_id', '=', 'order.id')
            ->where(['order.distributor_id' => $distributor_user_id])
            ->where('order_sku_relation.sku_id', $sku_id)
            ->where('order_sku_relation.distributor_payment_id', '=', 0)
            ->whereBetween('order.order_send_time', [$start_time, $end_time])
            ->get();
        $seles = objectToArray($sku);

        if (count($seles) > 0) {
            $num = 0;
            foreach ($seles as $v) {
                $num += $v['quantity'];
            }
        } else {
            return ajax_json(0, 'error', 0);
        }
        return ajax_json(1, 'ok', $num);
    }

//    编辑获取订单详情等明细

    public function ajaxChannel(Request $request)
    {
        $distributor_user_id = $request->input('distributor_user_id');
        $start_time = $request->input('start_times');
        $end_time = $request->input('end_times');
//        $sku_ids = $request->input('oid');
        $sku_ids = $request->input('sku_id');
        $length = $request->input('length');
        $sku_id = substr($sku_ids, 0, -1);
        $sku_id_arr = explode(',', $sku_id);

//        $order = OrderModel::where(['distributor_id'=>$distributor_user_id])->whereBetween('created_at',[$start_time,$end_time])->get();
//        $order = $order->toarray();
//        if(count($order)>0){
//            foreach ($order as $v){
//                $order['id'][]=$v['id'];
//            }
//            $sku=OrderSkuRelationModel::whereIn('order_id',$order['id'])->where('distributor_payment_id','!=',0)->get();
//            $sku = $sku->toarray();
//        }else{
//            $sku = [];
//        }
        $sku = DB::table('order')
            ->join('order_sku_relation', 'order_sku_relation.order_id', '=', 'order.id')
            ->where(['order.distributor_id' => $distributor_user_id])
            ->whereBetween('order.created_at', [$start_time, $end_time])
            ->where('order_sku_relation.distributor_payment_id', '=', 0)
            ->get();
        $sku = objectToArray($sku);
        if (count($sku) > 0) {
            $new = [];
            foreach ($sku as $k => $v) {
                if (isset($new[$v['sku_id']])) {
                    $new[$v['sku_id']]['quantity'] += $v['quantity'];
                } else {
                    $new[$v['sku_id']] = $v;
                }
            }
            $skus = array_merge($new);

            foreach ($skus as $k => $list) {
                if (count($sku_id_arr) > 0 && is_array($sku_id_arr)) {
                    if (in_array($list['sku_id'], $sku_id_arr)) {
                        unset($skus[$k]);
                    } else {
                        $skus[$k]['ids'] = $list['order_id'];
                        $skus[$k]['before_sort'] = $k + $length;
                        $skus[$k]['goods_money'] = $list['quantity'] * $list['price'];
                    }
                } else {
                    $skus[$k]['ids'] = $list['order_id'];
                    $skus[$k]['before_sort'] = $k + $length;
                    $skus[$k]['goods_money'] = $list['quantity'] * $list['price'];
                }

            }

            $skus = array_merge($skus);
            if (count($skus) == 0) {
                return ajax_json(0, 'error', '暂无匹配数据！');

            } else {
                return ajax_json(1, 'ok', $skus);
            }
        } else {
            return ajax_json(0, 'error', '暂无数据！');
        }
    }

    //    添加获取订单详情等明细

    public function ajaxAdd(Request $request)
    {
        $distributor_user_id = $request->input('distributor_user_id');
        $start_time = $request->input('start_times');
        $end_time = $request->input('end_times');
//        $sku_ids = $request->input('oid');
        $sku_ids = $request->input('sku_id');
        if (!empty($sku_ids)) {
            $sku_id = substr($sku_ids, 0, -1);
            $sku_id_arr = explode(',', $sku_id);

        } else {
            $sku_ids = 0;
            $sku_id_arr = [];
        }

        $sku = DB::table('order')
            ->join('order_sku_relation', 'order_sku_relation.order_id', '=', 'order.id')
            ->where(['order.distributor_id' => $distributor_user_id])
            ->whereBetween('order.created_at', [$start_time, $end_time])
            ->where('order_sku_relation.distributor_payment_id', '=', 0)
//            ->select('order_sku_relation.id as skuid','order_sku_relation.order_id','order_sku_relation.order_id as id','order_sku_relation.sku_id','order_sku_relation.quantity','order_sku_relation.price','order_sku_relation.sku_number','order_sku_relation.sku_name','order.distributor_id','')
            ->get();
        $sku = objectToArray($sku);
        if (count($sku) > 0) {
            $new = [];
            foreach ($sku as $k => $v) {
                if (isset($new[$v['sku_id']])) {
                    $new[$v['sku_id']]['quantity'] += $v['quantity'];
                } else {
                    $new[$v['sku_id']] = $v;
                }
            }
            $skus = array_merge($new);

            foreach ($skus as $k => $list) {
                if (count($sku_id_arr) > 0 && is_array($sku_id_arr)) {

                    if (in_array($list['sku_id'], $sku_id_arr)) {
                        unset($skus[$k]);
                    } else {
                        $skus[$k]['ids'] = $list['order_id'];
                        $skus[$k]['goods_money'] = $list['quantity'] * $list['price'];
                        $skus[$k]['sku_ids'] = $sku_ids;
                    }

                } else {
                    $skus[$k]['ids'] = $list['order_id'];
                    $skus[$k]['goods_money'] = $list['quantity'] * $list['price'];

                }
            }
            $skus = array_merge($skus);
            if (count($skus) == 0) {
                return ajax_json(0, 'error', '暂无匹配数据！');

            } else {
                return ajax_json(1, 'ok', $skus);
            }
        } else {
            return ajax_json(0, 'error', '暂无数据！');
        }
    }

//    保存渠道收款单

    public function storeChannel(Request $request)
    {
        $distributorPayment = new DistributorPaymentModel();
        $distributorPayment->distributor_user_id = $request->input('distributor_user_id');
        $distributorPayment->start_time = $request->input('start_times');
        $distributorPayment->end_time = $request->input('end_times');
        $distributorPayment->price = $request->input('skuTotalFee');
        $distributorPayment->user_id = Auth::user()->id;
        $numbers = CountersModel::get_number('QD');//渠道
        if ($numbers == false) {
            return false;
        }
        $distributorPayment->number = $numbers;
        $distributorPayment->status = 1;
        $result = $distributorPayment->save();

        $skuid = array_values($request->input('oid'));
//            $oid = $request->input('all_skuid');
//            $sku_id = substr($oid,0,-1);
//            $sku_id_arr = explode(',',$sku_id);
        $sku_id = array_values($request->input('sku_id'));
        $sku_name = array_values($request->input('sku_name'));
        $sku_number = array_values($request->input('sku_number'));
        $quantity = array_values($request->input('quantity'));
        $price = array_values($request->input('price'));
        $number = array_values($request->input('number'));
        $prices = array_values($request->input('prices'));
        $start_time = array_values($request->input('start_time'));
        $end_time = array_values($request->input('end_time'));


        if ($result) {
            $target_id = $distributorPayment->id;
            $num = count($sku_id);

            for ($i = 0; $i < $num; $i++) {
                $paymentReceiptOrderDetail = new PaymentReceiptOrderDetailModel();
                $paymentReceiptOrderDetail->sku_id = $sku_id[$i];
                $paymentReceiptOrderDetail->sku_name = $sku_name[$i];
                $paymentReceiptOrderDetail->sku_number = $sku_number[$i];
                $paymentReceiptOrderDetail->quantity = $quantity[$i];
                $paymentReceiptOrderDetail->price = $price[$i];
                $paymentReceiptOrderDetail->type = 1;
                $paymentReceiptOrderDetail->target_id = $target_id;

                $favorables = [
                    'number' => $number[$i],
                    'price' => $prices[$i],
                    'start_time' => $start_time[$i],
                    'end_time' => $end_time[$i]
                ];
                $paymentReceiptOrderDetail->favorable = json_encode($favorables);
                $paymentReceiptOrderDetail->save();

                $OrderSkuRelation = new OrderSkuRelationModel();
                $a = OrderSkuRelationModel::where('sku_id', $paymentReceiptOrderDetail->sku_id)->get();
                $a->distributor_payment_id = $distributorPayment->id;

                $res = DB::table('order_sku_relation')
                    ->where('order_sku_relation.id', $skuid[$i])
                    ->update(['distributor_payment_id' => $a->distributor_payment_id, 'distributor_price' => $prices[$i]]);
            }

            return redirect('/receive/channellist');
        } else {
            return view('errors.503');
        }
    }

//    渠道收款单展示
    public function show(Request $request)
    {
        $id = $request->id;
        $distributorPayment = DistributorPaymentModel::where('id', $id)->first();

        $user = new UserModel();
        $userId = UserModel::where('id', $distributorPayment->distributor_user_id)->first();

        $payment = new OrderSkuRelationModel();
        $order = $payment
            ->join('distributor_payment', 'distributor_payment.id', '=', 'order_sku_relation.distributor_payment_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->where(['order_sku_relation.distributor_payment_id' => $distributorPayment->id])
            ->select([
                'order.number',
                'order.outside_target_id',
                'distributor_payment.price',
                'order_sku_relation.sku_name',
                'order_sku_relation.quantity',
                'order_sku_relation.price',
                'order_sku_relation.sku_number',
                'order_sku_relation.distributor_price',
            ])
            ->get();
        $orders = $order->toArray();

        $paymentReceiptOrderDetail = PaymentReceiptOrderDetailModel::where('target_id', $distributorPayment->id)->where('type', 1)->orderBy("id", "asc")->get();
        foreach ($paymentReceiptOrderDetail as $k => $v) {
            $favorable = json_decode($v['favorable'], true);
            $paymentReceiptOrderDetail[$k]['prices'] = $favorable['price'];
            $paymentReceiptOrderDetail[$k]['start_time'] = $favorable['start_time'];
            $paymentReceiptOrderDetail[$k]['end_time'] = $favorable['end_time'];
            $paymentReceiptOrderDetail[$k]['numbers'] = $favorable['number'];
        }
        return view('home/receiveOrder.show', ['distributorPayment' => $distributorPayment, 'userId' => $userId, 'paymentReceiptOrderDetail' => $paymentReceiptOrderDetail, 'orders' => $orders]);

    }


    //    渠道收款单审核
    public function ajaxVerify(Request $request)
    {
        $id = $request->input('id') ? $request->input('id') : '';

        $status = $request->input('status') ? $request->input('status') : '';
        if (empty($id)) {
            return ajax_json(1, '审核失败！');
        }
        $distributorPayment = DistributorPaymentModel::find($id);
        $this->distributor = new DistributorPaymentModel();

        $distributorPayment = $this->distributor->changeStatus($id, $status);

        if ($status == 4) {//订单完成时填收款时间
            $OrderSkuRelation = new OrderSkuRelationModel();
            $OrderSkuRelation->supplier_receipt_time = $distributorPayment->created_at;
            $OrderSkuRelation->save();
        }

        if ($distributorPayment) {
            return ajax_json(1, '操作成功！');

        } else {
            return ajax_json(0, '操作失败！');

        }
    }


    public function edit(Request $request)
    {
        $user = new UserModel();
        $userlist = UserModel::where('supplier_distributor_type', 1)->get();//拿到分销商

        $id = $request->input('id');
        $distributorPayment = DistributorPaymentModel::find($id);
        $uid = UserModel::where('id', $distributorPayment->distributor_user_id)->get();


        $payment = new OrderSkuRelationModel();
        $order = $payment
            ->join('distributor_payment', 'distributor_payment.id', '=', 'order_sku_relation.distributor_payment_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->where(['order_sku_relation.distributor_payment_id' => $distributorPayment->id])
            ->select('order_sku_relation.id as oid', 'order_sku_relation.sku_id', 'order.id as order_id')
            ->get();

        $skuid_str = "";
        $sku_id_str = "";
        $order_id = "";

        foreach ($order as $k => $v) {
            $skuid_str .= $v['oid'] . ",";
            $sku_id_str .= $v['sku_id'] . ",";
            $order_id .= $v['order_id'] . ",";
        }
        foreach ($order as $key => $val) {
            $skuid_arr[] = $val['oid'];
            $sku_id_arr[] = $val['sku_id'];
            $order_arr[] = $val['order_id'];
        }
        $paymentReceiptOrderDetail = PaymentReceiptOrderDetailModel::where('target_id', $distributorPayment->id)->where('type', 1)->orderBy("id", "asc")->get();
        if ($paymentReceiptOrderDetail) {
            foreach ($paymentReceiptOrderDetail as $k => $v) {
                $favorable = json_decode($v->favorable, true);
                $paymentReceiptOrderDetail[$k]['jia'] = intval($v['price']);
                $paymentReceiptOrderDetail[$k]['number'] = $favorable['number'];
                $paymentReceiptOrderDetail[$k]['prices'] = $favorable['price'];
                $paymentReceiptOrderDetail[$k]['price'] = sprintf("%.2f", $v['price']);//两位数
                $paymentReceiptOrderDetail[$k]['start_time'] = $favorable['start_time'];
                $paymentReceiptOrderDetail[$k]['end_time'] = $favorable['end_time'];
                $paymentReceiptOrderDetail[$k]['oid'] = $skuid_arr[$k];
                $paymentReceiptOrderDetail[$k]['sku_id'] = $sku_id_arr[$k];
                $paymentReceiptOrderDetail[$k]['order_id'] = $order_arr[$k];
            }
            $sku_id = [];
            foreach ($paymentReceiptOrderDetail as $k => $v) {
                $paymentReceiptOrderDetail[$k]['sort'] = $k;
                $sku_id[] = $v->sku_id;
            }
            $count = count($paymentReceiptOrderDetail);
            $sku_id = implode(',', $sku_id);
        }
        return view('home/receiveOrder.editChannel', ['userlist' => $userlist, 'paymentReceiptOrderDetail' => $paymentReceiptOrderDetail, 'distributorPayment' => $distributorPayment, 'sku_id' => $sku_id, 'count' => $count, 'uid' => $uid, "skuid_str" => $skuid_str, 'sku_id_str' => $sku_id_str, 'order_id' => $order_id]);

    }

    public function update(Request $request)
    {
        $id = (int)$request->input('id');
        $distributor_user_id = $request->input('distributor_user_id');
        $start_times = $request->input('start_times');
        $end_times = $request->input('end_times');
        $total_price = $request->input('skuTotalFee');
        $user_id = Auth::user()->id;

        $oid = $request->input('all_skuid');
        $sku_id = substr($oid, 0, -1);
        $sku_id_arr = explode(',', $sku_id);
        $sku_id = array_values($request->input('sku_id'));
        $sku_name = array_values($request->input('sku_name'));
        $sku_number = array_values($request->input('sku_number'));
        $quantity = array_values($request->input('quantity'));
        $price = array_values($request->input('price'));

        $number = array_values($request->input('number'));
        $prices = array_values($request->input('prices'));
        $start_time = array_values($request->input('start_time'));
        $end_time = array_values($request->input('end_time'));

        $distributorPayment = DistributorPaymentModel::find($id);
        $distributorPayment->distributor_user_id = $distributor_user_id;
        $distributorPayment->start_time = $start_times;
        $distributorPayment->end_time = $end_times;
        $distributorPayment->price = $total_price;
        $distributorPayment->user_id = $user_id;
        $result = $distributorPayment->save();
        if ($result) {
            DB::table('payment_receipt_order_detail')->where('target_id', $id)->where('type', 1)->delete();

            $target_id = $distributorPayment->id;
            $num = count($sku_id);
            for ($i = 0; $i < $num; $i++) {
                $paymentReceiptOrderDetail = new PaymentReceiptOrderDetailModel();
                $paymentReceiptOrderDetail->sku_id = $sku_id[$i];
                $paymentReceiptOrderDetail->sku_name = $sku_name[$i];
                $paymentReceiptOrderDetail->sku_number = $sku_number[$i];
                $paymentReceiptOrderDetail->quantity = $quantity[$i];
                $paymentReceiptOrderDetail->price = $price[$i];
                $paymentReceiptOrderDetail->type = 1;
                $paymentReceiptOrderDetail->target_id = $target_id;
                $favorables = [
                    'number' => $number[$i],
                    'price' => $prices[$i],
                    'start_time' => $start_time[$i],
                    'end_time' => $end_time[$i]
                ];
                $paymentReceiptOrderDetail->favorable = json_encode($favorables);
                $paymentReceiptOrderDetail->save();

                $OrderSkuRelation = new OrderSkuRelationModel();
                $a = OrderSkuRelationModel::where('sku_id', $paymentReceiptOrderDetail->sku_id)->get();
                $a->distributor_payment_id = $distributorPayment->id;

                $res = DB::table('order_sku_relation')
                    ->where('order_sku_relation.id', $sku_id_arr[$i])
                    ->update(['distributor_payment_id' => $a->distributor_payment_id, 'distributor_price' => $prices[$i]]);
            }

            return redirect('/receive/channellist');
        } else {
            return ajax_json(0, 'error');
        }


    }

    public function Destroy(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return ajax_json(0, 'error');
        }
        $distributorPayment = DistributorPaymentModel::find($id);
        if (!$distributorPayment) {
            return ajax_json(0, 'error');
        }

        $order_sku = OrderSkuRelationModel::where('distributor_payment_id', $distributorPayment->id)->get();


        $paymentReceiptOrderDetail = PaymentReceiptOrderDetailModel::where('target_id', $distributorPayment->id)->where('type', 1)->get();
        if (Auth::user()->hasRole(['admin']) && $distributorPayment->status < 4) {//已完成的不能删除
            $distributorPayment->forceDelete();
            if (count($paymentReceiptOrderDetail) > 0) {
                foreach ($paymentReceiptOrderDetail as $v) {
                    $v->forceDelete();
                }
            }
            if (count($order_sku) > 0) {
                foreach ($order_sku as $v) {
                    $res = DB::table('order_sku_relation')
                        ->where('order_sku_relation.distributor_payment_id', $distributorPayment->id)
                        ->update(['distributor_payment_id' => '0', 'distributor_price' => '0.00']);
                }
            }
            return ajax_json(1, 'ok');
        } else if ($paymentReceiptOrderDetail->type = 1 && $distributorPayment->status < 4) {
            $distributorPayment->forceDelete();
            if (count($paymentReceiptOrderDetail) > 0) {
                foreach ($paymentReceiptOrderDetail as $v) {
                    $v->forceDelete();
                }
            }
            if (count($order_sku) > 0) {
                foreach ($order_sku as $v) {
                    $res = DB::table('order_sku_relation')
                        ->where('order_sku_relation.distributor_payment_id', $distributorPayment->id)
                        ->update(['distributor_payment_id' => '0', 'distributor_price' => '0.00']);
                }
            }
            return ajax_json(1, 'ok');
        } else {
            return ajax_json(0, 'error');
        }
    }

}
