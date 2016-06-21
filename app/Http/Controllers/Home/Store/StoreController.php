<?php

namespace App\Http\Controllers\Home\Store;

use App\Models\StoreModel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = StoreModel::orderBy('id','desc')->get();
        return view('home/store.store',['stores' => $stores]);
    }

    /**
     * 添加店铺
     *
     */
    public function ajaxStore(StoreRequest $request)
    {
        $store = new StoreModel();
        $store->name = $request->input('name');
        $store->number = $request->input('number','');
        $store->target_id = $request->input('target_id','');
        $store->outside_info = $request->input('outside_info','');
        $store->summary = $request->input('summary','');
        $store->user_id = Auth::user()->id;
        $store->status = $request->input('status',1);
        $store->type = $request->input('type',1);
        if($store->save()){
            return ajax_json(1,'添加成功');
        }else{
            return ajax_json(0,'添加失败');
        }
    }

    /*获取更新店铺信息*/
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $store = StoreModel::find($id);
        if ($store){
            return ajax_json(1,'获取成功',$store);
        }else{
            return ajax_json(0,'数据不存在');
        }
    }

    /*更新店铺信息*/
    public function ajaxUpdate(StoreRequest $request)
    {
        $store = StoreModel::find($request->input('id'));
        if($store->update($request->all())){
            return ajax_json(1,'更改成功');
        }else{
            return ajax_json(0,'更改失败');
        }
    }

    /*删除店铺*/
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if(StoreModel::destroy($id)){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
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
