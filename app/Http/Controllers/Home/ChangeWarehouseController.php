<?php

namespace App\Http\Controllers\Home;

use App\Models\ChangeWarehouseSkuRelationModel;
use App\Models\ChangeWarehouseModel;
use App\Models\CountersModel;
use App\Models\EnterWarehousesModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageModel;
use App\Models\StorageSkuCountModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreChangeWarehouseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeWarehouseController extends Controller
{
    //调拨单首页
    public function home(){
        $change_warehouse = ChangeWarehouseModel::where('verified',0)->orderBy('id','desc')->paginate(20);
        foreach ($change_warehouse as $model){
            $model->user_name = $model->user->realname;
            $model->out_storage_name = StorageModel::find($model->out_storage_id)->name;
            $model->in_storage_name = StorageModel::find($model->in_storage_id)->name;
        }
        $count_arr = $this->count();
        return view('home/storage.changeWarehouse',['change_warehouse' => $change_warehouse,'count_arr' => $count_arr]);
    }

    //上级主管领导审核列表页面
    public function verify(){
        $change_warehouse = ChangeWarehouseModel::where('verified',1)->orderBy('id','desc')->paginate(20);
        foreach ($change_warehouse as $model){
            $model->user_name = $model->user->realname;
            $model->verify_name = '';
            $model->out_storage_name = StorageModel::find($model->out_storage_id)->name;
            $model->in_storage_name = StorageModel::find($model->in_storage_id)->name;
        }
        $count_arr = $this->count();
        return view('home/storage.changeWarehouse1',['change_warehouse' => $change_warehouse,'count_arr' => $count_arr]);
    }

    //审核完成列表页面
    public function completeVerify(){
        $change_warehouse = ChangeWarehouseModel::where('verified',9)->orderBy('id','desc')->paginate(20);
        foreach ($change_warehouse as $model){
            $model->user_name = $model->user->realname;
            if($model->verify_user_id){
                $model->verify_name = UserModel::find($model->verify_user_id)->realname;
            }else{
                $model->verify_name = '';
            }
            $model->out_storage_name = StorageModel::find($model->out_storage_id)->name;
            $model->in_storage_name = StorageModel::find($model->in_storage_id)->name;
        }
        $count_arr = $this->count();
        return view('home/storage.changeWarehouse9',['change_warehouse' => $change_warehouse,'count_arr' => $count_arr]);
    }

    public function count(){
        $count_arr = [];
        $count_arr['count_0'] = ChangeWarehouseModel::where('verified',0)->count();
        $count_arr['count_1'] = ChangeWarehouseModel::where('verified',1)->count();
        return $count_arr;
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
    public function store(StoreChangeWarehouseRequest $request)
    {

        try{
            $out_storage_id = $request->input('out_storage_id');
            $in_storage_id = $request->input('in_storage_id');
            $sku_id_arr = $request->input('sku_id');
            $count_arr = $request->input('count');
            $summary = $request->input('summary');
            $count_sum = 0;          //调拨总数
            for ($i = 0;$i < count($sku_id_arr);$i++){
                $count_sum +=$count_arr[$i];
            }
            DB::beginTransaction();
            $change_warehouse = new ChangeWarehouseModel();
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
            for ($i = 0;$i < count($sku_id_arr);$i++){
                $model = new ChangeWarehouseSkuRelationModel();
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
    public function show(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return '参数错误';
        }
        $storage_list = StorageModel::storageList(null);
        $change_warehouse = ChangeWarehouseModel::find($id);
        $change_warehouse_sku_list  = ChangeWarehouseSkuRelationModel::where('change_warehouse_id',$id)->get();
        $product_model = new ProductsSkuModel();
        $change_warehouse_sku_list = $product_model->detailedSku($change_warehouse_sku_list);
        foreach ($change_warehouse_sku_list as $change_warehouse_sku){
            $sku = StorageSkuCountModel::where(['storage_id' => $change_warehouse->out_storage_id,'sku_id' => $change_warehouse_sku->sku_id])->first();
            if(!$sku){
                return '参数错误';
            }
            $change_warehouse_sku->storage_count = $sku->count;
        }
        return view('home/storage.showChangeWarehouse',['storage_list' => $storage_list,'change_warehouse' =>$change_warehouse,'change_warehouse_sku_list' => $change_warehouse_sku_list]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return '参数错误';
        }
        $storage_list = StorageModel::storageList(null);
        $change_warehouse = ChangeWarehouseModel::find($id);
        $change_warehouse_sku_list  = ChangeWarehouseSkuRelationModel::where('change_warehouse_id',$id)->get();
        $product_model = new ProductsSkuModel();
        $change_warehouse_sku_list = $product_model->detailedSku($change_warehouse_sku_list);
        foreach ($change_warehouse_sku_list as $change_warehouse_sku){
            $sku = StorageSkuCountModel::where(['storage_id' => $change_warehouse->out_storage_id,'sku_id' => $change_warehouse_sku->sku_id])->first();
            if(!$sku){
                return '参数错误';
            }
            $change_warehouse_sku->storage_count = $sku->count;
        }
        return view('home/storage.editChangeWarehouse',['storage_list' => $storage_list,'change_warehouse' =>$change_warehouse,'change_warehouse_sku_list' => $change_warehouse_sku_list]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $change_warehouse_id = $request->input('chang_warehouse_id');
        $out_storage_id = $request->input('out_storage_id');
        $in_storage_id = $request->input('in_storage_id');
        $sku_id_arr = $request->input('sku_id');
        $count_arr = $request->input('count');
        $summary = $request->input('summary');

        $count_sum = 0;          //调拨总数
        for ($i = 0;$i < count($sku_id_arr);$i++){
            $count_sum +=$count_arr[$i];
        }
        DB::beginTransaction();
        $change_warehouse = ChangeWarehouseModel::find($change_warehouse_id);
        $change_warehouse->out_storage_id = $out_storage_id;
        $change_warehouse->in_storage_id = $in_storage_id;
        $change_warehouse->summary = $summary;
        $change_warehouse->count = $count_sum;
        if(!$change_warehouse->save()){
            DB::rollBack();
            return view('error.503');
        }
        if(!DB::table('change_warehouse_sku_relation')->where('change_warehouse_id',$change_warehouse_id)->delete()){
            DB::rollBack();
            return view('error.503');
        }
        for ($i = 0;$i < count($sku_id_arr);$i++){
            $model = new ChangeWarehouseSkuRelationModel();
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

    /**
     * @param Request $request
     * @return bool|string
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return ajax_json(0,'删除失败');
        }
        try{
            DB::beginTransaction();
            if(!ChangeWarehouseModel::destroy($id)){
                DB::rollBack();
                return ajax_json(0,'删除失败');
            }
            if(ChangeWarehouseSkuRelationModel::where('change_warehouse_id',$id)->delete()){
                DB::commit();
                return ajax_json(1,'ok');
            }else{
                DB::rollBack();
                return ajax_json(0,'删除失败');
            }
        }
        catch (\Exception $e){
            DB::rollback();
            Log::error($e);
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

    /**
     *调拨单创建者确认审核
     * @param Request $request
     * @return bool|string
     */
    public function ajaxVerified(Request $request){
        $id = (int)$request->input('id');
        if(empty($id)){
            return false;
        }
        $change_warehouse = new ChangeWarehouseModel();
        if($change_warehouse->changeStatus($id,1)){
            return ajax_json(1,'ok');
        }else{
            return ajax_json(0,'error');
        }
    }

    /**
     *上级主管确认审核
     * @param Request $request
     * @return bool|string
     */
    public function ajaxDirectorVerified(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return ajax_json(0,'error');
        }
        try{
            DB::beginTransaction();
            $change_warehouse = ChangeWarehouseModel::find($id);
            if($change_warehouse->changeStatus($id,9)){
                $change_warehouse->verify_user_id = Auth::user()->id;
                if(!$change_warehouse->save()){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }

                $out_warehouse = new OutWarehousesModel();
                if(!$out_warehouse->changeCreateOutWarehouse($id)){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }

                $enter_warehouse = new EnterWarehousesModel();
                if(!$enter_warehouse->changeCreateEnterWarehouse($id)){
                    DB::rollBack();
                    return ajax_json(0,'error');
                }
                DB::commit();
                return ajax_json(1,'ok');
            }else{
                DB::rollBack();
                return ajax_json(0,'error');
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e);
        }
    }
}