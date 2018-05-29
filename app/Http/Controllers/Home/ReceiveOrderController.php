<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\AddReceiveRequest;
use App\Models\CountersModel;
use App\Models\Distribution;
use App\Models\DistributorPaymentModel;
use App\Models\OrderModel;
use App\Models\PaymentAccountModel;
use App\Models\PaymentReceiptOrderDetailModel;
use App\Models\ReceiveOrderModel;
use App\Models\SupplierModel;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceiveOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $receive = ReceiveOrderModel::where('status',0)->paginate($this->per_page);
        $money = ReceiveOrderModel
            ::where('status',0)
            ->select(DB::raw('sum(amount) as amount_sum,sum(received_money) as received_sum '))
            ->first();
        return view('home/receiveOrder.index',[
            'receive' => $receive,
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
        $receive = ReceiveOrderModel::where('status',1)->paginate($this->per_page);
        $money = ReceiveOrderModel::where('status',1)->select(DB::raw('sum(amount) as amount_sum,sum(received_money) as received_sum '))->first();
        return view('home/receiveOrder.index',[
            'receive' => $receive,
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
    public function ajaxConfirmReceive(Request $request){
        $arr_id = $request->input('arr_id');
        DB::beginTransaction();
        foreach ($arr_id as $id){
            if(empty($id)){
                DB::rollBack();
                return ajax_json(0,'参数错误');
            }
            $receive_order = ReceiveOrderModel::find($id);
            if(!$receive_order){
                DB::rollBack();
                return ajax_json(0,'参数错误');
            }

            if($receive_order->amount != $receive_order->received_money){
                DB::rollBack();
                return ajax_json(0,'收款尚未完成');
            }

            if(!$receive_order->changeStatus(1)){
                DB::rollBack();
                return ajax_json(0,'确认付款失败');
            }
        }
        DB::commit();
        return ajax_json(1,'确认成功');
    }

    /**
     * 展示收款单修改页面
     * @param Request $request int id 付款单ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function editReceive(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return '参数错误';
        }
        $receive = ReceiveOrderModel::find($id);
        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        return view('home/receiveOrder.editReceive',[
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
        //判断已付金额是否大于应付金额
        $received_money = $request->input('received_money');
        if($receive_order->amount < $received_money){
            DB::rollBack();
            return '参数错误';
        }

        $receive_order->received_money = $received_money;
        $receive_order->payment_account_id = $payment_account_id;
        $receive_order->summary = $summary;
        $receive_order->receive_time = $request->input('receive_time');
        if(!$receive_order->save()){
            DB::rollBack();
            return "修改失败1";
        }
        if($order = $receive_order->order){
            if(!$order->changeReceivedMoney($received_money)){
                DB::rollBack();
                return "修改失败3";
            }
        }

        DB::commit();
        return redirect('/receive');
    }

    /**
     * 已收款单详情
     * @param Request $request int id 收款单ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function detailedReceive(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return '参数错误';
        }
        $receive = ReceiveOrderModel::find($id);
        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        return view('home/receiveOrder.detailedReceive',['receive' => $receive,'payment_account' => $payment_account]);
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

        if($request->isMethod('get') && $request->input('time')){
            $time = $request->input('time');
            $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
            $end_date = date("Y-m-d H:i:s");
        }

        if($request->isMethod('get') && $request->input('receive_number')){
            $where = $request->input('receive_number');
        }

        switch ($subnav){
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
        $receive = ReceiveOrderModel::query();
        if($where){
            $receive->where('number','like','%'.$where.'%')->orWhere('payment_user','like','%'.$where.'%');
        }
        if($status !== null){
            $receive->where('status','=',$status);
        }
        if($start_date && $end_date){
            $start_date = date("Y-m-d H:i:s",strtotime($start_date));
            $end_date = date("Y-m-d H:i:s",strtotime($end_date));
            $receive->whereBetween('created_at', [$start_date, $end_date]);
        }
        if($type){
            $receive->where('type','=',$type);
        }
        $receive = $receive->paginate($this->per_page);

        //收款统计
        $money = ReceiveOrderModel::query();
        if($where){
            $money->where('number','like','%'.$where.'%')->orWhere('payment_user','like','%'.$where.'%');
        }
        if($status !== null){
            $money->where('status','=',$status);
        }
        if($start_date && $end_date){
            $start_date = date("Y-m-d H:i:s",strtotime($start_date));
            $end_date = date("Y-m-d H:i:s",strtotime($end_date));
            $money->whereBetween('created_at', [$start_date, $end_date]);
        }
        if($type){
            $money->where('type','=',$type);
        }
        $money = $money->select(DB::raw('sum(amount) as amount_sum,sum(received_money) as received_sum '))->first();
        if($receive){
            return view('home/receiveOrder.index',[
                'receive' => $receive,
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
        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        return view('home/receiveOrder.create',[
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
        if($number == false){
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
        if(!$receiveOrder->save()){
            return view('errors.503');
        }else{
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
        if(!$model){
            return ajax_json(0,'error');
        }
        if($model->type > 4 && $model->status == 0){
            if(!$model->delete()){
                return ajax_json(0,'error');
            }
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'error');
        }
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
    public function channellist($status=null){
        if ($status === null){//变量值与类型完全相等
            $channel = DistributorPaymentModel::orderBy('id','desc')->paginate($this->per_page);
        }else{
            $channel = DistributorPaymentModel::where('status',$status)->orderBy('id','desc')->paginate($this->per_page);
        }
          $user=new UserModel();
        if ($channel){
            foreach ($channel as $k=>$v){
                $userId=UserModel::where('id',$v->distributor_user_id)->first();
                $channel[$k]['name'] = $userId->account;
            }
        }
        return view('home/receiveOrder.channellist',['channel'=>$channel,'tab_menu'=>$this->tab_menu]);
    }

//    渠道收款单
    public function channel(){
        $user=new UserModel();
        $distributor=UserModel::where('supplier_distributor_type',1)->get();
        return view('home/receiveOrder.channel',['distributor'=>$distributor]);
    }

//    获取订单详情等明细

    public function ajaxChannel(Request $request){
        $distributor_user_id=$request->input('distributor_user_id');
        $start_time=$request->input('start_times');
        $end_time=$request->input('end_times');


        $skus=OrderModel::where(['user_id'=>$distributor_user_id])->get();
//        $data=OrderModel::where('user_id',$distributor_user_id)->whereBetween('created_at',[$start_time,$end_time])->get();
//        $data=OrderModel::where('user_id',$distributor_user_id)->where("created_at","<",$start_time)->where("created_at",">",$end_time);
//        $skus=[];
        if (count($skus)>0) {
            foreach ($skus as $k => $v) {
//            $skus['orderInfo'][] = $v->OrderSkuRelation;
                $v->orderInfo = $v->OrderSkuRelation;
                $skus[$k]['ids'] = $v->id;
                $skus[$k]['orderInfo']['goods_money'] = $v->orderInfo->quantity * $v->orderInfo->price;
            }
            return ajax_json(1, 'ok', $skus);
        }else{
            return ajax_json(0, 'error', '该时间段暂无数据！');
        }



    }

//    保存渠道收款单

    public function storeChannel(Request $request){
            $distributorPayment=new DistributorPaymentModel();
            $distributorPayment->distributor_user_id=$request->input('distributor_user_id');
            $distributorPayment->start_time = $request->input('start_times');
            $distributorPayment->end_time = $request->input('end_times');
            $distributorPayment->price = $request->input('skuTotalFee');
            $distributorPayment->user_id = Auth::user()->id;
            $numbers = CountersModel::get_number('QD');//渠道
                if ($numbers == false) {
                    return false;
                }
            $distributorPayment->number = $numbers;
            $result = $distributorPayment->save();

            $sku_id = array_values($request->input('sku_id'));
            $sku_name=array_values($request->input('sku_name'));
            $sku_number=array_values($request->input('sku_number'));
            $quantity=array_values($request->input('quantity'));
            $price=array_values($request->input('price'));
            $number= array_values($request->input('number'));
            $prices=array_values($request->input('prices'));
            $start_time=array_values($request->input('start_time'));
            $end_time=array_values($request->input('end_time'));


             if ($result) {
                $target_id= $distributorPayment->id;
                $num = count($sku_id);

                for ($i = 0; $i < $num; $i++) {
                $paymentReceiptOrderDetail = new PaymentReceiptOrderDetailModel();
                $paymentReceiptOrderDetail->sku_id = $sku_id[$i];
                $paymentReceiptOrderDetail->sku_name = $sku_name[$i];
                $paymentReceiptOrderDetail->sku_number = $sku_number[$i];
                $paymentReceiptOrderDetail->quantity = $quantity[$i];
                $paymentReceiptOrderDetail->price = $price[$i];
                $paymentReceiptOrderDetail->type = 1;
                $paymentReceiptOrderDetail->target_id =$target_id;

                $favorables = [
                    'number' =>$number[$i],
                    'price' => $prices[$i],
                    'start_time' => $start_time[$i],
                    'end_time' => $end_time[$i]
                ];
                $paymentReceiptOrderDetail->favorable = json_encode($favorables);
                $paymentReceiptOrderDetail->save();
                 }
            return redirect('/receive/channellist');
            } else {
            return view('errors.503');
        }

    }

//    渠道收款单展示
    public function show(Request $request){
            $id=$request->id;
            $distributorPayment=DistributorPaymentModel::where('id',$id)->first();

            $user=new UserModel();
            $userId=UserModel::where('id',$distributorPayment->distributor_user_id)->first();
            $paymentReceiptOrderDetail=PaymentReceiptOrderDetailModel::where('target_id',$distributorPayment->id)->get();
            foreach ($paymentReceiptOrderDetail as $k=>$v){
                $favorable = json_decode($v->favorable,true);
                $paymentReceiptOrderDetail[$k]['number']=$favorable['number'];
                $paymentReceiptOrderDetail[$k]['prices']=$favorable['price'];
                $paymentReceiptOrderDetail[$k]['start_time']=$favorable['start_time'];
                $paymentReceiptOrderDetail[$k]['end_time']=$favorable['end_time'];
        }

        return view('home/receiveOrder.show', ['distributorPayment' => $distributorPayment,'userId'=>$userId,'paymentReceiptOrderDetail'=>$paymentReceiptOrderDetail]);

    }

    //    渠道收款单审核
    public function ajaxVerify(Request $request)
    {
        $id = $request->input('id')?$request->input('id'):'';

        $status = $request->input('status')?$request->input('status'):'';
            if (empty($id)){
                return ajax_json(1,'审核失败！');
            }
        $distributorPayment = DistributorPaymentModel::find($id);
        $this->distributor = new DistributorPaymentModel();

        $distributorPayment=$this->distributor->changeStatus($id,$status);
            if($distributorPayment){
                return ajax_json(1,'操作成功！');

            }else{
                return ajax_json(0,'操作失败！');

            }
    }


    public function edit(Request $request)
    {
        $user=new UserModel();
        $userlist=UserModel::where('supplier_distributor_type',1)->get();//拿到分销商

        $id=$request->input('id');
        $distributorPayment=DistributorPaymentModel::find($id);
        $uid=UserModel::where('id',$distributorPayment->distributor_user_id)->get();

        $paymentReceiptOrderDetail=PaymentReceiptOrderDetailModel::where('target_id',$distributorPayment->id)->where('type',1)->get();

        if ($paymentReceiptOrderDetail){
            foreach ($paymentReceiptOrderDetail as $k=>$v){
                $favorable = json_decode($v->favorable, true);
                $paymentReceiptOrderDetail[$k]['number'] = $favorable['number'];
                $paymentReceiptOrderDetail[$k]['prices'] = $favorable['price'];
                $paymentReceiptOrderDetail[$k]['price'] = sprintf("%.2f", $v['price']);//两位数
                $paymentReceiptOrderDetail[$k]['start_time'] = $favorable['start_time'];
                $paymentReceiptOrderDetail[$k]['end_time'] = $favorable['end_time'];
            }
            $sku_id = [];
            foreach ($paymentReceiptOrderDetail as $v) {
                $sku_id[] = $v->sku_id;
            }
            $count = count($paymentReceiptOrderDetail);
            $sku_id = implode(',', $sku_id);
        }
        return view('home/receiveOrder.editChannel',['userlist'=>$userlist,'paymentReceiptOrderDetail'=>$paymentReceiptOrderDetail,'distributorPayment'=>$distributorPayment,'sku_id'=>$sku_id,'count'=>$count,'uid'=>$uid]);

    }

    public function update(Request $request){

        $id = (int)$request->input('id');
        $distributor_user_id = $request->input('distributor_user_id');
        $start_times = $request->input('start_times');
        $end_times = $request->input('end_times');
        $total_price = $request->input('skuTotalFee');
        $user_id = Auth::user()->id;

        $sku_id = array_values($request->input('sku_id'));
        $sku_name = array_values($request->input('sku_name'));
        $sku_number = array_values($request->input('sku_number'));
        $quantity = array_values($request->input('quantity'));
        $price = array_values($request->input('price'));

        $number= array_values($request->input('number'));
        $prices=array_values($request->input('prices'));
        $start_time=array_values($request->input('start_time'));
        $end_time=array_values($request->input('end_time'));

        $distributorPayment = DistributorPaymentModel::find($id);
        $distributorPayment->distributor_user_id = $distributor_user_id;
        $distributorPayment->start_time = $start_times;
        $distributorPayment->end_time = $end_times;
        $distributorPayment->price = $total_price;
        $distributorPayment->user_id = $user_id;
        $result=$distributorPayment->save();
        if ($result) {
            DB::table('payment_receipt_order_detail')->where('target_id', $id)->where('type',1)->delete();

            $target_id= $distributorPayment->id;
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
                    'number' =>$number[$i],
                    'price' => $prices[$i],
                    'start_time' => $start_time[$i],
                    'end_time' => $end_time[$i]
                ];
                $paymentReceiptOrderDetail->favorable = json_encode($favorables);
                $paymentReceiptOrderDetail->save();
            }
            return redirect('/receive/channellist');
        } else {
            return ajax_json(0,'error');
        }


    }

    public function Destroy(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return ajax_json(0, 'error');
        }
        $distributorPayment = DistributorPaymentModel::find($id);
        if(!$distributorPayment){
            return ajax_json(0,'error');
        }
        $paymentReceiptOrderDetail=PaymentReceiptOrderDetailModel::where('target_id',$distributorPayment->id)->first();
        if(Auth::user()->hasRole(['admin']) && $distributorPayment->status < 4){//已完成的不能删除
            $distributorPayment->forceDelete();
            return ajax_json(1,'ok');
        }else{
            if($paymentReceiptOrderDetail->type = 1 && $distributorPayment->status < 4){
                $distributorPayment->forceDelete();
                $paymentReceiptOrderDetail->forceDelete();
                return ajax_json(1,'ok');
            }else{
                return ajax_json(0,'error');
            }
        }

    }
}
