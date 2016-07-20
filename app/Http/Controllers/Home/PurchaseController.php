<?php

namespace App\Http\Controllers\Home;

use App\Models\AssetsModel;
use App\Models\CountersModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\StorageModel;
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
    public function home()
    {
        $purchases = PurchaseModel::where('verified',0)->orderBy('id','desc')->paginate(20);
        $count = $this->count();
        $purchase = new PurchaseModel;
        $purchases = $purchase->lists($purchases);
        return view('home/purchase.purchase',['purchases' => $purchases,'count' => $count]);
    }

    /**
     * 1.业管主管；2.财务；9.通过 查询页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchaseStatus(Request $request)
    {
        $verified = $request->input('verified');
        $purchases = PurchaseModel::where('verified',$verified)->orderBy('id','desc')->paginate(20);
        $count = $this->count();
        $purchase = new PurchaseModel;
        $purchases = $purchase->lists($purchases);
        return view('home/purchase.purchase'.$verified,['purchases' => $purchases,'count' => $count]);
    }

    /**
     * 采购单各状态统计
     * @return array
     */
    protected function count()
    {
        $count = [];
        $count['count_0'] = PurchaseModel::where('verified',0)->count();  //待审核统计
        $count['count_1'] = PurchaseModel::where('verified',1)->count();  //业务主管统计
        $count['count_2'] = PurchaseModel::where('verified',2)->count();  //财务审核
        return $count;
    }

    /**
     * @param int $id  '采购订单id'
     * @param int $verified  ‘审核状态’
     * @return null|string
     */
    public function changeStatus($id,$verified)
    {
        $id = (int) $id;
        $respond = 0;
        if (empty($id)){
            return $respond;
        }else{
            switch ($verified){
                case 0:
                    $verified = 1;
                    break;
                case 1:
                    $verified = 2;
                    break;
                case 2:
                    $verified = 9;
                    break;
                default:
                    return $respond;
            }
            $purchase = PurchaseModel::find($id);
            $purchase->verified = $verified;
            if($purchase->save()){
                $respond = 1;
            }
        }
        return $respond;
    }

    /**
     * 建表人审核
     * @param Request $request
     * @return string
     */
    public function ajaxVerified(Request $request)
    {
        $id = (int) $request->input('id');
        $status = $this->changeStatus($id,0);
        if ($status){
            $respond =  ajax_json(1,'审核成功');
        }else{
            $respond = ajax_json(0,'审核失败');
        }
        return $respond;
    }

    /**
     * 主管审核通过采购订单
     * @param Request $request
     * @return string
     */
    public function ajaxDirectorVerified(Request $request)
    {
        $id = (int) $request->input('id');
        $status = $this->changeStatus($id,1);
        if ($status){
            $respond =  ajax_json(1,'审核成功');
        }else{
            $respond = ajax_json(0,'审核失败');
        }
        return $respond;
    }

    /**
     * 主管驳回采购订单
     * @param Request $request
     * @return string
     */
    public function ajaxDirectorReject(Request $request){
        $id = (int) $request->input('id');
        if(!$purchase = PurchaseModel::find($id)){
            $respond = ajax_json(0,'参数错误！');
        }else{
            $purchase->verified = 0;
            if($purchase->save()){
                $respond = ajax_json(1,'驳回成功');
            }else{
                $respond = ajax_json(0,'驳回失败');
            }
        }
        return $respond;
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
            $sku_id = $request->input('sku_id');
            $counts = $request->input('count');
            $prices = $request->input('price');
            $summary = $request->input('summary');
            $sum_count = '';
            $sum_price = '';
            for($i=0;$i<count($sku_id);$i++){
                $sum_count += $counts[$i];
                $sum_price += $prices[$i]*100*$counts[$i];
            }
            DB::beginTransaction();
            $purchase = new PurchaseModel();
            $purchase->supplier_id = $supplier_id;
            $purchase->storage_id = $storage_id;
            $purchase->count = $sum_count;
            $purchase->price = $sum_price/100;
            $purchase->summary = $summary;
            $purchase->user_id = Auth::user()->id;
            $counter = new CountersModel();  //实例计数model
            $purchase->number = $counter->get_number('CG');
            if($purchase->save()){
                $purchase_id = $purchase->id;
                for ($i=0;$i<count($sku_id);$i++){
                    $purchaseSku = new PurchaseSkuRelationModel();
                    $purchaseSku->purchase_id = $purchase_id;
                    $purchaseSku->sku_id = $sku_id[$i];
                    $purchaseSku->price = $prices[$i];
                    $purchaseSku->count = $counts[$i];
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
            $sku_id = $request->input('sku_id');
            $counts = $request->input('count');
            $prices = $request->input('price');
            $summary = $request->input('summary');
            $sum_count = '';
            $sum_price = '';
            for($i=0;$i<count($sku_id);$i++){
                $sum_count += $counts[$i];
                $sum_price += $prices[$i]*100*$counts[$i];
            }
            DB::beginTransaction();
            $purchase = PurchaseModel::find($purchase_id);
            $purchase->supplier_id = $supplier_id;
            $purchase->storage_id = $storage_id;
            $purchase->count = $sum_count;
            $purchase->price = $sum_price/100;
            $purchase->summary = $summary;
            $purchase->user_id = Auth::user()->id;
            if($purchase->save()){
                DB::table('purchase_sku_relation')->where('purchase_id',$purchase_id)->delete();
                for ($i=0;$i<count($sku_id);$i++){
                    $purchaseSku = new PurchaseSkuRelationModel();
                    $purchaseSku->purchase_id = $purchase_id;
                    $purchaseSku->sku_id = $sku_id[$i];
                    $purchaseSku->price = $prices[$i];
                    $purchaseSku->count = $counts[$i];
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

    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return false;
        }
        if(PurchaseModel::destroy($id)){
            if(PurchaseSkuRelationModel::where('purchase_id',$id)->delete()){
                return ajax_json(1,'ok');
            }else{
                return ajax_json(0,'删除失败');
            }
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
        $purchases = PurchaseModel::where(['number' => $where,'verified' => 0])->orWhere(['supplier_id' => $where,'verified' => 0])->orderBy('id','desc')->paginate(20);
        $purchase = new PurchaseModel;
        $purchases = $purchase->lists($purchases);
        return view('home/purchase.purchase',['purchases' => $purchases]);
    }
}
