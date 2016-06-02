<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StorageModel;
use Illuminate\Support\Facades\Validator;
class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return '仓储页面';
    }
    
    
    /**
     * 添加仓库
     * @param Request $request
     * $return
     */
    public function addStorage(Request $request)
    {
        $rules = [
            'name'=>'required|max:30',
            'number'=>'required|max:10',
            'content'=>'required|max:500',
            'city_id'=>'required'
        ];
        $messages = [
            'name.required' => '仓库名称不能为空！',
            'name.max' =>'仓库名称不能大与30个字',
            'number.required' => '仓库编号不能为空',
            'number.max' => '仓库编号长度不能大于10',
            'content.required' => '仓库简介不能为空',
            'content.max' => '仓库简介字数不能超过500',
            'city_id.required' => '所在城市不能为空'
        ];
        $this->validate($request, $rules,$messages);
        $storage = new StorageModel;
        $storage->name = $request->name;
        $storage->number = $request->number;
        $storage->content = $request->content;
        $storage->type = $request->type;
        $storage->city_id = $request->city_id;
        $storage->status = $request->status;
        $storage->user_id = 'user_id';
        if($storage->save()){
            return '添加成功';
        }else{
            return '添加失败';
        }
    }

    /**
     *编辑仓库信息
     * @param Request $request
     * $return str
     */
    public function editStorage(Request $request){
        $storage = StorageModel::find($request->id);
        if($storage->update($request->all())){
            return '更新成功';
        }else{
            return '更新失败';
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
