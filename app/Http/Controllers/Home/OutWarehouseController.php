<?php

namespace App\Http\Controllers\Home;

use App\Models\OutWarehouseSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Http\Request;

use App\Http\Requests\OutWarehouseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OutWarehouseController extends Controller
{
    /**
     * 未完成出库列表页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(){
        $out_warehouses = OutWarehousesModel::where('type',1)->where('storage_status','!=',5)->paginate(20);
        foreach ($out_warehouses as $out_warehouse){
            $out_warehouse->returned_number = $out_warehouse->returnedPurchase->number;
            $out_warehouse->storage_name = $out_warehouse->storage->name;
            $out_warehouse->user_name = $out_warehouse->user->realname;
        }

        return view('home/storage.returnedOutWarehouse',['out_warehouses' => $out_warehouses]);
    }

    //调拨出库列表页面
    public function changeOut(){
        $out_warehouses = OutWarehousesModel::where('type',3)->where('storage_status','!=',5)->paginate(20);
        foreach ($out_warehouses as $out_warehouse){
            $out_warehouse->returned_number = $out_warehouse->changeWarehouse->number;
            $out_warehouse->storage_name = $out_warehouse->storage->name;
            $out_warehouse->user_name = $out_warehouse->user->realname;
        }

        return view('home/storage.changeOutWarehouse',['out_warehouses' => $out_warehouses]);
    }

    /**
     * 出库完成页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function complete(){
        $out_warehouses = OutWarehousesModel::where('storage_status',5)->paginate(20);
        foreach ($out_warehouses as $out_warehouse){
            switch ($out_warehouse->type){
                case 1:
                    $out_warehouse->returned_number = $out_warehouse->returnedPurchase->number;
                    break;
                case 2:
                    $out_warehouse->returned_number = '订单';
                    break;
                case 3:
                    $out_warehouse->returned_number = '调拨';
                    break;
                default:
                    return view('errors.503');
            }
            $out_warehouse->storage_name = $out_warehouse->storage->name;
            $out_warehouse->user_name = $out_warehouse->user->realname;
        }

        return view('home/storage.completeOutWarehouse',['out_warehouses' => $out_warehouses]);
    }

    /**
     * 获取出库单详细信息
     * @param Request $request
     * @return string
     */
    public function ajaxEdit(Request $request){
        $out_warehouse_id = (int)$request->input('out_warehouse_id');
        if(empty($out_warehouse_id)){
            return ajax_json(0,'参数错误');
        }
        $out_warehouse = OutWarehousesModel::find($out_warehouse_id);
        if(!$out_warehouse){
            return ajax_json(0,'参数错误');
        }
        $out_warehouse->storage_name = $out_warehouse->storage->name;
        $out_warehouse->not_count = $out_warehouse->count - $out_warehouse->out_count;
        $out_sku = OutWarehouseSkuRelationModel::where('out_warehouse_id',$out_warehouse_id)->get();
        if(!$out_sku){
            return ajax_json(0,'参数错误');
        }
        $sku_model = new ProductsSkuModel();
        $out_sku = $sku_model->detailedSku($out_sku);
        foreach ($out_sku as $sku){
            $sku->not_count = $sku->count - $sku->out_count;
        }
        $data = ['out_warehouse' => $out_warehouse, 'out_sku' => $out_sku];
        return ajax_json(1,'ok',$data);
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
    public function update(OutWarehouseRequest $request)
    {
        $out_warehouse_id = (int)$request->input('out_warehouse_id');
        $summary = $request->input('summary');
        $out_sku_id_arr = $request->input('out_sku_id');
        $sku_id_arr = $request->input('sku_id');
        $count_arr = $request->input('count');
        $sum = 0;
        foreach ($count_arr as $count){
            $sum = $sum + $count;
        }
        $out_warehouse_model = OutWarehousesModel::find($out_warehouse_id);
        if($out_warehouse_model){
            if($sum >($out_warehouse_model->count - $out_warehouse_model->out_count)){
                return view('errors.503');
            }
            $out_warehouse_model->out_count = $out_warehouse_model->out_count + $sum;
            $out_warehouse_model->summary = $summary;

            DB::beginTransaction();
            if($out_warehouse_model->save()){
                $sku_arr = [];
                for ($i=0;$i<count($out_sku_id_arr);$i++){
                    if($out_sku = OutWarehouseSkuRelationModel::find($out_sku_id_arr[$i])){
                        if($count_arr[$i] > $out_sku->count - $out_sku->out_count){
                            DB::roolBack();
                            return view('errors.503');
                        }
                        $out_sku->out_count = $out_sku->out_count + $count_arr[$i];
                        if(!$out_sku->save()){
                            DB::roolBack();
                            return view('errors.503');
                        }
                        $sku_arr[$sku_id_arr[$i]] = $count_arr[$i];
                    }else{
                        DB::roolBack();
                        return view('errors.503');
                    }
                }

                //修改出库单出库状态;相关单据出库数量,出库状态,明细出库数量
                if(!$out_warehouse_model->setStorageStatus($sku_arr)){
                    DB::roolBack();
                    return view('errors.503');
                }

                //减少商品，SKU 总库存
                $skuModel = new ProductsSkuModel();
                if(!$skuModel->reduceInventory($sku_arr)){
                    DB::roolBack();
                    return view('errors.503');
                }

                //减少对应仓库SKU库存
                $storage_id = $out_warehouse_model->storage_id;
                $storage_sku_count = new StorageSkuCountModel();
                if(!$storage_sku_count->out($storage_id, $sku_arr)){
                    DB::roolBack();
                    return view('errors.503');
                }

                DB::commit();
                return back()->withInput();
            }else{
                DB::roolBack();
                return view('errors.503');
            }
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
}
