<?php

namespace App\Http\Controllers\Home;

use App\Models\OrderModel;
use App\Models\OutWarehousesModel;
use App\Models\PurchaseModel;
use App\Models\ReceiveOrderModel;
use App\Models\ReturnedPurchasesModel;
use App\Models\ReturnedSkuRelationModel;
use App\Models\StorageSkuCountModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use App\Http\Requests\ReturnedPurchaseRequest;
use App\Http\Requests\UpdataReturnedPurchaseRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StorageModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\ProductsSkuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CountersModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class ReturnedPurchaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        $this->per_page = $request->input('per_page', $this->per_page);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->tab_menu = 'waiting';
        
        return $this->display_tab_list();
    }
    
    /**
     * 1.业管主管；9.通过 退货订单查询列表页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function returnedStatus(Request $request)
    {
        $verified = $request->input('verified');
        
        if ($verified == 1) {
            $this->tab_menu = 'approved';
        } else {
            $this->tab_menu = 'finished';
        }
        
        return $this->display_tab_list($verified);
    }
    
    /**
     * 显示列表
     */
    public function display_tab_list($verified=0)
    {
        $returneds = ReturnedPurchasesModel::where('verified', $verified)->orderBy('id','desc')->paginate($this->per_page);
        
        $purchase = new PurchaseModel;
        $returneds = $purchase->lists($returneds);
        
        $count = $this->count();
        
        return view('home.purchase.returned', [
            'returneds' => $returneds,
            'verified' => $verified,
            'count' => $count,
            'tab_menu' => $this->tab_menu,
            'q' => ''
        ]);
    }
    
    /*
     * 搜索列表
     */
    public function search(Request $request)
    {
        $verified = 0;
        $q = $request->input('q');
        
        $returneds = ReturnedPurchasesModel::where('number','like','%'.$q.'%')->paginate(20);
        
        $purchase = new PurchaseModel;
        $returneds = $purchase->lists($returneds);
        
        $count = $this->count();
        
        return view('home.purchase.returned', [
            'returneds' => $returneds , 
            'count' => $count,
            'verified' => $verified,
            'tab_menu' => $this->tab_menu,
            'q' => $q
        ]);
    }

    /**
     * 采购退货单各状态统计
     * @return array
     */
    protected function count()
    {
        $count = [];
        
        $count['waiting'] = ReturnedPurchasesModel::where('verified',0)->count();  //待审核
        $count['approved'] = ReturnedPurchasesModel::where('verified',1)->count();  //业务主管审核
        
        return $count;
    }


    /**
     * 采购退货货单填单人审核
     *
     * @param Request $request
     * @return string
     */
    public function ajaxVerified(Request $request)
    {
        $ids = $request->input('id');
        
        if (empty($ids)) {
            return ajax_json(0, '参数错误');
        }
        
        foreach ($ids as $id) {
            $returnedModel = new ReturnedPurchasesModel();
            $status = $returnedModel->changeStatus($id, 0);
            if (!$status) {
                return ajax_json(0, '审核失败');
            }
        }
        
        return ajax_json(1, '审核成功');
    }

    /**
     * 主管驳回采购退货订单
     * @param Request $request
     * @return string
     */
    public function ajaxDirectorReject(Request $request)
    {
        $ids = $request->input('id');
        if (empty($ids)) {
            return ajax_json(0, '参数错误');
        }
        
        foreach ($ids as $id) {
            $ReturnedModel = new ReturnedPurchasesModel();
            if (!$ReturnedModel->returnedChangeStatus($id)) {
                return ajax_json(0, '驳回失败');
            }
        }
        
        return ajax_json(1, '驳回成功');
    }
    
    /**
     * 主管审核通过退货订单
     *
     * @param Request $request
     * @return string
     */
    public function ajaxDirectorVerified(Request $request)
    {
        $ids = $request->input('id');
        if (empty($ids)) {
            return ajax_json(0, '参数错误');
        }
        
        try {
            DB::beginTransaction();
            foreach ($ids as $id) {
                $returnedModel = new ReturnedPurchasesModel();
                $status = $returnedModel->changeStatus($id, 1);

                if (!$status) {
                    DB::rollBack();
                    return ajax_json(0, '审核失败');
                }

                $outWarehouseModel = new OutWarehousesModel();
                if (!$outWarehouseModel->returnedCreateOutWarehouse($id)) {
                    DB::rollBack();
                    return ajax_json(0, '出库单生成失败');
                }

                $receive = new ReceiveOrderModel();
                if (!$receive->returnedCreateReceiveOrder($id)) {
                    DB::rollBack();
                    return ajax_json(0, '生成收款单失败');
                }
            }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            return ajax_json(0, 'error',$e);
        }
        
        return ajax_json(1, '审核成功');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create1(Request $request)
    {
        $purchase_order_number = $request->input('number','');
        // 仓库列表
        $storage = new StorageModel();    
        $storages = $storage->storageList(1);
        
        return view('home.purchase.createReturned', [
            'storages' => $storages,
            'tab_menu' => $this->tab_menu,
            'count' => $this->count(),
            'purchase_order_number' => $purchase_order_number,
        ]);
    }*/
    
    public function create(Request $request)
    {
        $purchase_order_number = $request->input('number');
        // 仓库列表
        $storage = new StorageModel();
        $storages = $storage->storageList(1);
        
        $purchase = PurchaseModel::where('number',$purchase_order_number)->first();
        if(!$purchase){
            return view('errors.503');
        }

        //存在订单商品的仓库ID 数组
        $storage_array = [];
        foreach ($purchase->purchaseSku as $v){
            $storage_id_array = StorageSkuCountModel::select('storage_id')->where('sku_id',$v->sku_id)->groupBy('storage_id')->lists('storage_id');

            foreach ($storage_id_array as $k){
                if(!in_array($k, $storage_array)){
                    $storage_array[] = $k;
                }
            }
        }

        //去除仓库列表中无采购商品的仓库
        foreach ($storages as $k => $storage){
            if(!in_array($storage->id, $storage_array)){
                unset($storages[$k]);
            }
        }

        if(!$purchase = PurchaseModel::where(['number' => $purchase_order_number,'storage_status' => 5])->first()){
            return view('errors.403');
        }else{
            $purchase_sku_relation = PurchaseSkuRelationModel
                ::where('purchase_id',$purchase->id)
                ->get();
            $productsSku = new ProductsSkuModel;
            $purchase_sku_relation = $productsSku->detailedSku($purchase_sku_relation);
            foreach ($purchase_sku_relation as $purchase_sku){
                $purchase_sku->total = $purchase_sku->price * $purchase_sku->count;
            }

            $department = $purchase->department;
            return view('home.purchase.createReturned',['storages' => $storages,'purchase' => $purchase,'purchase_sku_relation' => $purchase_sku_relation, 'tab_menu' => $this->tab_menu, 'count' => $this->count(),'department' => $department]);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReturnedPurchaseRequest $request)
    {
        try {
            $purchase_id = $request->input('purchase_id');
            $supplier_id = $request->input('supplier_id');
            $storage_id = $request->input('storage_id');
            $department = (int)$request->input('department');
            $sku_id = $request->input('sku_id');
            $purchase_counts = $request->input('purchase_count');
            $counts = $request->input('count');

            for ($i=0;$i<count($purchase_counts);$i++) {
                if ((int)$purchase_counts[$i] < (int)$counts[$i]) {
                    return back()->with('error_message', '退货数量超过采购数量！');
                }
            }

            for ($i=0;$i<count($counts);$i++) {
                $storage_sku = StorageSkuCountModel::where(['storage_id' => $storage_id,'sku_id' => $sku_id[$i],'department' => $department])->first();
                if (!$storage_sku) {
                    return back()->with('error_message','该仓库/部门无此商品！');
                }
                if ((int)$storage_sku->count < (int)$counts[$i]) {
                    return back()->with('error_message','退货数量超过库存数量！');
                }
            }

            $prices = $request->input('price');
            $summary = $request->input('summary');
            $sum_count = '';
            $sum_price = '';

            for ($i=0;$i<count($sku_id);$i++) {
                $sum_count += $counts[$i];
                $sum_price += $prices[$i] * 100 * $counts[$i];
            }

            DB::beginTransaction();
            
            $returned = new ReturnedPurchasesModel();
            
            $returned->purchase_id = $purchase_id;
            $returned->supplier_id = $supplier_id;
            $returned->storage_id = $storage_id;
            $returned->department = $department;
            $returned->count = $sum_count;
            $returned->price = $sum_price/100;
            $returned->summary = $summary;
            $returned->user_id = Auth::user()->id;
            if (!$number = CountersModel::get_number('CT')) {
                return view('errors.503');
            }
            
            $returned->number = $number;
            if ($returned->save()) {
                $returned_id = $returned->id;
                for ($i=0;$i<count($sku_id);$i++) {
                    $returnedSku = new ReturnedSkuRelationModel();
                    $returnedSku->returned_id = $returned_id;
                    $returnedSku->sku_id = $sku_id[$i];
                    $returnedSku->price = $prices[$i];
                    $returnedSku->count = $counts[$i];
                    $returnedSku->save();
                }
                DB::commit();
                return redirect('/returned');
            } else {
                DB::rollBack();
            }
        }
        catch (\Exception $e) {
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
        $returned_id = (int)$request->input('id');
        $storage = new StorageModel();    //仓库列表
        $storages = $storage->storageList(1);

        $returned = ReturnedPurchasesModel::find($returned_id);
        $purchase = PurchaseModel::find($returned->purchase_id);

        $returned->purchase_number = $purchase->number;          //采购单号
        $returned->purchase_storage = $purchase->storage->name;  //采购入库仓库
        $returned->storage = $returned->storage->name;           //退货出库仓库
        $returned->supplier = $returned->supplier->name;
        $returnedSkus = ReturnedSkuRelationModel::where('returned_id',$returned_id)->get();
        $productsSku = new ProductsSkuModel;
        $returnedSkus = $productsSku->detailedSku($returnedSkus);
        foreach ($returnedSkus as $returnedSku) {
            $returnedSku->total = $returnedSku->price * $returnedSku->count;
        }
        
        return view('home/purchase.showReturned',['returned' => $returned,'returnedSkus' => $returnedSkus,'storages' => $storages]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $returned_id = (int)$request->input('id');
        $storage = new StorageModel();    //仓库列表
        $storages = $storage->storageList(1);

        $returned = ReturnedPurchasesModel::find($returned_id);
        $purchase = PurchaseModel::find($returned->purchase_id);

        $returned->purchase_number = $purchase->number;          //采购单号
        $returned->purchase_storage = $purchase->storage->name;  //采购入库仓库
        $returned->storage = $returned->storage->name;           //退货出库仓库
        $returned->supplier = $returned->supplier->name;
        $returnedSkus = ReturnedSkuRelationModel::where('returned_id',$returned_id)->get();
        $productsSku = new ProductsSkuModel;
        $returnedSkus = $productsSku->detailedSku($returnedSkus);
        /*foreach ($returnedSkus as $returnedSku) {
            $returnedSku->total = $returnedSku->price * $returnedSku->count;
        }*/
        $url = $_SERVER['HTTP_REFERER'];
        if (!Cookie::has('returned_back_url')) {
            Cookie::queue('returned_back_url', $url, 60);  //设置完成编辑后转跳url
        }
        
        return view('home/purchase.editReturned',['returned' => $returned,'returnedSkus' => $returnedSkus,'storages' => $storages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdataReturnedPurchaseRequest $request)
    {
        try{
            $returned_id = $request->input('returned_id');
            $returned_sku_id = $request->input('returned_sku_id');
            $counts = $request->input('count');
            $prices = $request->input('price');

            $sum_count = '';
            $sum_price = '';
            for($i=0;$i<count($returned_sku_id);$i++){
                $sum_count += $counts[$i];
                $sum_price += $prices[$i] * 100 * $counts[$i];
            }

            DB::beginTransaction();
            $returned = ReturnedPurchasesModel::find($returned_id);
            $returned->storage_id = $request->input('storage_id');
            $returned->count = $sum_count;
            $returned->price = $sum_price/100;
            $returned->summary = $request->input('summary');
            if($returned->save()){
                for ($i=0;$i < count($returned_sku_id);$i++){
                    $returned_sku = ReturnedSkuRelationModel::find($returned_sku_id[$i]);
                    $returned_sku->count = $counts[$i];
                    $returned_sku->price = $prices[$i];
                    $returned_sku->save();
                }
                DB::commit();
                $url = Cookie::get('returned_back_url');
                Cookie::forget('returned_back_url');
                return redirect($url);
            }else{
                DB::rollBack();
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
        }
    }
    
    /**
     * 通过采购单号查询采购明细
     * @param Request $request
     * @return string
     */
    public function ajaxPurchase(Request $request)
    {
        $number = (string)$request->input('number');
        if($purchase = PurchaseModel::where(['number' => $number,'storage_status' => 5])->first()){
            $purchase_sku_relation = PurchaseSkuRelationModel::where('purchase_id',$purchase->id)->get();
            $productsSku = new ProductsSkuModel;
            $purchase_sku_relation = $productsSku->detailedSku($purchase_sku_relation);
            foreach ($purchase_sku_relation as $purchase_sku){
                $purchase_sku->total = $purchase_sku->price * $purchase_sku->count;
            }
            $data = [];
            $data['purchase'] = $purchase;
            $data['purchase_sku_relation'] = $purchase_sku_relation;
            return ajax_json(1,'ok',$data);
        }else{
            return ajax_json(0,'该采购单号不存在或未完成入库！');
        }
    }

    /**
     * 删除退货单
     */
    public function ajaxDestroy(Request $request)
    {
        $ids = $request->input('id');
        if (empty($ids)) {
            return ajax_json(0, '参数错误');
        }
        
        try {
            DB::beginTransaction();
            
            foreach ($ids as $id) {
                $returned = ReturnedPurchasesModel::find($id);
                if($returned->verified === 0){
                    $returned->delete();
                    
                    ReturnedSkuRelationModel::where('returned_id', $id)->delete();
                    
                    DB::commit();
                } else {
                    DB::roolBack();
                    return ajax_json(0, '此退货单不存在!');
                }
            }
        }
        catch(\Exception $e){
            DB::roolBack();
            Log::error($e);
            return ajax_json(0, '此操作失败，请重试!');
        }
        
        return ajax_json(1, 'ok');
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
