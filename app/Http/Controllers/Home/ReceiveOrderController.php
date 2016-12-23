<?php

namespace App\Http\Controllers\Home;

use App\Models\OrderModel;
use App\Models\PaymentAccountModel;
use App\Models\ReceiveOrderModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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

        foreach ($receive as $v){
            $target_number = null;
            switch ($v->type){
                case 3:
                    if($v->order){
                        $target_number = $v->order->number;
                    }else{
                        $target_number = '';
                    }
                    $type = '订单';
                    break;
                case 4:
                    $target_number = $v->returnedPurchase->number;
                    $type = '采购退货';
                    break;
                default:
                    return "error";

            }
            $v->target_number = $target_number;
            $v->type = $type;
        }
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

        foreach ($receive as $v){
            $target_number = null;
            switch ($v->type){
                case 3:
                    if($v->order){
                        $target_number = $v->order->number;
                    }else{
                        $target_number = '';
                    }
                    $type = '订单';
                    break;
                case 4:
                    $target_number = $v->returnedPurchase->number;
                    $type = '采购退货';
                    break;
                default:
                    return "error";
            }
            $v->target_number = $target_number;
            $v->type = $type;
        }
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
        switch ($receive->type) {
            case 3:
                $receive->type = '订单';
                $receive->target_number = $receive->order->number;
                break;
            case 4:
                $receive->type = '采购退货';
                $receive->target_number = $receive->returnedPurchase->number;
                break;
            default:
                return "error";
        }
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
        switch ($receive->type) {
            case 3:
                $receive->type = '订单';
                if($receive->order){
                    $receive->target_number = $receive->order->number;
                }else{
                    $receive->target_number = '';
                }
                break;
            case 4:
                $receive->type = '采购退货';
                $receive->target_number = $receive->returnedPurchase->number;
                break;
            default:
                return "error";
        }
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
        foreach ($receive as $v){
            $target_number = null;
            switch ($v->type){
                case 3:
                    $target_number = $v->order->number;
                    $type = '订单';
                    break;
                case 4:
                    $target_number = $v->returnedPurchase->number;
                    $type = '采购退货';
                    break;
                default:
                    return "error";

            }
            $v->target_number = $target_number;
            $v->type = $type;
        }
        if($receive){
            return view('home/receiveOrder.completeReceive',[
                'receive' => $receive,
                'where' => $where
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
