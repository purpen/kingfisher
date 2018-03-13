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

use App\Http\Requests\AddPaymentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpSpec\Exception\Exception;

class paymentController extends Controller
{
    // 付款首页展示
    public function home(){
        $purchases = PurchaseModel::where('verified',2)->orderBy('id','desc')->paginate(20);
        
        $count = PurchaseModel::where('verified', 2)->count();
        
        $purchase = new PurchaseModel();
        $purchases = $purchase->lists($purchases);
        
        return view('home/payment.payment',[
            'purchases' => $purchases,
            'count' => $count,
            'subnav' => 'checkpay'
        ]);
    }

    /**
     * 应付款列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function payableList(){
        $payment = PaymentOrderModel::where('status', 0)->paginate(20);
        $money = PaymentOrderModel
            ::where('status', 0)
            ->select(DB::raw('sum(amount) as amount_sum'))
            ->first()->amount_sum;
        $count = PurchaseModel::where('verified', 2)->count();
        return view('home/payment.payable',[
            'payment' => $payment,
            'count' => $count,
            'subnav' => 'waitpay',
            'where' => '',
            'start_date' => '',
            'end_date' => '',
            'type' => '',
            'money' => $money,
        ]);
    }

    /**
     * 已付款列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function completeList()
    {
        $payment = PaymentOrderModel::where('status', 1)->orderBy('id','desc')->paginate(20);
        $count = PurchaseModel::where('verified', 2)->count();
        $money = PaymentOrderModel
            ::where('status', 1)
            ->select(DB::raw('sum(amount) as amount_sum'))
            ->first()->amount_sum;
        
        return view('home/payment.payable',[
            'payment' => $payment,
            'count' => $count,
            'subnav' => 'finishpay',
            'where' => '',
            'start_date' => '',
            'end_date' => '',
            'type' => '',
            'money' => $money,
        ]);
    }

    /**
     * 财务记账,生成入库单
     * @param Request $request
     * @return string
     */
    public function ajaxCharge(Request $request)
    {
        $ids = $request->input('id');
        DB::beginTransaction();
        foreach ($ids as $id){
            $purchase = new PurchaseModel();
            $status = $purchase->changeStatus($id,2);
            if(!$status)
            {
                DB::rollBack();
                return ajax_json(0,'记账失败');
            }

            if(!$this->purchaseCreatePayable($id))
            {
                DB::rollBack();
                return ajax_json(0,'记账失败');
            }

        }
        DB::commit();
        return  ajax_json(1,'记账成功');

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
        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        
        $count = PurchaseModel::where('verified', 2)->count();
        
        return view('home/payment.editPayable',[
            'payable' => $payable,
            'payment_account' => $payment_account,
            'count' => $count,
            'subnav' => '',
            'type' => '',
        ]);
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

        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        
        $count = PurchaseModel::where('verified', 2)->count();
        
        return view('home/payment.detailedPayment',[
            'payable' => $payable,
            'payment_account' => $payment_account,
            'count' => $count,
            'subnav' => '',
            'type' => '',
        ]);
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

        if($payment_order->status == 1 && !Auth::user()->hasRole('admin')){
            return "修改失败";
        }

        $payment_order->payment_account_id = $payment_account_id;
        $payment_order->summary = $summary;
        $payment_order->payment_time = $request->input('payment_time');
        $payment_order->order_number = $request->input('order_number');
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
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $subnav = $request->input('subnav');
        $type = $request->input('type');

        if($request->isMethod('get') && $request->input('time')){
            $time = $request->input('time');
            $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
            $end_date = date("Y-m-d H:i:s");
        }

        switch ($subnav){
            case 'waitpay':
                $status = 0;
                break;
            case 'finishpay':
                $status = 1;
                break;
        }
        $payment = PaymentOrderModel::where('status','=',$status);

        if($where){
            $payment->where('number','like','%'.$where.'%')
            ->orWhere('receive_user','like','%'.$where.'%')
            ->orWhere('number','like','%'.$where.'%');
        }

        if($start_date && $end_date){
            $start_date = date("Y-m-d H:i:s",strtotime($start_date));
            $end_date = date("Y-m-d H:i:s",strtotime($end_date));
            $payment->whereBetween('created_at', [$start_date, $end_date]);
        }
        if($type){
            $payment->where('type','=',$type);
        }

        $payment = $payment->paginate(20);

        $money = PaymentOrderModel::where('status','=',$status);
        if($where){
            $money->where('number','like','%'.$where.'%')
                ->orWhere('receive_user','like','%'.$where.'%')
                ->orWhere('number','like','%'.$where.'%');
        }

        if($start_date && $end_date){
            $start_date = date("Y-m-d H:i:s",strtotime($start_date));
            $end_date = date("Y-m-d H:i:s",strtotime($end_date));
            $money->whereBetween('created_at', [$start_date, $end_date]);
        }
        if($type){
            $money->where('type','=',$type);
        }
        $money = $money->select(DB::raw('sum(amount) as amount_sum'))
            ->first()->amount_sum;

        $count = PurchaseModel::where('verified', 2)->count();
        if($payment){
            return view('home/payment.payable',[
                'payment' => $payment,
                'subnav' => $subnav,
                'count' => $count,
                'where' => $where,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'type' => $type,
                'money' => $money,
            ]);
        }
    }

    /**
     * 创建付款单
     */
    public function create()
    {
        $payment_account = PaymentAccountModel::select(['account','id','bank'])->get();
        
        $count = PurchaseModel::where('verified', 2)->count();
        
        return view('home/payment.create', [
            'payment_account' => $payment_account,
            'count' => $count,
            'subnav' => '',
            'type' => '',
        ]);
    }

    /**
     *保存付款单
     */
    public function storePayment(AddPaymentRequest $request)
    {
        $paymentOrder = new PaymentOrderModel();
        $paymentOrder->amount = $request->input('amount');
        $paymentOrder->receive_user = $request->input('receive_user');
        $paymentOrder->type = $request->input('type');
        $paymentOrder->target_id = '';
        $paymentOrder->user_id = Auth::user()->id;
        $paymentOrder->payment_account_id = $request->input('payment_account_id');
        $paymentOrder->payment_time = $request->input('payment_time');
        $paymentOrder->summary = $request->input('summary');
        $number = CountersModel::get_number('FK');
        if($number == false){
            return false;
        }
        $paymentOrder->number = $number;
        if(!$paymentOrder->save()){
            return view('errors.503');
        }else{
            return redirect('/payment/payableList');
        }
    }

    /**
     * 删除付款单（自建的）
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $model = PaymentOrderModel::find($id);
        if(!$model){
            return ajax_json(0,'error');
        }

        if(Auth::user()->hasRole(['admin']) && $model->type > 2){
            $model->forceDelete();
            return ajax_json(1,'ok');
        }else{
            if($model->type > 2 && $model->status == 0){
                $model->forceDelete();
                return ajax_json(1,'ok');
            }else{
                return ajax_json(0,'error');
            }
        }
    }

}
