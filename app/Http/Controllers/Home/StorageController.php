<?php

namespace App\Http\Controllers\Home;

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
        return '仓储页面';
    }
    
    
    /**
     * 添加仓库
     * @param Request $request
     * $return
     */
    public function addStorage(Request $request)
    {
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
        if($storage->update($request)){
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
