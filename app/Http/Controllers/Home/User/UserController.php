<?php

namespace App\Http\Controllers\Home\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
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
        return view('home.user.index', ['data' => $result]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(UserRequest $request)
    {
        //
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
