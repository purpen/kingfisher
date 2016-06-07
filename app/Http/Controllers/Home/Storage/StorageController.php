<?php

namespace App\Http\Controllers\Home\Storage;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StorageModel;
class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.storage');
    }
    
    
    /**
     * 添加仓库
     * @param Request $request
     * $return
     */
    public function addStorage(Requests\AddStorageRequest $request)
    {
        if ($request->isMethod('get'))
        {
            return '添加表单';
        }elseif ($request->isMethod('post'))
        {
            $storage = new StorageModel;
            $storage->name = $request->input('name');
            $storage->content = $request->input('content');
            $storage->number = $request->input('number');
            $storage->type = $request->input('type');
            $storage->city_id = 1;
            $storage->status = 1;
            $storage->user_id = 1;
            if($storage->save())
            {
                $result = ['status' => 1,'message' => '仓库添加成功'];
                return response()->json($result);
            }else
            {
                $result = ['status' => 0, 'message' => '仓库添加失败'];
                return response()->json($result);
            }
        }

    }

    /**
     *编辑仓库信息
     * @param Request $request
     * $return str
     */
    public function editStorage(Request $request)
    {
        if ($request->isMethod('get'))
        {
            $id = $request->input('id');
            if($storage = StorageModel::find($id)->toArray())
            {
                $result = ['status' => 1,'data' => $storage];
                return response()->json($result);
            }

        }elseif ($request->isMethod('post'))
        {
            $rules = [
                'id' => 'required|integer',
                'name'=>'required|max:30|unique:storage',
                'number'=>'required|max:10|unique:storage',
                'content'=>'required|max:500',
                'city_id'=>'required'
            ];
            $messages = [
                'id' => '仓库id不能为空',
                'name.unique' => '仓库名已存在',
                'number.unique' => '仓库编号已存在',
                'name.required' => '仓库名称不能为空！',
                'name.max' =>'仓库名称不能大与30个字',
                'number.required' => '仓库编号不能为空',
                'number.max' => '仓库编号长度不能大于10',
                'content.required' => '仓库简介不能为空',
                'content.max' => '仓库简介字数不能超过500',
                'city_id.required' => '所在城市不能为空'
            ];
            $this->validate($request, $rules,$messages);
            $storage = StorageModel::find($request->id);
            if($storage->update($request->all())){
                $result = ['status' => 1,'message' => '仓库更新成功'];
                return response()->json($result);
            }else{
                $result = ['status' => 0,'message' => '仓库更新失败'];
                return response()->json($result);
            }
        }

    }
    
    /**
     *删除仓库
     *@param string  $id
     *@return  resource
     */
    public function destroyStorage($id)
    {
        $id = intval($id);
        if(StorageModel::destroy($id)){
            $result = ['status' => 1,'message' => '仓库删除成功'];
            return response()->json($result);
        }else{
            $result = ['status' => 0,'message' => '仓库删除失败'];
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
