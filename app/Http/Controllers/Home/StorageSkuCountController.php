<?php

namespace App\Http\Controllers\Home;

use App\Models\StorageSkuCountModel;
use App\Models\StorageModel;
use App\Models\StorageRackModel;
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
            ::orderBy('id' , 'desc')
            ->paginate(20);
        return view('home/storage.storageSkuCount' , ['storageSkuCounts' => $storageSkuCounts]);
    }

    /**
     * 按商品货号搜索
     */
    public function search(Request $request){
        $number = $request->input('product_number');
        $storageSkuCounts = StorageSkuCountModel
            ::orderBy('id' , 'desc')
            ->where('product_number' , $number)
            ->paginate(20);
        if($storageSkuCounts){
            return view('home/storage.storageSkuCount' , ['storageSkuCounts' => $storageSkuCounts]);
        }else{
            return view('home/storage.storageSkuCount');
        }

    }
    /*更新上限信息*/
    public function ajaxUpdateMax(Request $request)
    {
        $count = $request->only('max_count');
        if(StorageSkuCountModel::where('id' , $request['id'])->update($count)){
            return ajax_json(1 , '更改成功');
        }else{
            return ajax_json(0 , '更改失败');
        }
    }
    /*更新下限限信息*/
    public function ajaxUpdateMin(Request $request)
    {
        $count = $request->only('min_count');
        if(StorageSkuCountModel::where('id', $request['id'])->update($count)){
            return ajax_json(1 , '更改成功');
        }else{
            return ajax_json(0 , '更改失败');
        }
    }
    /*商品库存显示*/
    public function productCount()
    {
        $storageSkuCounts = StorageSkuCountModel
            ::orderBy('id' , 'desc')
            ->paginate(20);
        return view('home/storage.productCount' , ['storageSkuCounts' => $storageSkuCounts]);
    }

    /**
     * 按商品货号搜索
     */
    public function productSearch(Request $request){
        $number = $request->input('product_number');
        $storageSkuCounts = StorageSkuCountModel
            ::orderBy('id' , 'desc')
            ->where('product_number' , $number)
            ->paginate(20);
        if($storageSkuCounts){
            return view('home/storage.productCount' , ['storageSkuCounts' => $storageSkuCounts]);
        }else{
            return view('home/storage.product
            Count');
        }

    }


    /**
     * 商品库存
     */
    public function productCountList(Request $request)
    {
        $storage = StorageModel
            ::where('id' , $request['id'])
            ->first();
        $storageRack = StorageRackModel
            ::where('storage_id' , $request['id'])
            ->get();
        if($storage){
            return ajax_json(1 , 'ok' , ['name'=>$storage->name,'rname'=>$storageRack->name]);
        }else{
            return ajax_json(0 , 'error');
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
