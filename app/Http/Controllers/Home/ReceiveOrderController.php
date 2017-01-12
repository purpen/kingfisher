<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\AddReceiveRequest;
use App\Models\CountersModel;
use App\Models\OrderModel;
use App\Models\PaymentAccountModel;
use App\Models\ReceiveOrderModel;
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

}
