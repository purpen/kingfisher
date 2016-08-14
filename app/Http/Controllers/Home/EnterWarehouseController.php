<?php

namespace App\Http\Controllers\Home;

use App\Models\EnterWarehouseSkuRelationModel;
use App\Models\EnterWarehousesModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Http\Request;

use App\Http\Requests\EnterWarehouseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EnterWarehouseController extends Controller
{
    //入库首页---采购入库
    public function home(){
        $enter_warehouses = EnterWarehousesModel::where('type',1)->where('storage_status','!=',5)->paginate(20);

        return view('home/storage.purchaseEnterWarehouse',['enter_warehouses' => $enter_warehouses]);
    }

    //调拨入库列表页面
    public function changeEnter(){
        $enter_warehouses = EnterWarehousesModel::where('type',3)->where('storage_status','!=',5)->paginate(20);
        foreach ($enter_warehouses as $enter_warehouse){
            $enter_warehouse->purchase_number = $enter_warehouse->changeWarehouse->number;
            $enter_warehouse->storage_name = $enter_warehouse->storage->name;
            $enter_warehouse->user_name = $enter_warehouse->user->realname;
        }

        return view('home/storage.changeEnterWarehouse',['enter_warehouses' => $enter_warehouses]);
    }
    
    //入库完成页面
    public function complete(){
        $enter_warehouses = EnterWarehousesModel::where('storage_status',5)->paginate(20);
        foreach ($enter_warehouses as $enter_warehouse){
            switch ($enter_warehouse->type){
                case 1:
                    $enter_warehouse->purchase_number = $enter_warehouse->purchase->number;
                    break;
                case 2:
                    $enter_warehouse->purchase_number = '订单退货';
                    break;
                case 3:
                    $enter_warehouse->purchase_number = $enter_warehouse->changeWarehouse->number;;
                    break;
                default:
                    return view('errors.503');
            }
            $enter_warehouse->storage_name = $enter_warehouse->storage->name;
            $enter_warehouse->user_name = $enter_warehouse->user->realname;
        }

        return view('home/storage.completeEnterWarehouse',['enter_warehouses' => $enter_warehouses]);
    }

    /**
     * 获取入库单详细信息
     * @param Request $request
     * @return string
     */
    public function ajaxEdit(Request $request){
        $enter_warehouse_id = (int)$request->input('enter_warehouse_id');
        if(empty($enter_warehouse_id)){
            return ajax_json(0,'参数错误');
        }

        $enter_warehouse = EnterWarehousesModel::find($enter_warehouse_id);
        if(!$enter_warehouse){
            return ajax_json(0,'参数错误');
        }

        $enter_warehouse->storage_name = $enter_warehouse->storage->name;
        $enter_warehouse->not_count = $enter_warehouse->count - $enter_warehouse->in_count;

        $enter_sku = EnterWarehouseSkuRelationModel::where('enter_warehouse_id',$enter_warehouse_id)->get();
        if(!$enter_sku){
            return ajax_json(0,'参数错误');
        }

        $sku_model = new ProductsSkuModel();
        $enter_sku = $sku_model->detailedSku($enter_sku);

        foreach ($enter_sku as $sku){
            $sku->not_count = $sku->count - $sku->in_count;
        }

        $data = ['enter_warehouse' => $enter_warehouse, 'enter_sku' => $enter_sku];
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
    public function update(EnterWarehouseRequest $request)
    {
        $enter_warehouse_id = (int)$request->input('enter_warehouse_id');
        $summary = $request->input('summary');
        $enter_sku_id_arr = $request->input('enter_sku_id');    //入库单明细ID
        $sku_id_arr = $request->input('sku_id');
        $count_arr = $request->input('count');
        $sum = 0;
        foreach ($count_arr as $count){
            $sum = $sum + $count; 
        }
        $enter_warehouse_model = EnterWarehousesModel::find($enter_warehouse_id);
        if($enter_warehouse_model){
            if($sum >($enter_warehouse_model->count - $enter_warehouse_model->in_count)){
                return view('errors.503');
            }
            $enter_warehouse_model->in_count = $enter_warehouse_model->in_count + $sum;
            $enter_warehouse_model->summary = $summary;

            DB::beginTransaction();
            if($enter_warehouse_model->save()){
                $sku_arr = [];                 //sku主键 和 sku入库数量 键值对 数组
                for ($i=0;$i<count($enter_sku_id_arr);$i++){
                    if($enter_sku = EnterWarehouseSkuRelationModel::find($enter_sku_id_arr[$i])){

                        if($count_arr[$i] > $enter_sku->count - $enter_sku->in_count){
                            DB::rollBack();
                            return view('errors.503');
                        }

                        $enter_sku->in_count = $enter_sku->in_count + $count_arr[$i];
                        if(!$enter_sku->save()){
                            DB::rollBack();
                            return view('errors.503');
                        }

                        $sku_arr[$sku_id_arr[$i]] = $count_arr[$i];
                    }else{
                        DB::rollBack();
                        return view('errors.503');
                    }
                }

                if(!$enter_warehouse_model->setStorageStatus($sku_arr)){    //修改入库单入库状态;相关单据入库数量,入库状态,明细入库数量
                    DB::rollBack();
                    return view('errors.503');
                }

                //增加商品，SKU 总库存
                $skuModel = new ProductsSkuModel();
                if(!$skuModel->addInventory($sku_arr)){
                    DB::rollBack();
                    return view('errors.503');
                }

                //增加对应仓库SKU库存
                $storage_id = $enter_warehouse_model->storage_id;
                $storage_sku_count = new StorageSkuCountModel();
                if(!$storage_sku_count->enter($storage_id, $sku_arr)){
                    DB::rollBack();
                    return view('errors.503');
                }

                DB::commit();
                return back()->withInput();
            }else{
                DB::rollBack();
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
