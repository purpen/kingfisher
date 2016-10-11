<?php

namespace App\Http\Controllers\Home;

use App\Models\CountersModel;
use App\Models\EnterWarehouseSkuRelationModel;
use App\Models\EnterWarehousesModel;
use App\Models\OrderModel;
use App\Models\PaymentAccountModel;
use App\Models\PaymentOrderModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\ReturnedPurchasesModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpSpec\Exception\Exception;

class paymentController extends Controller
{
    //付款首页展示
    public function home(){
        $purchases = PurchaseModel::where('verified',2)->orderBy('id','desc')->paginate(20);
        $count = PurchaseModel::where('verified',2)->count();
        $purchase = new PurchaseModel();
        $purchases = $purchase->lists($purchases);
        return view('home/payment.payment',['purchases' => $purchases,'count' => $count]);
    }

    /**
     * 应付款列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function payableList(){
        $payment = PaymentOrderModel::where('status',0)->paginate(20);
        foreach ($payment as $v){
            $target_number = null;
            switch ($v->type){
                case 1:
                    $target_number = $v->purchase->number;;
                    break;
                case 2:
                    $target_number = '退货';
                    break;
                default:
                    return "error";

            }
            $v->target_number = $target_number;
        }

        return view('home/payment.payable',['payment' => $payment]);
    }

    /**
     * 已付款列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function completeList()
    {
        $payment = PaymentOrderModel::where('status',1)->paginate(20);
        foreach ($payment as $v){
            $target_number = null;
            switch ($v->type){
                case 1:
                    $target_number = $v->purchase->number;
                    $type = '采购单';
                    break;
                case 2:
                    $target_number = '订单退换货';
                    $type = '订单退换货';
                    break;
                default:
                    return "error";

            }
            $v->target_number = $target_number;
            $v->type = $type;
        }

        return view('home/payment.completePayment',['payment' => $payment]);
    }

    /**
     * 财务记账,生成入库单
     * @param Request $request
     * @return string
     */
    public function ajaxCharge(Request $request)
    {
        $id = (int) $request->input('id');
        try{
            DB::beginTransaction();
            $purchase = new PurchaseModel();
            $status = $purchase->changeStatus($id,2);
            if(!$status)
            {
                DB::rollBack();
                return ajax_json(0,'记账失败');
            }
            
            $enter_warehouse_model = new EnterWarehousesModel();
            if (!$enter_warehouse_model->purchaseCreateEnterWarehouse($id))
            {
                DB::rollBack();
                return ajax_json(0,'记账失败');
            }
            if(!$this->purchaseCreatePayable($id))
            {
                DB::rollBack();
                return ajax_json(0,'记账失败');
            }
            
            DB::commit();
            return  ajax_json(1,'记账成功');
        }
        catch(\Exception $e){
            DB:roolBack();
            Log::error($e);
        }
    }

    /**
     * 财务驳回采购订单
     * @param Request $request
     * @return string
     */
    public function ajaxReject(Request $request)
    {
        $id = (int) $request->input('id');
        if(empty($id)){
            return ajax_json(0,'参数错误');
        }
        $purchaseModel = new PurchaseModel();
        if(!$purchaseModel->returnedChangeStatus($id)){
            $respond = ajax_json(0,'驳回失败');
        }else{
            $respond = ajax_json(1,'驳回成功');
        }
        return $respond;
    }

    /**
     * 财务记账 根据采购单生成付款单
     * @param $id int 采购单ID
     * @return bool
     */
    public function purchaseCreatePayable($id)
    {
        $paymentOrder = new PaymentOrderModel();
        
        $purchase = PurchaseModel::find($id);
        if (!$purchase){
            return false;
        }
        $paymentOrder->amount = $purchase->price;
        $paymentOrder->receive_user = $purchase->supplier->name;
        $paymentOrder->type = 1;
        $paymentOrder->target_id = $id;
        $paymentOrder->user_id = Auth::user()->id;
        $number = CountersModel::get_number('FK');
        if($number == false){
            return false;
        }
        $paymentOrder->number = $number;
        if(!$paymentOrder->save()){
            return false;
        }else{
            return true;
        }
    }


    /**
     * 付款单详情修改
     * @param Request $request int id 付款单ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function editPayable(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return '参数错误';
        }
        $payable = PaymentOrderModel::find($id);
        switch ($payable->type) {
            case 1:
                $payable->type = '采购单';
                $payable->target_number = $payable->purchase->number;
                break;
            case 2:
                $payable->type = '订单退换货';
                break;
            default:
                return "error";
        }
        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        return view('home/payment.editPayable',['payable' => $payable,'payment_account' => $payment_account]);
    }

    /**
     * 已付款单详情
     * @param Request $request int id 付款单ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function detailedPayment(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return '参数错误';
        }
        $payable = PaymentOrderModel::find($id);
        switch ($payable->type) {
            case 1:
                $payable->type = '采购单';
                $payable->target_number = $payable->purchase->number;
                break;
            case 2:
                $payable->type = '订单退换货';
                break;
            default:
                return "error";
        }

        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        return view('home/payment.detailedPayment',['payable' => $payable,'payment_account' => $payment_account]);
    }

    /**
     * 修改付款单信息
     * @param Request $request
     * @return string
     */
    public function updatePayable(Request $request)
    {
        $id = (int)$request->input('id');
        $payment_account_id = (int)$request->input('payment_account_id');
        $summary = $request->input('summary');
        $payment_order = PaymentOrderModel::find($id);
        $payment_order->payment_account_id = $payment_account_id;
        $payment_order->summary = $summary;
        $payment_order->payment_time = $request->input('payment_time');
        if(!$payment_order->save()){
           return "修改失败";
        }
        return redirect('/payment/payableList');
    }

    /**
     * 批量确认付款
     * @param Request $request
     * @return string json数据
     */
    public function ajaxConfirmPay(Request $request)
    {
        $arr_id = $request->input('arr_id');
        DB::beginTransaction();
        foreach ($arr_id as $id){
            if(empty($id)){
                DB::rollBack();
                return ajax_json(0,'参数错误');
            }
            $payment_order = PaymentOrderModel::find($id);
            if(!$payment_order){
                DB::rollBack();
                return ajax_json(0,'参数错误');
            }
            if(!$payment_order->changeStatus(1)){
                DB::rollBack();
                return ajax_json(0,'确认付款失败');
            }
        }
        DB::commit();
        return ajax_json(1,'确认成功');
    }

    /*
     * 财务付款搜索
     *
     */
    public function search(Request $request)
    {
        $where = $request->input('where');
        $payment = PaymentOrderModel::where('number','like','%'.$where.'%')
            ->orWhere('receive_user','like','%'.$where.'%')
            ->paginate(20);

        foreach ($payment as $v){
            $target_number = null;
            switch ($v->type){
                case 1:
                    $target_number = $v->purchase->number;
                    $type = '采购单';
                    break;
                case 2:
                    $target_number = '订单退换货';
                    $type = '订单退换货';
                    break;
                default:
                    return "error";

            }
            $v->target_number = $target_number;
            $v->type = $type;
        }
        if($payment){
            return view('home/payment.completePayment',['payment' => $payment]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
