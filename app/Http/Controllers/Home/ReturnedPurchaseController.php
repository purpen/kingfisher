<?php

namespace App\Http\Controllers\Home;

use App\Models\PurchaseModel;
use App\Models\ReturnedPurchasesModel;
use App\Models\ReturnedSkuRelationModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StorageModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\ProductsSkuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CountersModel;
use Illuminate\Support\Facades\Log;
class ReturnedPurchaseController extends Controller
{
    public function home(){
        $returneds = ReturnedPurchasesModel::where('verified',0)->orderBy('id','desc')->paginate(20);
        $purchase = new PurchaseModel;
        $returneds = $purchase->lists($returneds);
        return view('home/purchase.returned',['returneds' => $returneds]);
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
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
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
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            dd($e);
        }
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
    public function update(Request $request)
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
}
