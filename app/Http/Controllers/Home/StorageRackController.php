<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests\AddStorageRackRequest;
use App\Http\Controllers\Controller;
use App\Models\StorageRackModel;
use Illuminate\Support\Facades\Auth;
class StorageRackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view();
    }
    
    /**
     *库区列表
     */
    public function lists(Request $request)
    {
        $storage_id = $request->input('storage_id');
        $list = StorageRackModel::storageRackList($storage_id);
        return ajax_json('1','ok',$list);
    }
    /**
     *添加库区
     */
    public function add(AddStorageRackRequest $request)
    {
        $storageRack = new StorageRackModel;
        $storageRack->name = $request->input('name');
        $storageRack->storage_id = $request->input('storage_id');
        $storageRack->content = $request->input('content');
        $storageRack->user_id = Auth::user()->id;
        if ($storageRack->save()){
            $result = ['status' => 1,'message' => '仓区添加成功'];
            return response()->json($result);
        }else{
            $result = ['status' => 0,'message' => '仓库添加失败'];
            return response()->json($result);
        }
    }

    /**
     * 编辑仓区信息
     */
    public function edit(Request $request)
    {
        if ($request->isMethod('get')){
            $id = $request->input('id');
            if($storageRack = StorageRackModel::find($id)){
                $result = ['status' => 1,'data' => $storageRack];
                return response()->json($result);
            }
            
        }elseif ($request->isMethod('post')){
            $rules = [
                'id' => 'required|integer',
                'name'=>'required|max:30',
                'content'=>'required|max:500'
            ];
            $messages = [
                'name.required' => '仓区名称不能为空！',
                'name.max' =>'仓区名称不能大于30个字',
                'content.required' => '仓区简介不能为空',
                'content.max' => '仓区简介字数不能超过500'
            ];
            $this->validate($request, $rules, $messages);
            $storageRack = StorageRackModel::find($request->id);
            if($storageRack->update($request->all())){
                $result = ['status' => 1,'message' => '仓区更新成功'];
                return response()->json($result);
            }else{
                $result = ['status' => 0,'message' => '仓区更新失败'];
                return response()->json($result);
            }
        }
    }


    /**
     *删除仓区
     *@param Request
     *@return  resource
     */
    public function destroy(Request $request)
    {
        $id = intval($request->input('id'));
        if(StorageRackModel::destroy($id)){
            $result = ['status' => 1,'message' => '仓区删除成功'];
            return response()->json($result);
        }else{
            $result = ['status' => 0,'message' => '仓区删除失败'];
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

}
