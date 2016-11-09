<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\UpdateProductSkuRequest;
use App\Models\AssetsModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Http\Request;

use App\Http\Requests\ProductSkuRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsSkuController extends Controller
{
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
    public function store(ProductSkuRequest $request)
    {
        $productSku = new ProductsSkuModel();
        $productSku->bid_price = $request->input('bid_price');
        $productSku->cost_price = $request->input('cost_price');
        $productSku->price = $request->input('price');
        $productSku->mode = $request->input('mode');
        $productSku->product_id = $request->input('product_id');
        $productSku->product_number = $request->input('product_number');
        $productSku->number = $request->input('number');
        $productSku->summary = $request->input('summary');
        $productSku->user_id = Auth::user()->id;
        $productSku->cover_id = $request->input('cover_id');
        if($productSku->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $productSku->id;
                $asset->type = 4;
                $asset->save();
            }
            return back()->withInput();
        }else{
            return '添加失败';
        }

    }

    /**
     * 获取需要编辑sku数据
     * @param $id
     * @return string
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        if(!$sku = ProductsSkuModel::find((int)$id)){
            return ajax_json(0,'error');
        }
        $assets = AssetsModel::where(['target_id' => $id,'type' => 4])->get();
        foreach ($assets as $asset){
            $asset->path = $asset->file->srcfile;
        }
        $sku->assets = $assets;
        return ajax_json(1,'ok',$sku);
    }

    /**
     * 删除sku
     * @param Request $request
     * @return string
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $purchaseCount = PurchaseSkuRelationModel::where('sku_id',$id)->count();
        $storageCount = StorageSkuCountModel::where('sku_id',$id)->count();
        $orderCount = OrderSkuRelationModel::where('sku_id',$id)->count();
        if($purchaseCount >0 || $storageCount > 0 || $orderCount > 0){
            return ajax_json(0,'该SKU已使用 不能删除');
        }

        if(ProductsSkuModel::destroy((int)$id)){
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'删除失败');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductSkuRequest $request)
    {
        $sku = ProductsSkuModel::find((int)$request->input('id'));
        $sku->bid_price = $request->input('bid_price');
        $sku->cost_price = $request->input('cost_price');
        $sku->price = $request->input('price');
        $sku->mode = $request->input('mode');
        $sku->weight = $request->input('weight');
        $sku->summary = $request->input('summary');
        $sku->cover_id = $request->input('cover_id');
        if($sku->save()){
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $sku->id;
                $asset->type = 4;
                $asset->save();
            }
            return back()->withInput();
        }else{
            return 'sku更改失败';
        }
    }

    /**
     * 按供应商获取sku列表
     * @param Request $request
     * @return string
     */
    public function ajaxSkus(Request $request){
        $supplier_id = $request->input('supplier_id');
        $productsSku = new ProductsSkuModel();
        $skus = $productsSku->lists(null,$supplier_id);
        return ajax_json(1,'ok',$skus);
    }

    /**
     * 使用名称或编号查询sku
     * @param Request $request
     * @return string
     */
    public function ajaxSearch(Request $request){
        $where = $request->input('where');
        $productsSku = new ProductsSkuModel();
        $skus = $productsSku->lists($where);
        return ajax_json(1,'ok',$skus);
    }

    /**
     * 获取唯一商品SKU编码
     * @return int|string
     */
    public function uniqueNumber(){
        $number = getNumber();
        if(ProductsSkuModel::where('number',$number)->count() > 0){
            $number = $this->uniqueNumber();
        }
        return ajax_json(1,'ok',$number);
    }
}
