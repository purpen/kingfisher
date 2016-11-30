<?php

namespace App\Http\Controllers\Home;

use App\Models\RackPlaceModel;
use App\Models\StorageSkuCountModel;
use App\Models\StorageModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
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
        $storages = StorageModel::orderBy('id' , 'desc')->get();
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
    public function productCount(Request $request)
    {
        $storage_id = $request->input('id');
        if($storage_id){
            $storageSkuCounts = StorageSkuCountModel::where('storage_id' , $storage_id)->paginate(20);
            $storages = StorageModel::orderBy('id' , 'desc')->get();
            foreach($storageSkuCounts as $storageSkuId){

                $rackplaceSku = RackPlaceModel::where('storage_sku_count_id',$storageSkuId->id)->get();
                if($rackplaceSku){
                    $storageSkuId->rack = $rackplaceSku;
                }else{
                    $storageSkuId->rack = '';
                }

                $rackPlaces = RackPlaceModel::where('storage_sku_count_id',$storageSkuId->id)->count();
                $storageSkuId->count = $rackPlaces ;
            }
        }else{
            $storageSkuCounts = StorageSkuCountModel
                ::orderBy('id' , 'desc')
                ->paginate(20);
            $storages = StorageModel::orderBy('id' , 'desc')->get();
            foreach($storageSkuCounts as $storageSkuId){

                $rackplaceSku = RackPlaceModel::where('storage_sku_count_id',$storageSkuId->id)->get();
                if($rackplaceSku){
                    $storageSkuId->rack = $rackplaceSku;
                }else{
                    $storageSkuId->rack = '';
                }

                $rackPlaces = RackPlaceModel::where('storage_sku_count_id',$storageSkuId->id)->count();
                $storageSkuId->count = $rackPlaces ;
            }
        }



        return view('home/storage.productCount' , [
            'storageSkuCounts' => $storageSkuCounts ,
            'storages' => $storages
        ]);
    }

    /**
     * 按商品货号搜索
     */
    public function productSearch(Request $request){
        $number = $request->input('product_number');
        $storageSkuCounts = StorageSkuCountModel
            ::where('product_number' , 'like','%'.$number.'%')
//            ->orWhere('title' , 'like','%'.$number.'%')
//            ->orWhere('product_id', 'like','%'.$number.'%')
            ->paginate(20);
        $storages = StorageModel::orderBy('id' , 'desc')->get();
        $products = ProductsModel
            ::where('title' , 'like','%'.$number.'%')
            ->paginate(20);
//        dd($storageSkuCounts);
        $productsSkus = ProductsSkuModel
            ::where('number' , 'like','%'.$number.'%')
            ->paginate(20);

        if($storageSkuCounts){
            return view('home/storage.productCount' , [
                'storageSkuCounts' => $storageSkuCounts ,
                'products' => $products ,
                'productsSkus' => $productsSkus ,
                'storages' => $storages
            ]);
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
        $SrP = RackPlaceModel::where([
            'storage_sku_count_id'=>$request->storage_sku_count_id,
            'storage_rack_id'=>$request->rack_id,
            'storage_place_id'=>$request->place_id
        ])->first();
        //判断数据是否已经存在
        if( count ($SrP) ){
            return ajax_json(0 , '该库区库位已经存在,请重新选择！');
        }else{
            $rackPlaces = new RackPlaceModel();
            $rackPlaces->storage_sku_count_id = $request->storage_sku_count_id;
            $rackPlaces->storage_rack_id = $request->rack_id;
            $rackPlaces->storage_place_id = $request->place_id;
            if($rackPlaces->save()){
                return ajax_json(1 , '添加成功');
            }else{
                return ajax_json(0 , 'error');
            }
        }

    }

    /**
     * 删除sku所在库区库位设置
     */
    public function deleteRackPlace(Request $request)
    {
        $id = (int)$request->input('id');

        if(!RackPlaceModel::destroy($id)){
            return ajax_json(0,'删除失败');
        }

        return ajax_json(1,'删除成功');
    }

    /**
     * 库存成本页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storageCost(Request $request)
    {
        $storage_id = $request->input('id','');
        $storage = new StorageSkuCountModel();
        if($storage_id){
            $storageSkuCounts = StorageSkuCountModel
                ::where('storage_id',$storage_id)
                ->orderBy('product_id', 'desc')
                ->paginate(20);

            $moneyCount = $storage->everyStorageCount($storage_id);
        }else{
            $storageSkuCounts = StorageSkuCountModel
                ::orderBy('product_id', 'desc')
                ->paginate(20);

            $moneyCount = $storage->everyStorageCount();
        }

        $storages = StorageModel::storageList();

        return view('home/storage.storageCost' , ['storageSkuCounts' => $storageSkuCounts,'moneyCount' => $moneyCount,'storages' => $storages,'storage_id' =>$storage_id]);
    }

    /**
     * 获取某仓库的库存成本
     * 
     * @param Request $request
     * @return string
     */
   /* public function everyStorageCost(Request $request)
    {
        $id = (int)$request->input('id','');
        $storage = new StorageSkuCountModel();
        $result = $storage->everyStorageCount($id);
        return ajax_json(1,'ok',$result);
    }*/
}
