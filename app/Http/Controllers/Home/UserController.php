<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use App\Models\Role;
use App\Http\Requests\UserRequest;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserModel::orderBy('created_at','desc')->paginate(20);
        $role = Role::orderBy('created_at','desc')->get();
        return view('home.user.index', ['data' => $data ,'role' => $role ]);
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

        $user->account = $request->input('account');
        $user->phone = $request->input('phone');
        $user->realname = $request->input('realname');
        $user->status = $request->input('status');
        $user->sex = $request->input('sex');
        // 设置默认密码
        $user->password = bcrypt('Thn140301');

        if($user->save()){
            return redirect('/user');
        }else{
            return back()->withInput();
        }
        
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $user = UserModel::find($id);
        if ($user){
            return ajax_json(1,'获取成功',$user);
        }else{
            return ajax_json(0,'数据不存在');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $user = UserModel::find($id);
        if($user->update($request->all())){
            return redirect('/user');
        }else{
            return back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if(UserModel::destroy($id)){
            return ajax_json(0,'删除失败 ');
        }else{
            return ajax_json(1,'删除成功');

        }
    }

    /*
     * 搜索
     *
     */
    public function search(Request $request)
    {
        $name = $request->input('name');
        $result = UserModel::where('account','like','%'.$name.'%')->orWhere('phone','like','%'.$name.'%')->paginate(20);
        if ($result){
            return view('home/user.index',['data'=>$result ]);
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
