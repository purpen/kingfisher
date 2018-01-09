<?php

namespace App\Http\Controllers\Fiu;

use App\Http\Models\User;
use App\Jobs\SendExcelOrder;
use App\Models\FileRecordsModel;
use App\Models\OrderMould;
use App\Models\ProductsSkuModel;
use App\Models\UserModel;
use function foo\func;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Qiniu\Storage\UploadManager;

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
        $users = UserModel::where('verify_status', 3)->where('type', 1)->orderBy('id' , 'desc')->paginate(15);
        $moulds = OrderMould::get();
        return view('fiu/distributor.index', [
            'users' => $users,
            'moulds' => $moulds,
            'status' => 3,
        ]);

    }


    /**
     * 拒绝的分销商列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refuseStatus()
    {
        $users = UserModel::where('verify_status', 2)->where('type', 1)->orderBy('id' , 'desc')->paginate(15);
        $moulds = OrderMould::get();

        return view('fiu/distributor.index', [
            'users' => $users,
            'moulds' => $moulds,
            'status' => 2,

        ]);

    }


    /**
     * 待审核的分销商列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function noStatusIndex()
    {
        $users = UserModel::where('verify_status', 1)->where('type', 1)->orderBy('id' , 'desc')->paginate(15);
        $moulds = OrderMould::get();

        return view('fiu/distributor.index', [
            'users' => $users,
            'moulds' => $moulds,
            'status' => 1,

        ]);

    }

    /**
     * 所有分销商列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allStatusIndex()
    {
        $users = UserModel::where('type', 1)->orderBy('id' , 'desc')->paginate(15);
        $moulds = OrderMould::get();

        return view('fiu/distributor.index', [
            'users' => $users,
            'moulds' => $moulds,
            'status' => 4,

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
        $user->password = bcrypt('123456');
        $user->type = 1;
        $user->status = 0;
        $user->verify_status = 1;
        $user->mould_id = $request->input('mould_id') ? $request->input('mould_id') : 0;

        if ($user->save()) {
            return back()->withInput();
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

        return back()->withInput();
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
        if ($status == 0) {
            $user->verify_status = 2;
        } else {
            $user->verify_status = 3;
        }
        $user->save();

        return back()->with('error_message', '操作成功！')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request)
    {
        $id = $request->input('id');
        $user = UserModel::find($id);
        if ($user) {
            return ajax_json(1, '获取成功', $user);
        } else {
            return ajax_json(0, '数据不存在');
        }
    }


    public function distributorInExcel(Request $request)
    {
        $user_id = Auth::user()->id;
        $mould_id = $request->input('mould_id');
        $distributor_id = $request->input('distributor_id');
        if($mould_id == 0){
            return back()->with('error_message', '没有绑定默认的模版！')->withInput();
        }

        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return back()->with('error_message', '上传失败！')->withInput();
        }
        $file = $request->file('file');
        //文件记录表保存
        $fileName = $file->getClientOriginalName();
        $file_type = explode('.', $fileName);
        $mime = $file_type[1];

        if(!in_array($mime , ["csv" , "xlsx" , "xls"])){
            return back()->with('error_message', '请选择正确的文件格式！')->withInput();
        }

        $fileSize = $file->getClientSize();
        $file_records = new FileRecordsModel();
        $file_records['user_id'] = $user_id;
        $file_records['status'] = 0;
        $file_records['file_name'] = $fileName;
        $file_records['file_size'] = $fileSize;
        $file_records->save();
        $file_records_id = $file_records->id;

        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new \Qiniu\Auth($accessKey, $secretKey);

        $bucket = config('qiniu.material_bucket_name');

        $token = $auth->uploadToken($bucket);
        $filePath = $file->getRealPath();
        $key = 'orderExcel/' . date("Ymd") . '/' . uniqid();
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 put 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        //七牛的回掉地址
        $data = config('qiniu.material_url') . $key;
        //进行队列处理
        $this->dispatch(new SendExcelOrder($data, $user_id, 0, $mime, $file_records_id , 2 , $mould_id , $distributor_id));
        return back()->with('error_message', '导入成功！')->withInput();

    }
}
