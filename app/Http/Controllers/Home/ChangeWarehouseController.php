<?php

namespace App\Http\Controllers\Home;

use App\Models\ChangeWarehouseSkuRelationModel;
use App\Models\ChangeWraehouseModel;
use App\Models\CountersModel;
use App\Models\StorageModel;
use App\Models\StorageSkuCountModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeWarehouseController extends Controller
{
    //调拨单首页
    public function home(){
        $change_warehouse = ChangeWraehouseModel::where('verified',0)->orderBy('id','desc')->paginate(20);
        foreach ($change_warehouse as $model){
            $model->user_name = $model->user->realname;
            if($model->verify_user_id){
                $model->verify_name = UserModel::find($model->verify_user_id)->realname;
            }
            $model->verify_name = '';
            $model->out_storage_name = StorageModel::find($model->out_storage_id)->name;
            $model->in_storage_name = StorageModel::find($model->in_storage_id)->name;
        }
        return view('home/storage.changeWarehouse',['change_warehouse' => $change_warehouse]);
    }

    /**
     * 获取指定仓库sku列表
     * @param Request $request
     * @return string
     */
    public function ajaxSkuList(Request $request){
        $storage_id = (int)$request->input('storage_id');
        if(empty($storage_id)){
            return ajax_json(0,'参数错误');
        }
        $storage_sku_model  = new StorageSkuCountModel();
        $sku_list = $storage_sku_model->skuList($storage_id);
        if($sku_list){
            return ajax_json(1,'ok',$sku_list);
        }else{
            return ajax_json(0,'error');
        }

    }

    /**
     * 根据sku编号或商品名称搜索指定仓库sku
     * @param Request $request
     * @return string
     */
    public function ajaxSearch(Request $request){
        $storage_id = (int)$request->input('storage_id');
        $where = $request->input('where');
        if(empty($storage_id)){
            return ajax_json(0,'参数错误');
        }
        $storage_sku_model  = new StorageSkuCountModel();
        $sku_list = $storage_sku_model->search($storage_id,$where);
        if($sku_list){
            return ajax_json(1,'ok',$sku_list);
        }else{
            return ajax_json(0,'error');
        }
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
        $storages = StorageModel::storageList(null);
        return view('home/storage.createChangeWarehouse',['storages' => $storages]);
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
            $out_storage_id = $request->input('out_storage_id');
            $in_storage_id = $request->input('in_storage_id');
            $sku_id_arr = $request->input('sku_id');
            $count_arr = $request->input('count');
            $summary = $request->input('summary');
            $count_sum = 0;          //调拨总数
            for ($i = 0;$i < count($sku_id_arr);$i++){
                $count_sum +=$sku_id_arr[$i];
            }
            DB::beginTransaction();
            $change_warehouse = new ChangeWraehouseModel();
            $change_warehouse->out_storage_id = $out_storage_id;
            $change_warehouse->in_storage_id = $in_storage_id;
            $change_warehouse->summary = $summary;
            $change_warehouse->count = $count_sum;
            $counter = new CountersModel();
            if(!$number = $counter->get_number('DB')){
                return '单号获取错误';
            }
            $change_warehouse->number = $number;
            $change_warehouse->user_id = Auth::user()->id;
            if(!$change_warehouse->save()){
                DB::rollBack();
                return view('error.503');
            }
            $change_warehouse_id = $change_warehouse->id;
            $change_warehouse_sku = new ChangeWarehouseSkuRelationModel();
            for ($i = 0;$i < count($sku_id_arr);$i++){
                $model = $change_warehouse_sku;
                $model->change_warehouse_id = $change_warehouse_id;
                $model->sku_id = $sku_id_arr[$i];
                $model->count = $count_arr[$i];
                if(!$model->save()){
                    DB::rollBack();
                    return view('error.503');
                }
            }
            DB::commit();
            return redirect('/changeWarehouse');
        }
        catch (\Exception $e){
            DB::rollback();
            Log::error($e);
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
