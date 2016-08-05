<?php

namespace App\Http\Controllers\Home;

use App\Models\StorageSkuCountModel;
use App\Models\ProductsSkuModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class StorageSkuCountController extends Controller
{
    /**
     * 关联sku库存表的显示页
     *
     * @return \Illuminate\Http\Response
     */
//   public function index()
//   {
//       $storageSkuCounts = ProductsSkuModel
//           ::join('products','products.id','=','products_sku.product_id')
//           //->join('storage_places','storage_places.id','=','products_sku.storage_place_id')
//           ->select('products_sku.*','products.number as snumber','products.title')
//           ->get();
//       return view('home/storage.storageSkuCount',['storageSkuCounts' => $storageSkuCounts]);
//   }

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
            ->select('storages.name as sname','products_sku.*','products.number as snumber','products.title')
            ->get();
        return view('home/storage.storageSkuCount',['storageSkuCounts' => $storageSkuCounts]);
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
