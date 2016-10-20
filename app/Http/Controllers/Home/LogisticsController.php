<?php

namespace App\Http\Controllers\Home;

use App\Helper\JdApi;
use App\Http\Requests\UpdateLogisticRequest;
use App\Models\LogisticsModel;
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
            return ajax_json(1,'添加成功');
        }else{
            return ajax_json(0,'添加失败');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        if (!empty($id)){
            if(LogisticsModel::destroy($id)){
                return ajax_json(1,'删除成功');
            }else{
                return ajax_json(0,'删除失败');
            }
        }
    }

    /**
     * 更改物流公司状态
     *
     * @param int $id
     * $return json
     */
    public function ajaxStatus(Request $request){
        $id = $request->input('id');
        if(!empty($id)){
            $logistics = LogisticsModel::find($id);
            $status = $logistics->status;
            if ($status == '停用') {
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
        $stores->logistic = logisticsModel::orderBy('id','desc')->get();
        $storeStorageLogistics= StoreStorageLogisticModel::orderBy('id','desc')->get();
        return view('home/storage.logisticsGo',['stores' => $stores ,'storeStorageLogistics' => $storeStorageLogistics ]);
    }

    /*
     * 物流添加
     */
    public function goStore(Request $request)
    {
        $storeStorageLogistics = new StoreStorageLogisticModel();
        $storeStorageLogistics->store_id = $request->input('store_id');
        $storeStorageLogistics->storage_id = $request->input('storage_id');
        $storeStorageLogistics->logistics_id = $request->input('logistics_id');
        if($storeStorageLogistics->save()){
            return ajax_json(1,'添加成功');
        }else{
            return ajax_json(0,'添加失败');
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
}

