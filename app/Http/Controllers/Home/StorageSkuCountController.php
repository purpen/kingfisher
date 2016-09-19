<?php

namespace App\Http\Controllers\Home;

use App\Models\RackPlaceModel;
use App\Models\StorageSkuCountModel;
use App\Models\StorageModel;
use App\Models\StorageRackModel;
use App\Models\StoragePlaceModel;
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
            ->where('product_number' , 'like','%'.$number.'%')
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
        foreach($storageSkuCounts as $storageSkuId){

            $rackplaceSku = RackPlaceModel::where('storage_sku_count_id',$storageSkuId->id)->get();

            if($rackplaceSku){
                $storageSkuId->rack = $rackplaceSku;
            }else{
                $storageSkuId->rack = '';
            }
        }

        return view('home/storage.productCount' , ['storageSkuCounts' => $storageSkuCounts]);
    }

    /**
     * 按商品货号搜索
     */
    public function productSearch(Request $request){
        $number = $request->input('product_number');
        $storageSkuCounts = StorageSkuCountModel
            ::where('product_number' , 'like','%'.$number.'%')
//            ->orWhere('product_id', 'like','%'.$number.'%')
            ->paginate(20);

//        foreach ($storageSkuCounts as $storageSkuCount){
//            $storageSkuCount->product_id = $storageSkuCount->products->title;
//            $storageSkuCount->sku_id = $storageSkuCount->products_sku->number;
//        }
//        dd($storageSkuCounts);
        if($storageSkuCounts){
            return view('home/storage.productCount' , ['storageSkuCounts' => $storageSkuCounts]);
        }else{
            return view('home/storage.productCount');
        }

    }


    /**
     * 商品库存
     */
    public function productCountList(Request $request)
    {
        $storage = StorageSkuCountModel
            ::where('id' , $request['id'])
            ->first();
        $storageRack = StorageRackModel
            ::where('storage_id' , $storage->storage_id)
            ->get();
        if($storage){
            return ajax_json(1 , 'ok' , ['name'=>$storage->Storage->name,'rname'=>$storageRack]);
        }else{
            return ajax_json(0 , 'error');
        }
    }

    /**
     * 商品库位
     */
    public function storagePlace(Request $request)
    {
        $storagePlace = StoragePlaceModel
            ::where('storage_rack_id' , $request['id'])
            ->get();
        if($storagePlace){
            return ajax_json(1 , 'ok' , ['pname'=>$storagePlace]);
        }else{
            return ajax_json(0 , 'error');
        }
    }

    /**
     * 库区库位明细
     */
    public function rackPlace(Request $request)
    {
        $SrP = RackPlaceModel
            ::where(['storage_sku_count_id'=>$request->storage_sku_count_id,'storage_rack_id'=>$request->rack_id,'storage_place_id'=>$request->place_id])->first();
        if(!$SrP){
            $rackPlaces = new RackPlaceModel();
            $rackPlaces->storage_sku_count_id = $request->storage_sku_count_id;
            $rackPlaces->storage_rack_id = $request->rack_id;
            $rackPlaces->storage_place_id = $request->place_id;
            if($rackPlaces->save()){
                return ajax_json(1 , 'ok');
            }else{
                return ajax_json(0 , 'error');
            }
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
