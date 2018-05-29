<?php

namespace App\Http\Controllers\Home;

use App\Models\CountersModel;
use App\Models\EnterWarehouseSkuRelationModel;
use App\Models\EnterWarehousesModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\PaymentAccountModel;
use App\Models\PaymentOrderModel;
use App\Models\PaymentReceiptOrderDetailModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\ReceiveOrderModel;
use App\Models\ReturnedPurchasesModel;
use App\Models\SupplierModel;
use App\Models\SupplierReceiptModel;
use App\Models\User;
use App\Http\Requests;

use App\Http\Requests\AddPaymentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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


//    品牌付款单start


    //创建品牌付款单
    public function brand()
    {
        $supplier = new SupplierModel();  //供应商列表
        $suppliers = $supplier->lists();
        return view('home/payment.brand', ['suppliers' => $suppliers]);
    }


    //获取订单明细
    public function ajaxBrand(Request $request)
    {
        $supplier_id = $request->input('supplier_id');
        $start_time = $request->input('start_times');
        $end_time = $request->input('end_times');
        $skus = OrderModel::where(['supplier_id'=>$supplier_id])->get();
//        通过指定时间段拿取数据：
//        $skus = OrderModel::where(['supplier_id'=>$supplier_id])->whereBetween('created_at',[$start_time,$end_time])->get();
        if ($skus){
            foreach ($skus as $k=>$list) {
                $list->orderInfo = $list->OrderSkuRelation;
//                $skus[$k]['ids']=$k;
                $skus[$k]['ids']=$list->id;
                $skus[$k]['orderInfo']['goods_money'] = $list->orderInfo->quantity * $list->orderInfo->price;
            }
        }else{
            return ajax_json(0, 'error', '该时间段暂无数据！');
        }
        return ajax_json(1, 'ok', $skus);
    }

    public function storeBrand(Request $request)
    {

        //保存品牌付款单
        $supplierReceipt=new SupplierReceiptModel();
        $supplierReceipt->supplier_user_id = $request->input('supplier_id');
        $supplierReceipt->start_time = $request->input('start_times');
        $supplierReceipt->end_time = $request->input('end_times');
        $supplierReceipt->total_price = $request->input('skuTotalFee');
        $supplierReceipt->user_id = Auth::user()->id;
        $numbers = CountersModel::get_number('PP');//品牌
            if ($numbers == false) {
                return false;
            }
        $supplierReceipt->number = $numbers;
        $result = $supplierReceipt->save();
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
            $target_id= $supplierReceipt->id;
            $num = count($sku_id);

            for ($i = 0; $i < $num; $i++) {
                $paymentReceiptOrderDetail = new PaymentReceiptOrderDetailModel();
                $paymentReceiptOrderDetail->sku_id = $sku_id[$i];
                $paymentReceiptOrderDetail->sku_name = $sku_name[$i];
                $paymentReceiptOrderDetail->sku_number = $sku_number[$i];
                $paymentReceiptOrderDetail->quantity = $quantity[$i];
                $paymentReceiptOrderDetail->price = $price[$i];
                $paymentReceiptOrderDetail->type = 2;
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
            return redirect('/payment/brandlist');
        } else {
            return view('errors.503');
        }
    }


    public function brandIndex(Request $request)
    {
        $this->tab_menu = 'default';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->brandlist(null);
    }

    /**
     * 待关联人列表
     */
//    public function guanlianrenList(Request $request)
//    {
//        $this->tab_menu = 'guanlianlish';
//        $this->per_page = $request->input('per_page', $this->per_page);
//        return $this->brandlist(0);
//    }
    /**
     * 待采购确认列表
     */
    public function unpublishList(Request $request)
    {
        $this->tab_menu = 'unpublish';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->brandlist(1);
    }

    /**
     * 待供应商确认列表
     */
    public function saleList(Request $request)
    {
        $this->tab_menu = 'saled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->brandlist(2);
    }

    /**
     * 待确认付款列表
     */
    public function cancList(Request $request)
    {
        $this->tab_menu = 'canceled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->brandlist(3);
    }
    /**
     * 完成列表
     */
    public function overList(Request $request)
    {
        $this->tab_menu = 'overled';
        $this->per_page = $request->input('per_page', $this->per_page);
        return $this->brandlist(4);
    }



    public function brandlist($status=null)
    {
        //付款单列表
        if ($status === null){//变量值与类型完全相等
            $brandlist = SupplierReceiptModel::orderBy('id','desc')->paginate($this->per_page);
        }else{
            $brandlist = SupplierReceiptModel::where('status',$status)->orderBy('id','desc')->paginate($this->per_page);
        }
        $supplier = new SupplierModel();  //供应商列表
        if ($brandlist) {
            foreach ($brandlist as $k => $v) {
                $supplier=SupplierModel::where('id',$v->supplier_user_id)->first();
                $brandlist[$k]['name'] = $supplier->nam;

            }
        }
        return view('home/payment.brandlist',[
            'brandlist' => $brandlist,
            'tab_menu' => $this->tab_menu,
        ]);
    }

