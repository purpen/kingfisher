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
            ->select('storages.name as sname','products_sku.*','storage_sku_count.product_number','products.title','storage_sku_count.count','storage_sku_count.max_count','storage_sku_count.min_count','storage_sku_count.id')
            ->get();
        return view('home/storage.storageSkuCount',['storageSkuCounts' => $storageSkuCounts]);
    }

    /**
     * 按商品货号搜索
     */
    public function search(Request $request){
        $number = $request->input('product_number');
        $storageSkuCounts = StorageSkuCountModel
            ::Join('storages','storages.id','=','storage_sku_count.storage_id')
            ->Join('products_sku','products_sku.id','=','storage_sku_count.sku_id')
            ->Join('products','products.id','=','storage_sku_count.product_id')
            ->select('storages.name as sname','products_sku.*','storage_sku_count.product_number','products.title','storage_sku_count.count')
            ->where('product_number','like','%'.$number.'%')
            ->paginate(20);
        if($storageSkuCounts){
            return view('home/storage.storageSkuCount',['storageSkuCounts' => $storageSkuCounts]);
        }else{
            return view('home/storage.storageSkuCount');
        }

    }
    /*更新上限信息*/
    public function ajaxUpdateMax(Request $request)
    {
        $count=$request->only('max_count');
        if(StorageSkuCountModel::where('id', $request['id'])->update($count)){
            return ajax_json(1,'更改成功');
        }else{
            return ajax_json(0,'更改失败');
        }
    }
    /*更新下限限信息*/
    public function ajaxUpdateMin(Request $request)
    {
        $count=$request->only('min_count');
        if(StorageSkuCountModel::where('id', $request['id'])->update($count)){
            return ajax_json(1,'更改成功');
        }else{
            return ajax_json(0,'更改失败');
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
