<?php

namespace App\Http\Controllers\Home;

use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserModel::where('type' , 1)->where('status' , 1)->paginate(15);

        return view('home/distributor.index' , [
            'users' => $users,
            'status' => 1
        ]);

    }

    public function noStatusIndex()
    {
        $users = UserModel::where('type' , 1)->where('status' , 0)->paginate(15);

        return view('home/distributor.index' , [
            'users' => $users ,
            'status' => 0
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new UserModel();
        $user->account = $request->input('account');
        $user->phone = $request->input('phone');
        $user->realname = $request->input('realname');
        $user->sex = $request->input('sex');
        // 设置默认密码
        $user->password = bcrypt('Thn140301');
        $user->type = 1;
        $user->status = 1;

        if($user->save()){
            return redirect('/saas/user');
        }else{
            return back()->withInput();
        }
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

        if ($request->has('sex')) {
            $user->sex = $request->input('sex');
        }
        $res = $user->save();
        if (!$res) {
            return back()->withInput();
        }

        return redirect('/saas/user');
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


    public function status(Request $request, $id)
    {
        $ok = UserModel::okStatus($id, 1);
        return back()->withInput();
    }

    public function unStatus(Request $request, $id)
    {
        $ok = UserModel::okStatus($id, 0);
        return back()->withInput();
    }
}
