<?php

namespace App\Http\Controllers\Home\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RoleModel;
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
        //
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
        $role = new RoleModel();
        $role->name = 'owner';
        $role->display_name = 'Project Owner';
        $role->description = 'User is the owner of a given project';
        $role->name = 'admin';
        $role->display_name = 'User Administrator';
        $role->description = 'User is allowed to manage and edit other users';
        $role->save();
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
                $role->roles()->attach($v);
            }
        }
    }
}
