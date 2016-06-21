<?php

namespace App\Http\Controllers\Home\Storage;

use App\Models\LogisticsModel;
use Illuminate\Http\Request;

use App\Http\Requests\LogisticsRequest;
use App\Http\Controllers\Controller;

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
        return view('home/storage.logistics',['logistics' => $logistics]);
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
        $logistics->area = $request->input('area','');
        $logistics->contact_user = $request->input('contact_user');
        $logistics->contact_number = $request->input('contact_number');
        $logistics->summary = $request->input('summary','');
        $logistics->user_id = 1;
        $logistics->status = $request->input('status',1);
        if($logistics->save()){
            return ajax_json(1,'添加成功');
        }else{
            return ajax_json(0,'添加失败');
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
    public function ajaxUpdate(LogisticsRequest $request)
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
}
