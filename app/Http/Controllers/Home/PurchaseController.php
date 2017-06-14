<?php

namespace App\Http\Controllers\Home;

use App\Models\AssetsModel;
use App\Models\CountersModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\ReturnedPurchasesModel;
use App\Models\StorageModel;
use App\Models\StorageSkuCountModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    // 默认值
    public $verified = 0;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->tab_menu = 'all';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list();
    }
    
    /**
     * 查询页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchaseStatus(Request $request)
    {
        $this->verified = $request->input('verified', 0);
        $this->per_page = $request->input('per_page', $this->per_page);
        
        if ($this->verified == 1) {
            $this->tab_menu = 'approved';
        } else {
            $this->tab_menu = 'finished';
        }
        
        return $this->display_tab_list();
    }
    
    /**
     * 显示列表
     */
    protected function display_tab_list()
    {
        $where = '';
        $purchases = PurchaseModel::where('verified', $this->verified)->orderBy('id','desc')->paginate(20);
        $count = $this->count();

        $purchase = new PurchaseModel;
        $purchases = $purchase->lists($purchases);
        
        return view('home/purchase.purchase',[
            'purchases' => $purchases,
            'count' => $count,
            'verified' => $this->verified,
            'tab_menu' => $this->tab_menu,
            'where' => $where
        ]);
    }
    
    /**
     * 采购单各状态统计
     * @return array
     */
    protected function count()
    {
        $count = [];
        
        $count['waiting'] = PurchaseModel::where('verified', 0)->count();  //待审核统计
        $count['directing'] = PurchaseModel::where('verified', 1)->count();  //业务主管统计
        $count['finaning'] = PurchaseModel::where('verified', 2)->count();  //财务审核
        
        return $count;
    }

    

    /**
     * 建表人审核
     * @param Request $request
     * @return string
     */
    public function ajaxVerified(Request $request)
    {
        $id_arr = $request->input('id');
        foreach ($id_arr as $id) {
            $purchase = new PurchaseModel();
            $status = $purchase->changeStatus($id,0);
            if (!$status) {
                return ajax_json(0,'error');
            }
        }
        
        return ajax_json(1,'审核成功');
    }

    /**
     * 主管审核通过采购订单
     * @param Request $request
     * @return string
     */
    public function ajaxDirectorVerified(Request $request)
    {
        $id_arr = $request->input('id');
        foreach($id_arr as $id){
            $purchase = new PurchaseModel();
            $status = $purchase->changeStatus($id,1);
            if (!$status) {
                return ajax_json(0,'审核失败');
            } 
        }
        
        return ajax_json(1,'审核成功');
    }
    
    /**
     * 主管驳回采购订单
     * @param Request $request
     * @return string
     */
    public function ajaxDirectorReject(Request $request){
        $id_arr = $request->input('id');
        if(empty($id_arr)){
            return ajax_json(0,'参数错误');
        }
        
        $purchaseModel = new PurchaseModel();
        foreach ($id_arr as $id){
            if(!$purchaseModel->returnedChangeStatus($id)){
                return ajax_json(0, '驳回失败');
            }
        }
        
        return ajax_json(1,'ok');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $supplier = new SupplierModel();  //供应商列表
        $suppliers = $supplier->lists();

        $storage = new StorageModel();    //仓库列表
        $storages = $storage->storageList(1);

        return view('home/purchase.createPurchase',['suppliers' => $suppliers,'storages' => $storages]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request)
    {
        try{
            $supplier_id = $request->input('supplier_id');
            $storage_id = $request->input('storage_id');
            $department = (int)$request->input('department');
            $sku_id = $request->input('sku_id');
            $counts = $request->input('count');
            $prices = $request->input('price');
            $summary = $request->input('summary');
            $type = $request->input('type');

            $tax_rates = $request->input('tax_rate');
            $freights = $request->input('freight');

            $predict_time = $request->input('predict_time');
            $surcharge = $request->input('surcharge');
            $invoice_info = $request->input('invoice_info' , '');
            $sum_count = '';
            $sum_price = '';
            $sum_tax_rate = '';
            $sum_freight = '';
            for($i=0;$i<count($sku_id);$i++){
                $sum_count += $counts[$i];
                $sum_tax_rate += $tax_rates[$i];
                $sum_freight += $freights[$i];
                $sum_price += $prices[$i]*100*$counts[$i] + $freights[$i]*100;
            }
            DB::beginTransaction();
            $purchase = new PurchaseModel();
            $purchase->supplier_id = $supplier_id;
            $purchase->storage_id = $storage_id;
            $purchase->department = $department;
            $purchase->count = $sum_count;
            $purchase->price = $sum_price/100 + $surcharge;
            $purchase->summary = $summary;
            $purchase->type = $type;
            $purchase->predict_time = $predict_time;
            $purchase->surcharge = $surcharge;
            $purchase->user_id = Auth::user()->id;
            $purchase->invoice_info = $invoice_info;
            if(!$number = CountersModel::get_number('CG')){
                DB::rollBack();
                return view('errors.503');
            }
            $purchase->number = $number;
            if($purchase->save()){
                $purchase_id = $purchase->id;
                for ($i=0;$i<count($sku_id);$i++){
                    $purchaseSku = new PurchaseSkuRelationModel();
                    $purchaseSku->purchase_id = $purchase_id;
                    $purchaseSku->sku_id = $sku_id[$i];
                    $purchaseSku->price = $prices[$i];
                    $purchaseSku->count = $counts[$i];
                    $purchaseSku->tax_rate = $tax_rates[$i];
                    $purchaseSku->freight = $freights[$i];
                    $purchaseSku->save();
                }
                DB::commit();
                return redirect('/purchase');
            }else{
                DB::rollBack();
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        $purchase = PurchaseModel::find($id);
        $purchase->supplier = $purchase->supplier->name;
        $purchase->storage = $purchase->storage->name;
        $purchase_sku_relation = PurchaseSkuRelationModel::where('purchase_id',$purchase->id)->get();
        $productsSku = new ProductsSkuModel;
        $purchase_sku_relation = $productsSku->detailedSku($purchase_sku_relation);
        
        return view('home/purchase.showPurchase',['purchase' => $purchase,'purchase_sku_relation' => $purchase_sku_relation]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $supplier = new SupplierModel();  //供应商列表
        $suppliers = $supplier->lists();

        $storage = new StorageModel();    //仓库列表
        $storages = $storage->storageList(1);
        
        $id = $request->input('id');
        $purchase = PurchaseModel::find($id);
        $purchase_sku_relation = PurchaseSkuRelationModel::where('purchase_id',$purchase->id)->get();
        $productsSku = new ProductsSkuModel;
        $purchase_sku_relation = $productsSku->detailedSku($purchase_sku_relation);
        $url = $_SERVER['HTTP_REFERER'];
        if(!Cookie::has('purchase_back_url')){
            Cookie::queue('purchase_back_url', $url, 60);  //设置修改完成转跳url
        }
        
        return view('home/purchase.editPurchase',['suppliers' => $suppliers,'storages' => $storages,'purchase' => $purchase,'purchase_sku_relation' => $purchase_sku_relation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseRequest $request)
    {
        try{
            $purchase_id = $request->input('purchase_id');
            $supplier_id = $request->input('supplier_id');
            $storage_id = $request->input('storage_id');
            $department = (int)$request->input('department');
            $sku_id = $request->input('sku_id');
            $counts = $request->input('count');
            $prices = $request->input('price');

            $tax_rates = $request->input('tax_rate');
            $freights = $request->input('freight');

            $summary = $request->input('summary');
            $predict_time = $request->input('predict_time');
            $surcharge = $request->input('surcharge');
            $invoice_info = $request->input('invoice_info');

            $sum_count = '';
            $sum_price = '';
            $sum_tax_rate = '';
            $sum_freight = '';
            for($i=0;$i<count($sku_id);$i++){
                $sum_tax_rate += $tax_rates[$i];
                $sum_freight += $freights[$i];
                $sum_count += $counts[$i];
                $sum_price += $prices[$i]*100*$counts[$i] + $freights[$i]*100;
            }
            DB::beginTransaction();
            $purchase = PurchaseModel::find($purchase_id);
            $purchase->supplier_id = $supplier_id;
            $purchase->storage_id = $storage_id;
            $purchase->department = $department;
            $purchase->count = $sum_count;
            $purchase->price = $sum_price/100 + $surcharge;
            $purchase->summary = $summary;
            $purchase->predict_time = $predict_time;
            $purchase->surcharge = $surcharge;
            $purchase->user_id = Auth::user()->id;
            $purchase->invoice_info = $invoice_info;
            if($purchase->save()){
                DB::table('purchase_sku_relation')->where('purchase_id',$purchase_id)->delete();
                for ($i=0;$i<count($sku_id);$i++){
                    $purchaseSku = new PurchaseSkuRelationModel();
                    $purchaseSku->purchase_id = $purchase_id;
                    $purchaseSku->sku_id = $sku_id[$i];
                    $purchaseSku->price = $prices[$i];
                    $purchaseSku->count = $counts[$i];
                    $purchaseSku->tax_rate = $tax_rates[$i];
                    $purchaseSku->freight = $freights[$i];
                    $purchaseSku->save();
                }
                DB::commit();
                $url = Cookie::get('purchase_back_url');
                Cookie::forget('purchase_back_url');
                return redirect($url);
            }else{
                DB::rollBack();
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
        }
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

    /**
     * @param Request $request
     * @return bool|string
     */
    /**
     * 1、采购单/采购明细、付款单、入库单/明细（已入库数量从对应仓库库存删除）、采购退货单/明细、出库单/明细(已出库数量增加回对应仓库)、收款单。
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return ajax_json(0,'error');
        }
        $purchaseModel = PurchaseModel::find($id);

        if(!$purchaseModel){
            return ajax_json(0,'error');
        }

        if(Auth::user()->hasRole(['admin'])){
            //付款单模型,
            $paymentModel = $purchaseModel->paymentOrder;
            if($paymentModel){
                $paymentModel->forceDelete();
            }

            //入库单模型
            $enterWarehousesModel = $purchaseModel->enterWarehouses;
            if($enterWarehousesModel){
                //仓库ID
                $storage_id = $enterWarehousesModel->storage_id;

                $enterWarehouseSkus = $enterWarehousesModel->enterWarehouseSkus;

                //已入库数量从对应仓库库存删除
                if(!$enterWarehouseSkus->isEmpty()){
                    foreach($enterWarehouseSkus as $info){
                        if($in_count = $info->in_count){

                            $storageSkuCountModel = StorageSkuCountModel
                                ::where(['storage_id' => $storage_id, 'sku_id' => $info->sku_id])
                                ->first();
                            $storageSkuCountModel->count = $storageSkuCountModel->count - $in_count;
                            if(!$storageSkuCountModel->save()){
                                return 'error1';
                            }
                        }
                    }

                }
                foreach ($enterWarehouseSkus as $v){
                    $v->forceDelete();
                }
                $enterWarehousesModel->forceDelete();
            }

            //对应采购退货单
            $returnedPurchasesModel = ReturnedPurchasesModel::where(['purchase_id' => $id])->get();
            if(!$returnedPurchasesModel->isEmpty()){
                foreach ($returnedPurchasesModel as $returnedPurchase){

                    // 收款单
                    $receiveOrder = $returnedPurchase->receiveOrder;
                    if($receiveOrder){
                        $receiveOrder->forceDelete();
                    }

                    // 出库单模型
                    $outWarehouses = $returnedPurchase->outWarehouses;
                    if($outWarehouses){
                        //仓库ID
                        $storage_id = $outWarehouses->storage_id;

                        $outWarehouseSkuRelation = $outWarehouses->outWarehouseSkuRelation;

                        //已出库的数量 增加到对应仓库库存
                        if(!$outWarehouseSkuRelation->isEmpty()){
                            foreach($outWarehouseSkuRelation as $info){
                                if($out_count = $info->out_count){

                                    $storageSkuCountModel = StorageSkuCountModel
                                        ::where(['storage_id' => $storage_id, 'sku_id' => $info->sku_id])
                                        ->first();
                                    $storageSkuCountModel->count = $storageSkuCountModel->count + $out_count;
                                    if(!$storageSkuCountModel->save()){
                                        return 'error2';
                                    }
                                }
                            }

                        }
                        foreach ($outWarehouseSkuRelation as $v){
                            $v->forceDelete();
                        }
                        $outWarehouses->forceDelete();
                    }
                }

                // 删除采购退货单明细
                foreach ($returnedPurchasesModel as $returnedPurchase){
                    $returnedSkuRelation = $returnedPurchase->returnedSkuRelation;
                    if($returnedSkuRelation){
                        foreach ($returnedSkuRelation as $v){
                            $v->forceDelete();
                        }
                    }
                }
                // 删除采购退货单
                foreach ($returnedPurchasesModel as $v){
                    $v->forceDelete();
                }
            }

            //删除采购单明细
            $purchaseSku = $purchaseModel->purchaseSku;
            if($purchaseSku){
                foreach ($purchaseSku as $v){
                    $v->forceDelete();
                }
            }
            //删除采购单
            $purchaseModel->forceDelete();

            return ajax_json(1,'ok');
        }else{
            $purchaseModel->forceDelete();
            PurchaseSkuRelationModel::where('purchase_id',$id)->forceDelete();
            return ajax_json(1,'ok');
        }

    }

    /**
     * 采购订单搜索
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $where = $request->input('where');
        $purchases = PurchaseModel::where('number','like','%'.$where.'%')
            ->paginate(20);
        $count = $this->count();
        $purchase = new PurchaseModel;
        $purchases = $purchase->lists($purchases);
        return view('home/purchase.purchase',[
            'purchases' => $purchases,
            'count' => $count,
            'verified' => $this->verified,
            'tab_menu' => $this->tab_menu,
            'where' => $where
        ]);
    }

    /**
     * 创建采购退货单跳转
     */
    public function ajaxReturned(Request $request)
    {
        $id = $request->input('id');
        $purchase_model = PurchaseModel::find($id[0]);
        if(!$purchase_model){
            $number = '';
        }

        /*判断采购单是否完成入库*/
        if($purchase_model->storage_status != 5){
            return ajax_json(0,'采购单未完成入库');
        }
        $number = $purchase_model->number;
        /*拼接跳转链接*/
        $url = url('returned/create') . '?number=' . $number;
        return ajax_json(1,'ok',$url);
    }

    /**
     * 采购订单列表
     */
    public function lists(Request $request)
    {
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = PurchaseModel::query();
        $purchases = $lists->paginate($per_page);
        foreach ($purchases as $purchase){
            $purchase->purchaseIndex($purchase);

        }
        return view('home/monitorLists.purchases',[
            'purchases' => $purchases,
        ]);
    }
    /**
     * 采购订单详情
     */
    public function showPurchases(Request $request)
    {
        $id = $request->input('id');
        $purchase = PurchaseModel::where('id' , $id)->first();
        $purchase_sku_relations = $purchase->purchaseSku;

        return view('home/monitorDetails.purchase',[
            'purchase' => $purchase,
            'purchase_sku_relations' => $purchase_sku_relations,
        ]);

    }

    /**
     * 采购发票列表
     */
    public function invoicesLists(Request $request)
    {
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = PurchaseModel::query();
        $purchases = $lists->paginate($per_page);
        foreach ($purchases as $purchase){
            $purchase->purchaseIndex($purchase);

        }
        return view('home/monitorLists.pInvoices',[
            'purchases' => $purchases,
        ]);
    }

    /**
     *  采购发票详情
     */
    public function showPInvoices(Request $request)
    {
        $id = $request->input('id');
        $pInvoice = PurchaseModel::where('id' , $id)->first();
        $purchase_sku_relations = $pInvoice->purchaseSku;

        return view('home/monitorDetails.pInvoice',[
            'pInvoice' => $pInvoice,
            'purchase_sku_relations' => $purchase_sku_relations,

        ]);
    }
}
