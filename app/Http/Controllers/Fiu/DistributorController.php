<?php

namespace App\Http\Controllers\Fiu;

use App\Http\Models\User;
use App\Models\OrderMould;
use App\Models\UserModel;
use function foo\func;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DistributorController extends Controller
{
    /**
     * 审核通过的分销商列表
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserModel::where('verify_status', 3)->where('type', 1)->paginate(15);
        $moulds = OrderMould::get();
        return view('fiu/distributor.index', [
            'users' => $users,
            'moulds' => $moulds,
            'status' => 3
        ]);

    }


    /**
     * 拒绝的分销商列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refuseStatus()
    {
        $users = UserModel::where('verify_status', 2)->where('type', 1)->paginate(15);
        $moulds = OrderMould::get();

        return view('fiu/distributor.index', [
            'users' => $users,
            'moulds' => $moulds,
            'status' => 2
        ]);

    }


    /**
     * 待审核的分销商列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function noStatusIndex()
    {
        $users = UserModel::where('verify_status', 1)->where('type', 1)->paginate(15);
        $moulds = OrderMould::get();

        return view('fiu/distributor.index', [
            'users' => $users,
            'moulds' => $moulds,
            'status' => 1
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new UserModel();
        $user->account = $request->input('account');
        $phone = $request->input('phone');
        $u = UserModel::where('phone' , $phone)->first();
        if($u){
            return back()->with('error_message', '手机号已存在！')->withInput();

        }
        $user->phone = $phone;
        $user->realname = $request->input('realname');
        $user->sex = $request->input('sex');
        // 设置默认密码
        $user->password = bcrypt('Thn140301');
        $user->type = 1;
        $user->status = 0;
        $user->verify_status = 1;
        $user->mould_id = $request->input('mould_id');;

        if ($user->save()) {
            return redirect('/fiu/saas/user');
        } else {
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $user = UserModel::find($id);
        if ($user) {
            return ajax_json(1, '获取成功', $user);
        } else {
            return ajax_json(0, '数据不存在');
        }
    }

    /**
     * 获取用户资料信息
     */
    public function ajaxUserInfo(Request $request)
    {
        $id = $request->input('id');

        $user = UserModel::find($id);
        $distributor = $user->distribution ? $user->distribution : null;
        $license_image = null;
        $document_image = null;
        if ($distributor) {
            $license_image = $distributor->license_image;
            $document_image = $distributor->document_image;
        }

        if ($user) {
            return ajax_json(1, '获取成功', [
                'user' => $user,
                'distributor' => $distributor,
                'license_image' => $license_image,
                'document_image' => $document_image
            ]);
        } else {
            return ajax_json(0, '数据不存在');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        dd($request->all());
        $id = (int)$request->input('id');
        $user = UserModel::findOrFail($id);

        if ($request->has('realname')) {
            $user->realname = $request->input('realname');
        }

        if ($request->has('sex')) {
            $user->sex = $request->input('sex');
        }
        $user->mould_id = $request->input('mould_id');

        $res = $user->save();
        if (!$res) {
            return back()->withInput();
        }

        return redirect('/fiu/saas/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if (UserModel::destroy($id)) {
            return ajax_json(0, '删除失败 ');
        } else {
            return ajax_json(1, '删除成功');

        }
    }

    public function status(Request $request, $id)
    {
        $ok = UserModel::okStatus($id, 1);
        return back()->with('error_message', '审核成功！')->withInput();
    }

    public function unStatus(Request $request, $id)
    {
        $ok = UserModel::okStatus($id, 0);
        return back()->with('error_message', '关闭成功！')->withInput();
    }

    /**
     * 分销商资料审核操作
     *
     * @param $id
     * @param $status
     */
    public function verifyStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $user = UserModel::find($id);
        if ($status) {
            $user->verify_status = 3;
        } else {
            $user->verify_status = 2;
        }
        $user->save();

        return back()->with('error_message', '操作成功！')->withInput();
    }
}
