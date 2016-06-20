<?php

namespace App\Http\Controllers\Home\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = UserModel::orderBy('created_at','desc')->paginate(5);
        $result->role = RoleModel::orderBy('created_at','desc')->get();
        return view('home.user.index', ['data' => $result]);
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
        $result = UserModel::where('id',(int)$id)->first();
        if(!$result){
            return ajax_json(0,'请求数据失败！');
        }
        return ajax_json(1,'请求数据成功！',$result);
    }
    
    /**
     * 新增用户和编辑用户信息.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new UserModel();
        if($request->input('id')){
            $user = $user::where('id', (int)$request->input('id'))->first();
        }
        
        $user->account = $request->input('account') ? $request->input('account') : $user->account;
        $user->phone = $request->input('phone') ? $request->input('phone') : $user->phone;
        $user->password = bcrypt('123456');
        $result = $user->save();
        
        $roles = [];
        if($request->input('roles')){
            $roles = $request->input('roles');
        }
        
        if($result){
            $this->setRoles($user->id, $roles);
        }
        
        return redirect('/user');
    }
    
    /**
     * 为用户添加角色
     * @param  int  $user_id 用户id
     * @param  array  $roles 角色id数组
     * @return 
     */
    public function setRoles($user_id, $roles = [])
    {
        if(!$user_id || !$roles){
            return false;
        }
        
        $user = UserModel::where('id', (int)$user_id)->first();
        
        if(!$user){
            return false;  
        }
        
        if(is_array($roles)){
            foreach ($roles as $v) {
                $user->roles()->attach($v);
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
