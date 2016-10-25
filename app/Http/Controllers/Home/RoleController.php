<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\UserModel;
use App\Models\Permission;
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
        $result = Role::orderBy('created_at','desc')->paginate(15);
        $result->permission = Permission::orderBy('created_at','desc')->get();
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
        $result = Role::where('id',(int)$id)->first();
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
        $role = new Role();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $role = Role::find($id);
        if ($role){
            return ajax_json(1,'获取成功',$role);
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
        $role = Role::find($id);
        if($role->update($request->all())){
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
        // 再次判断ID是否为空
        $res = Role::where('id','=',$request->input('id'))->delete();
        if($res){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
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
        
        $role = Role::where('id', (int)$role_id)->first();
        
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //获取用户角色
        $user = UserModel::all();
        // 获取角色人称
        $role = Role::all();

        // 查找用户的角色信息
        $roleUser = UserModel::select('users.account','users.id','roles.name','roles.id as roleId')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->get();
        // 解析模板
        return view('home.roleuser.index',[
            'user'=>$user,
            'role'=>$role,
            'roleUser'=>$roleUser
        ]);
    }


    /**
     *
     * 用户的角色绑定  提交信息
     */
    public function roleUserStore(Request $request)
    {
        $user = UserModel::where('id', '=', $request->input('user_id'))->first();
        $role = Role::where('id','=',$request->input('role_id'))->first();
        //调用hasRole提供的attachRole方法
        $res = $user->attachRole($role->id); // 参数可以是Role对象，数组或id  这是是没有返回类型得
        if($res == null){
            return ajax_json(1,'添加成功');

        }else{
            return ajax_json(0,'添加失败');

        }
    }

    /**
     *
     *删除用户与角色的信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function roleUserDestroy(Request $request)
    {
        $user_id = $request->input('userId');
        $role_id = $request->input('roleId');
        $res = DB::table('role_user')->where('user_id',$user_id)->where('role_id',$role_id)->delete();
        if($res){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
    }

    /*the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function roleUser()
    {

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




}
