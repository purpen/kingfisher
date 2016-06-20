<?php

namespace App\Http\Controllers\Home\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = RoleModel::orderBy('created_at','desc')->paginate(5);
        $result->permission = PermissionModel::orderBy('created_at','desc')->get();
        return view('home.role.index', ['data' => $result]);
    }
    
    /**
     * ajax获取一条数据.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxFirst($id)
    {
        if(!$id){
            return ajax_json(0,'请求参数不存在！');
        }
        $result = RoleModel::where('id',(int)$id)->first();
        if(!$result){
            return ajax_json(0,'请求数据失败！');
        }
        return ajax_json(1,'请求数据成功！',$result);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        
        $role = new RoleModel();
        if($request->input('id')){
            $role = $role::where('id', (int)$request->input('id'))->first();
        }
        
        $role->name = $request->input('name') ? $request->input('name') : $role->name;
        $role->display_name = $request->input('display_name') ? $request->input('display_name') : $role->display_name;
        $role->description = $request->input('des') ? $request->input('des') : $role->description;
        $result = $role->save();
        
        $permissions = [];
        if($request->input('permissions')){
            $permissions = $request->input('permissions');
        }
        
        if($result){
            $this->setPermissions($role->id, $permissions);
        }
        
        return redirect('/role');
    }
    
    /**
     * 为角色添加权限
     * @param  int  $role_id 角色id
     * @param  array  $permissions 权限id数组
     * @return 
     */
    public function setPermissions($role_id, $permissions = [])
    {
        if(!$role_id || !$permissions){
            return false;
        }
        
        $role = RoleModel::where('id', (int)$role_id)->first();
        
        if(!$role){
            return false;  
        }
        
        if(is_array($permissions)){
            foreach ($permissions as $v) {
                $role->perms()->attach($v);
            }
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
