<?php

namespace App\Http\Controllers\Home\Storage;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StoragePlaceModel;
class StoragePlaceController extends Controller
{
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
     *添加库位
     */
    public function addStoragePlace(Request $request)
    {
        $storagePlace = new StoragePlaceModel;
        $storagePlace->name = $request->input('name');
//        $storagePlace->number = $request->input('number');
//        $storagePlace->type = $request->input('type');
        $storagePlace->storage_rack_id = $request->input('storage_rack_id');
//        $storageRack->status = $request->input('status');
        $storagePlace->content = $request->input('content');
        $storagePlace->user_id = 'user_id';
        if ($storagePlace->save()){
            $result = ['status' => 1,'message' => '仓位添加成功'];
            return response()->json($result);
        }else{
            $result = ['status' => 0,'message' => '仓位添加失败'];
            return response()->json($result);
        }
    }

    /**
     *库位列表
     */
    public function storagePlaceList(Request $request)
    {
        $storage_rack_id = $request->input('storage_rack_id');
        $list = StoragePlaceModel::storagePlaceList($storage_rack_id);
        return ajax_json('1','ok',$list);
    }


    /**
     * 编辑仓位信息
     */
    public function editStoragePlace(Request $request)
    {
        if ($request->isMethod('get')){
            $id = $request->input('id');
            if($storagePlace = StoragePlaceModel::find($id)){
                $result = ['status' => 1,'data' => $storagePlace];
                return response()->json($result);
            }

        }elseif ($request->isMethod('post')){
            $rules = [
                'id' => 'required|integer',
                'name'=>'required|max:30|unique:storage_places',
//                'storage_id' => 'required|integer',
//                'number'=>'required|max:10|unique:storage_place',
                'content'=>'required|max:500'
            ];
            $messages = [
                'name.unique' => '仓位名已存在',
//                'number.unique' => '仓位编号已存在',
                'name.required' => '仓位名称不能为空！',
                'name.max' =>'仓位名称不能大于30个字',
//                'number.required' => '仓位编号不能为空',
//                'number.max' => '仓位编号长度不能大于10',
                'content.required' => '仓位简介不能为空',
                'content.max' => '仓位简介字数不能超过500'
            ];
            $this->validate($request, $rules, $messages);
            $storagePlace = StoragePlaceModel::find($request->id);
            if($storagePlace->update($request->all())){
                $result = ['status' => 1,'message' => '仓区更新成功'];
                return response()->json($result);
            }else{
                $result = ['status' => 0,'message' => '仓区更新失败'];
                return response()->json($result);
            }
        }
    }


    /**
     *删除库位
     *@param Request
     *@return  resource
     */
    public function destroyStoragePlace(Request $request)
    {
        $id = intval($request->input('id'));
        if(StoragePlaceModel::destroy($id)){
            $result = ['status' => 1,'message' => '库位删除成功'];
            return response()->json($result);
        }else{
            $result = ['status' => 0,'message' => '库位删除失败'];
            return response()->json($result);
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
