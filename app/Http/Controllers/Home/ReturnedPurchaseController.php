<?php

namespace App\Http\Controllers\Home;

use App\Models\PurchaseModel;
use App\Models\ReturnedPurchasesModel;
use App\Models\ReturnedSkuRelationModel;
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
    public function home(){
        $returneds = ReturnedPurchasesModel::where('verified',0)->orderBy('id','desc')->paginate(20);
        $purchase = new PurchaseModel;
        $returneds = $purchase->lists($returneds);
        $count = $this->count();
        return view('home/purchase.returned',['returneds' => $returneds,'count' => $count]);
    }

    /**
     * 采购退货单各状态统计
     * @return array
     */
    protected function count(){
        $count = [];
        $count['count_0'] = ReturnedPurchasesModel::where('verified',0)->count();  //待审核
        $count['count_1'] = ReturnedPurchasesModel::where('verified',1)->count();  //业务主管审核
        return $count;
    }

    /**
     * 1.业管主管；9.通过 退货订单查询列表页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function returnedStatus(Request $request){
        $verified = $request->input('verified');
        $returneds = ReturnedPurchasesModel::where('verified',$verified)->orderBy('id','desc')->paginate(20);
        $count = $this->count();
        $purchase = new PurchaseModel;
        $returneds = $purchase->lists($returneds);
        return view('home/purchase.returned'.$verified,['returneds' => $returneds,'count' => $count]);
    }

    /**
     * @param int $id  '采购退货订单id'
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
                    $verified = 9;
                    break;
                default:
                    return $respond;
            }
            $returned = ReturnedPurchasesModel::find($id);
            $returned->verified = $verified;
            if($returned->save()){
                $respond = 1;
            }
        }
        return $respond;
    }

    /**
     * 采购退货货单填单人审核
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
     * 主管审核通过退货订单
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
     * 主管驳回采购退货订单
     * @param Request $request
     * @return string
     */
    public function ajaxDirectorReject(Request $request){
        $id = (int) $request->input('id');
        if(!$purchase = ReturnedPurchasesModel::find($id)){
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
    {
        $storage = new StorageModel();    //仓库列表
        $storages = $storage->storageList(1);
        return view('home/purchase.createReturned',['storages' => $storages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReturnedPurchaseRequest $request)
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
                $sum_price += $prices[$i]*$counts[$i];
            }
            DB::beginTransaction();
            $returned = new ReturnedPurchasesModel();
            $returned->purchase_id = $purchase_id;
            $returned->supplier_id = $supplier_id;
            $returned->storage_id = $storage_id;
            $returned->count = $sum_count;
            $returned->price = $sum_price;
            $returned->summary = $summary;
            $returned->user_id = Auth::user()->id;
            $counter = new CountersModel();  //实例计数model
            $returned->number = $counter->get_number('CT');
            if($returned->save()){
                $returned_id = $returned->id;
                for ($i=0;$i<count($sku_id);$i++){
                    $returnedSku = new ReturnedSkuRelationModel();
                    $returnedSku->returned_id = $returned_id;
                    $returnedSku->sku_id = $sku_id[$i];
                    $returnedSku->price = $prices[$i];
                    $returnedSku->count = $counts[$i];
                    $returnedSku->save();
                }
                DB::commit();
                return redirect('/returned');
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
        foreach ($returnedSkus as $returnedSku){
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
        foreach ($returnedSkus as $returnedSku){
            $returnedSku->total = $returnedSku->price * $returnedSku->count;
        }
        $url = $_SERVER['HTTP_REFERER'];
        if(!Cookie::has('returned_back_url')){
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
            $count = $request->input('count');
            $price = $request->input('price');
            DB::beginTransaction();
            $returned = ReturnedPurchasesModel::find($returned_id);
            $returned->storage_id = $request->input('storage_id');
            $returned->summary = $request->input('summary');
            if($returned->save()){
                for ($i=0;$i < count($returned_sku_id);$i++){
                    $returned_sku = ReturnedSkuRelationModel::find($returned_sku_id[$i]);
                    $returned_sku->count = $count[$i];
                    $returned_sku->price = $price[$i];
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

    public function ajaxDestroy(Request $request)
    {
        try{
            $id = (int)$request->input('id');
            DB::beginTransaction();
            $returned = ReturnedPurchasesModel::find($id);
            if($returned->verified === 0){
                $returned->delete();
                ReturnedSkuRelationModel::where('returned_id',$id)->delete();
                DB::commit();
                $return = ajax_json(1,'ok');
            }else{
                DB::roolBack();
                $return = ajax_json(0,'该订单不存在!');
            }
            return $return;
        }
        catch(\Exception $e){
            DB::roolBack();
            Log::error($e);
        }

    }
}
