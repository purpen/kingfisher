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
    public function index()
    {
        $where = '';
        $receive = ReceiveOrderModel::where('status',0)->paginate(20);
        return view('home/receiveOrder.index',[
            'receive' => $receive,
            'where' => $where
        ]);
    }

    /**
     * 已收款
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function complete()
    {
        $where = '';
        $receive = ReceiveOrderModel::where('status',1)->paginate(20);
        return view('home/receiveOrder.completeReceive',[
            'receive' => $receive,
            'where' => $where
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
        return view('home/receiveOrder.editReceive',['receive' => $receive,'payment_account' => $payment_account]);
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
        $receive_order = ReceiveOrderModel::find($id);
        $receive_order->payment_account_id = $payment_account_id;
        $receive_order->summary = $summary;
        $receive_order->receive_time = $request->input('receive_time');
        if(!$receive_order->save()){
            return "修改失败";
        }
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
     *财务收款搜索
     */
    public function search(Request $request)
    {
        $where = $request->input('where');
        $receive = ReceiveOrderModel::where('number','like','%'.$where.'%')
            ->orWhere('payment_user','like','%'.$where.'%')
            ->orWhere('status',1)
            ->paginate(20);

        if($receive){
            return view('home/receiveOrder.completeReceive',[
                'receive' => $receive,
                'where' => $where
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
        return view('home/receiveOrder.create',['payment_account' => $payment_account]);
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
