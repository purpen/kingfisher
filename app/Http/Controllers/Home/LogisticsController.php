<?php

namespace App\Http\Controllers\Home;

use App\Helper\JdApi;
use App\Http\Requests\UpdateLogisticRequest;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\StoreModel;
use App\Models\StorageModel;
use App\Models\StoreStorageLogisticModel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreStorageLogisticRequest;

use App\Http\Requests\LogisticsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logistics = LogisticsModel::orderBy('id','desc')->get();
//dd($logistics);
        $logistics_id = config('logistics.logistics');
        return view('home/storage.logistics',['logistics' => $logistics,'logistics_id' => $logistics_id]);
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
    public function ajaxStore(LogisticsRequest $request)
    {
        $logistics = new LogisticsModel();
        $logistics->name = $request->input('name');
        $logistics->area = $request->input('logistics_id');
        $logistics->contact_user = $request->input('contact_user');
        $logistics->contact_number = $request->input('contact_number');
        $logistics->summary = $request->input('summary','');
        $logistics->user_id = Auth::user()->id;
        $logistics->status = $request->input('status',1);
        
        $logistics_list = config('logistics.logistics');
        foreach ($logistics_list as $k => $v){
            if ($logistics->area == $k){
                $logistics->jd_logistics_id = $v['jd'];
                $logistics->tb_logistics_id = $v['tb'];
                $logistics->zy_logistics_id = $v['zy'];
                $logistics->kdn_logistics_id = $v['kdn'];
                break;
             }
        }
        if($logistics->save()){
            return redirect('/logistics');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxEdit(Request $request)
    {
        if (!empty($id = $request->input('id'))){
            $id = intval($id);
            if($logistics = LogisticsModel::find($id)){
                return ajax_json(1,'ok',$logistics);
            }else{
                return ajax_json(0,'error');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxUpdate(UpdateLogisticRequest$request)
    {
        $id = $request->input('id');
        if(!empty($id)){
            $logistics = LogisticsModel::find($id);
            if($logistics->update($request->all())){
                return ajax_json(1,'更新成功');
            }else{
                return ajax_json(0,'更新失败');
            }
        }
    }

    /**
     * 物流删除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        if (!empty($id)){
        //判断有无订单使用此物流
            $order_count = OrderModel::where('express_id',$id)->count();
            if($order_count > 0){
                return ajax_json(0,'有订单使用此物流，无法删除');
            }

            //判断店铺默认物流设置有使用此物流
            $set_count = StoreStorageLogisticModel::where('logistics_id',$id)->count();
            if($set_count > 0){
                return ajax_json(0,'店铺默认物流使用此物流，无法删除');
            }

            $logistics = LogisticsModel::find($id);
            $logistics->forceDelete();

            return ajax_json(1,'删除成功');
        }
    }

    /**
     * 更改物流公司状态
     *
     *  @param int $id
     * $return json
     */
    public function ajaxStatus(Request $request){
        $id = $request->input('id');
        if(!empty($id)){

            //判断店铺默认物流设置有使用此物流
            $set_count = StoreStorageLogisticModel::where('logistics_id',$id)->count();
            if($set_count > 0){
                return ajax_json(0,'店铺默认物流使用此物流，无法停用');
            }

            $logistics = LogisticsModel::find($id);
            $status = $logistics->status;
            if ($status == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $logistics->status = $status;
            if($logistics->save()){
                return ajax_json(1,'状态更改成功',$logistics);
            }else{
                return ajax_json(0,'状态更改失败');
            }
        }
    }


    /**
     * 物流配送
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $stores = StoreModel::orderBy('id','desc')->get();
        $stores->storage = StorageModel::orderBy('id','desc')->get();
        $stores->logistic = logisticsModel::where('status',1)->orderBy('id','desc')->get();
        $storeStorageLogistics= StoreStorageLogisticModel::orderBy('id','desc')->get();
        return view('home/storage.logisticsGo',['stores' => $stores ,'storeStorageLogistics' => $storeStorageLogistics ]);
    }

    /*
     * 物流添加
     */
    public function goStore(Request $request)
    {
        $count = StoreStorageLogisticModel::where([
            'store_id' => (int)$request->input('store_id')
        ])->first();

        if( count ($count) ){
            return ajax_json(0 , '该店铺已经存在,请重新选择！');
        }else{
            $storeStorageLogistics = new StoreStorageLogisticModel();
            $storeStorageLogistics->store_id = (int)$request->input('store_id');
            $storeStorageLogistics->storage_id = (int)$request->input('storage_id');
            $storeStorageLogistics->logistics_id = (int)$request->input('logistics_id');
            if($storeStorageLogistics->save()){
                return ajax_json(1,'添加成功');
            }else{
                return ajax_json(0,'添加失败');
            }
        }
    }


    /**
     * 更新物流配送
     */
    public function goUpdate(Request $request)
    {
        $id = $request->input('id');
        if(!empty($id)){
            $storeStorageLogistics = StoreStorageLogisticModel::find($id);
            if($storeStorageLogistics->update($request->all())){
                return ajax_json(1,'更新成功');
            }else{
                return ajax_json(0,'更新失败');
            }
        }
    }

    /**
     * 删除店铺 仓库 物流配送设置
     */
    public function goDestroy(Request $request)
    {
        $id = (int)$request->input('id');
        if(empty($id)){
            return ajax_json(0,'参数错误');
        }

        //强制删除
        $logistics = StoreStorageLogisticModel::find($id);
        $logistics->forceDelete();

        return ajax_json(1,'物流配送删除成功');
    }

}

