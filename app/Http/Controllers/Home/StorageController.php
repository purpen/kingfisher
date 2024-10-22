<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StorageModel;
use Illuminate\Support\Facades\Auth;
class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home/storage.storage');
    }
    
    
    /**
     * 添加仓库
     * @param Request $request
     * $return
     */
    public function add(Requests\AddStorageRequest $request)
    {
        $storage = new StorageModel;
        $storage->name = $request->input('name');
        $storage->address = $request->input('address');
        $storage->content = $request->input('content');
        $storage->type = $request->input('type');
        $storage->city_id = 1;
        $storage->status = 1;
        $storage->user_id = Auth::user()->id;;
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
    
    /**
     * 仓库列表展示
     * @param status 1或0
     * @return json
     */
    public function lists(Request $request){
        $status = $request->input('status');
        $list = StorageModel::storageList($status);
        return ajax_json('1','ok',$list);
    }
    /**
     *获取仓库信息
     * @param Request $request
     * @return json 
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        if($storage = StorageModel::find($id))
        {
            $result = ['status' => 1,'data' => $storage];
            return response()->json($result);
        }

    }

    /**
     * 更新仓库信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|integer',
            'name'=>'required|max:30',
            'content'=>'required|max:500'
        ];
        $messages = [
            'id' => '仓库id不能为空',
            'name.required' => '仓库名称不能为空！',
            'name.max' =>'仓库名称不能大与30个字',
            'content.required' => '仓库简介不能为空',
            'content.max' => '仓库简介字数不能超过500',
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
    
    /**
     *删除仓库
     *@param Request
     *@return  resource
     */
    public function destroy(Request $request)
    {
        $id = intval($request->input('id'));
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
    
}