//    品牌付款单审核
    public function ajaxVerify(Request $request)
    {
        $id = $request->input('id')?$request->input('id'):'';

        $status = $request->input('status')?$request->input('status'):'';
        if (empty($id)){
            return ajax_json(1,'审核失败！');
        }
        $supplierReceipt = SupplierReceiptModel::find($id);
        $this->SupplierReceip = new SupplierReceiptModel();

//        $res = DB::update("update supplier_receipt set status=2 WHERE id='$id'");
        $supplierReceipt=$this->SupplierReceip->changeStatus($id,$status);
        if($supplierReceipt){
            return ajax_json(1,'操作成功！');

        }else{
            return ajax_json(0,'操作失败！');

        }

    }

    //品牌付款单详情
    public function show(Request $request){

        $id=$request->id;
        $supplierReceipt=SupplierReceiptModel::where('id',$id)->first();

        $supplier=new SupplierModel();
        $supplierId=SupplierModel::where('id',$supplierReceipt->supplier_user_id)->first();
        $paymentReceiptOrderDetail=PaymentReceiptOrderDetailModel::where('target_id',$supplierReceipt->id)->get();
            foreach ($paymentReceiptOrderDetail as $k=>$v){
                $favorable = json_decode($v->favorable,true);
                $paymentReceiptOrderDetail[$k]['number']=$favorable['number'];
                $paymentReceiptOrderDetail[$k]['prices']=$favorable['price'];
                $paymentReceiptOrderDetail[$k]['start_time']=$favorable['start_time'];
                $paymentReceiptOrderDetail[$k]['end_time']=$favorable['end_time'];
            }

        return view('home/payment.showBrand', ['supplierReceipt' => $supplierReceipt,'supplierId'=>$supplierId,'paymentReceiptOrderDetail'=>$paymentReceiptOrderDetail]);
    }

    //渠道付款单修改
    public function edit(Request $request){
        $supplier = new SupplierModel();  //供应商列表
        $suppliers = $supplier->lists();

        $id=$request->input('id');
        $supplierReceipt=SupplierReceiptModel::find($id);
        $supplier_id=SupplierModel::where('id',$supplierReceipt->supplier_user_id)->get();

        $paymentReceiptOrderDetail=PaymentReceiptOrderDetailModel::where('target_id',$supplierReceipt->id)->where('type',2)->get();
        if ($paymentReceiptOrderDetail) {
            foreach ($paymentReceiptOrderDetail as $k => $v) {
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
        return view('home/payment.editBrand', ['suppliers' => $suppliers,'supplierReceipt'=>$supplierReceipt,'paymentReceiptOrderDetail'=>$paymentReceiptOrderDetail,'sku_id' => $sku_id,"count" => $count,'supplier_id'=>$supplier_id]);

    }

    //渠道付款单更新
    public function update(Request $request)
    {
            $id = (int)$request->input('id');
            $supplier_user_id = $request->input('supplier_id');
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

            $supplierReceipt = SupplierReceiptModel::find($id);
            $supplierReceipt->supplier_user_id = $supplier_user_id;
            $supplierReceipt->start_time = $start_times;
            $supplierReceipt->end_time = $end_times;
            $supplierReceipt->total_price = $total_price;
            $supplierReceipt->user_id = $user_id;
            $result=$supplierReceipt->save();
            if ($result) {
                DB::table('payment_receipt_order_detail')->where('target_id', $id)->where('type',2)->delete();

                $target_id= $supplierReceipt->id;
                $num = count($sku_id);
                for ($i = 0; $i < $num; $i++) {
                    $paymentReceiptOrderDetail = new PaymentReceiptOrderDetailModel();
                    $paymentReceiptOrderDetail->sku_id = $sku_id[$i];
                    $paymentReceiptOrderDetail->sku_name = $sku_name[$i];
                    $paymentReceiptOrderDetail->sku_number = $sku_number[$i];
                    $paymentReceiptOrderDetail->quantity = $quantity[$i];
                    $paymentReceiptOrderDetail->price = $price[$i];
                    $paymentReceiptOrderDetail->type = 2;
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
                return redirect('/payment/brandlist');
         } else {
                return ajax_json(0,'error');
            }
    }


    /**
     * 删除品牌付款单
     */
    public function Destroy(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return ajax_json(0, 'error');
        }
        $supplierReceipt = SupplierReceiptModel::find($id);
        if(!$supplierReceipt){
            return ajax_json(0,'error');
        }
        $paymentReceiptOrderDetail=PaymentReceiptOrderDetailModel::where('target_id',$supplierReceipt->id)->first();
        if(Auth::user()->hasRole(['admin']) && $supplierReceipt->status < 4){//已完成的不能删除
            $supplierReceipt->forceDelete();
       //$paymentReceiptOrderDetail->forceDelete();
            return ajax_json(1,'ok');
        }else{
            if($paymentReceiptOrderDetail->type = 2 && $supplierReceipt->status < 4){
                $supplierReceipt->forceDelete();
                $paymentReceiptOrderDetail->forceDelete();
                return ajax_json(1,'ok');
            }else{
                return ajax_json(0,'error');
            }
        }
    }
}
