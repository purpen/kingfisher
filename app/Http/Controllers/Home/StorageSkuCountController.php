<?php

namespace App\Http\Controllers\Home;

use App\Models\StorageSkuCountModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class StorageSkuCountController extends Controller
{

    /**
     * 关联sku库存表的显示页
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storageSkuCounts = StorageSkuCountModel
            ::Join('storages','storages.id','=','storage_sku_count.storage_id')
            ->Join('products_sku','products_sku.id','=','storage_sku_count.sku_id')
            ->Join('products','products.id','=','storage_sku_count.product_id')
            ->select('storages.name as sname','products_sku.*','storage_sku_count.product_number','products.title','storage_sku_count.count')
            ->get();
        return view('home/storage.storageSkuCount',['storageSkuCounts' => $storageSkuCounts]);
    }

    /**
     * 按商品货号搜索
     */
    public function search(Request $request){
        $number = $request->input('number');
        $storageSkuCounts = StorageSkuCountModel
            ::Join('storages','storages.id','=','storage_sku_count.storage_id')
            ->Join('products_sku','products_sku.id','=','storage_sku_count.sku_id')
            ->Join('products','products.id','=','storage_sku_count.product_id')
            ->where('product_number','like','%'.$number.'%')
            ->select('storages.name as sname','products_sku.*','storage_sku_count.product_number','products.title','storage_sku_count.count');
        if($storageSkuCounts){
            return view('home/storage.storageSkuCount',['storageSkuCounts' => $storageSkuCounts]);
        }else{
            return view('home/storage.storageSkuCount');
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
