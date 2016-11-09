<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StoragePlaceModel;
use Illuminate\Support\Facades\Auth;
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
    public function add(Request $request)
    {
        $storagePlace = new StoragePlaceModel;
        $storagePlace->name = $request->input('name');
//        $storagePlace->number = $request->input('number');
//        $storagePlace->type = $request->input('type');
        $storagePlace->storage_rack_id = $request->input('storage_rack_id');
//        $storageRack->status = $request->input('status');
        $storagePlace->content = $request->input('content');
        $storagePlace->user_id = Auth::user()->id;
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
    public function lists(Request $request)
    {
        $storage_rack_id = $request->input('storage_rack_id');
        $list = StoragePlaceModel::storagePlaceList($storage_rack_id);
        return ajax_json('1','ok',$list);
    }


    /**
     * 编辑仓位信息
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        if($storagePlace = StoragePlaceModel::find($id)){
            $result = ['status' => 1,'data' => $storagePlace];
            return response()->json($result);
        }
    }

    //更新库位信息
    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
            'name'=>'required|max:30',
            'content'=>'required|max:500'
        ];
        $messages = [
            'name.required' => '仓位名称不能为空！',
            'name.max' =>'仓位名称不能大于30个字',
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

    /**
     *删除库位
     *@param Request
     *@return  resource
     */
    public function destroy(Request $request)
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
    
}
