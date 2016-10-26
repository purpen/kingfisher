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
        $role = Role::all();
        //权限信息
        $permission = Permission::all();

        $role_per = RolePermissionModel::groupBy('role_id')->get();
//        $array=[];
//        dd($role_per);
        $per_role = RolePermissionModel::orderBy('role_id','desc')->paginate(20);
//        foreach($per_role as $per){
//            $array[$per['role_id']][]=$per;
//        }
//        dd($array);

//
//        $sql = Role::group_concat('permissions.display_name')->leftJoin('permission_role','roles.id', '=' , 'permission_role.role_id')
//            ->leftJoin('permissions','permission_role.permission_id','=','permissions.id')->groupBy('role_id')->get();
//dd($sql);
//        $sql = select group_concat('permission.display_name')->leftJoin('permission_role','roles.id', '=' , 'permission_role.role_id')
//            ->leftJoin('permissions','permission_role.permission_id','=','permissions.id')->groupBy('role_id')->get()
//        dd($sql);



        // 分配变量
        return view('home.rolepermission.index',[
            'role'=>$role,
            'permission'=>$permission,
            'per_role'=>$per_role
//             'array'=>$array
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
