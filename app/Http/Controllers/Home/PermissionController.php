<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use DB;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermissionModel;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Permission::orderBy('created_at','desc')->paginate(20);
        return view('home.permission.index', ['data' => $result]);
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
        $result = Permission::where('id',(int)$id)->first();
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
    public function store(PermissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('des');
        $permission->save();
        
        return redirect('/permission');
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
        $permission = Permission::find($id);
        if ($permission){
            return ajax_json(1,'获取成功',$permission);
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
        $permission = Permission::find($id);
        if($permission->update($request->all())){
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
        $res = Permission::where('id','=',$request->input('id'))->delete();
        if($res){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
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
        // 获取角色的信息
        $roles = Role::orderBy('id', 'asc')->get();
        
        //权限信息
        $permissions = Permission::all();

        // 分配变量
        return view('home.rolepermission.index', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     *
     * 用户的角色绑定  提交信息
     */
    public function rolePermissionStore(Request $request)
    {
        //获取角色
        $role=Role::find($request->input('role_id'));

        $role->perms()->sync($request->input('permission'));
        return redirect('/rolePermission')->with('success','角色权限绑定成功');
    }


    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rolePermissionEdit(Request $request)
    {
        // 获取角色的信息
        $roles = Role::orderBy('id', 'asc')->get();
        
        // 权限信息
        $permissions = Permission::all();
        
        // 获取当前角色及权限
        $id = (int)$request->input('id');
        
        $role = Role::findOrfail($id);
        
        $perms = $role->perms;
        
        // 设置角色选中状态
        if (!empty($roles)) {
            $max = count($roles);
            for ($i=0; $i<$max; $i++) {
                if ($roles[$i]['id'] == $role->id) {
                    $roles[$i]['selected'] = 'selected';
                } else {
                    $roles[$i]['selected'] = '';
                }
            }
        }
        
        if (!empty($perms)) {
            $perm_ids = [];
            foreach ($perms as $perm) {
                array_push($perm_ids, $perm->id);
            }
            $max = count($permissions);
            for ($i=0; $i<$max; $i++) {
                if (in_array($permissions[$i]['id'], $perm_ids)) {
                    $permissions[$i]['checked'] = 'checked';
                } else {
                    $permissions[$i]['checked'] = '';
                }
            }
        }
        
        return ajax_json(1, '获取数据成功', [
            'roles' => $roles,
            'current_role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rolePermissionUpdate(Request $request)
    {
        //获取角色
        $role=Role::find($request->input('role_id'));

        $role->perms()->sync($request->input('permission'));
        return redirect('/rolePermission')->with('success','角色权限修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rolePermissionDestroy(Request $request)
    {
        $id = $request->input('id');
        $permission = DB::table('permission_role')->where('role_id',$id)->delete();

        if($permission == 0){
            return redirect('/rolePermission')->with('success','删除成功');
        }else{
            return back()->with('error','删除失败');
        }

    }
}
