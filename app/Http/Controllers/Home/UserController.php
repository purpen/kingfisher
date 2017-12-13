<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use Auth;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use App\Models\Role;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Helper\QiniuApi;

class UserController extends Controller
{
    /**
     * 初始化
     */
    public function __construct()
    {
        // 设置菜单状态
        View()->share('tab_menu', 'active');
    }

    /**
     *
     *全部
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->tab_menu = 'all';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function display_tab_list($department ='all')
    {
        $name = '';

        if ($department === 'all'){
            $data = UserModel::orderBy('created_at','desc')->paginate($this->per_page);
        } else {
            $data = UserModel::where('department' , $department)->orderBy('created_at','desc')->paginate($this->per_page);
        }
        $role = Role::orderBy('created_at','desc')->get();

        return view('home.user.index', [
            'data' => $data ,
            'role' => $role,
            'name'=>$name,
            'department' => $department,
            'tab_menu' => $this->tab_menu,
            'per_page' => $this->per_page,
            'type' => 0

        ]);
    }

    /**
     *
     *默认
     * @return \Illuminate\Http\Response
     */
    public function defaultList(Request $request)
    {
        $this->tab_menu = 'default';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(0);
    }

    /**
     *
     *fiu
     * @return \Illuminate\Http\Response
     */
    public function fiuList(Request $request)
    {
        $this->tab_menu = 'fiu';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(1);
    }

    /**
     *
     *d3in
     * @return \Illuminate\Http\Response
     */
    public function d3inList(Request $request)
    {
        $this->tab_menu = 'd3in';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(2);
    }

    /**
     *
     *abroad
     * @return \Illuminate\Http\Response
     */
    public function abroadList(Request $request)
    {
        $this->tab_menu = 'abroad';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(3);
    }

    /**
     *
     *onlineRetailers
     * @return \Illuminate\Http\Response
     */
    public function onlineRetailersList(Request $request)
    {
        $this->tab_menu = 'onlineRetailers';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(4);
    }


    /**
     *
     *support
     * @return \Illuminate\Http\Response
     */
    public function supportList(Request $request)
    {
        $this->tab_menu = 'support';
        $this->per_page = $request->input('per_page', $this->per_page);

        return $this->display_tab_list(5);
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
        $user->department = $request->input('department');
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
        $id = (int)$request->input('id');
        
        $user = UserModel::findOrFail($id);
        
        if ($request->has('realname')) {
            $user->realname = $request->input('realname');
        }
        
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        
        if ($request->has('sex')) {
            $user->sex = $request->input('sex');
        }
        
        if ($request->has('cover_id')) {
            $user->cover_id = $request->input('cover_id');
        }
        
        if ($request->has('status')) {
            $user->status = $request->input('status');
        }

        if($request->has('department')){
            $user->department = $request->input('department');
        }
        
        $res = $user->save();
        
        if (!$res) {
            return back()->withInput();
        }
        
        return redirect('/home');
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
        $type = $request->input('type');
        if($type){
            $result = UserModel::where('type' , $type)->paginate(20);
        }else{
            $result = UserModel::where('account','like','%'.$name.'%')->where('type' , $type)->orWhere('phone','like','%'.$name.'%')->paginate(20);
        }
        $role = Role::orderBy('created_at','desc')->get();
        if ($result){
            return view('home/user.index',[
                'data' => $result,
                'role' => $role,
                'name' => $name,
                'type' => $type
            ]);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = UserModel::findOrfail(Auth::user()->id);
        
        return view('home.user.edit', [
            'user' => $user,
            'upload_url' => config('qiniu.upload_url'),
            'uptoken' => QiniuApi::upToken(),
        ]);
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
