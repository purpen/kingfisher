<?php

namespace App\Http\Controllers\Common;

use App\Models\AssetsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

class AssetController extends Controller
{
    /**
     * 生成上传图片upToken
     * @return string
     */
    public function upToken(){
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('qiniu.bucket_name');

        // 上传文件到七牛后， 七牛将callbackBody设置的信息回调给业务服务器
        $policy = array(
            'callbackUrl' => config('qiniu.call_back_url'),
            'callbackFetchKey' => 1,
            'callbackBody' => 'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&random=$(x:random)&user_id=$(x:user_id)&target_id=$(x:target_id)',
        );
        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);
        
        return $upToken;
    }

    //七牛回调方法
    public function callback(Request $request){
        $post = $request->all();
            $imageData = [];
            $imageData['user_id'] = $post['user_id'];
            $imageData['name'] = $post['name'];
            $imageData['random'] = $post['random'];
            $imageData['size'] = $post['size'];
            $imageData['width'] = $post['width'];
            $imageData['height'] = $post['height'];
            $imageData['mime'] = $post['mime'];
            $imageData['domain'] = config('qiniu.domain');
            $imageData['target_id'] = $post['target_id'];
            $key = uniqid();
            $imageData['path'] = config('qiniu.domain') . '/' .date("Ymd") . '/' . $key;
            if($asset = AssetsModel::create($imageData)){
                $id = $asset->id;
                $callBackDate = [
                    'key' => $asset->path,
                    'payload' => [
                        "success" => 1,
                        "name" => config('qiniu.url').$asset->path,
                        'asset_id' => $id
                    ]
                ];
                return response()->json($callBackDate);
            }
    }

    //安全的url编码 urlsafe_base64_encode函数
    function urlsafe_base64_encode($data) {
        $data = base64_encode($data);
        $data = str_replace(array('+','/'),array('-','_'),$data);
        return $data;
    }

    //删除图片
    public function ajaxDelete(Request $request){
        $id = $request->input('id');
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');

        //初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);

        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);

        //你要测试的空间， 并且这个key在你空间中存在
        $bucket = config('qiniu.bucket_name');

        if($asset = AssetsModel::find($id)){
            $key = $asset->path;
        }else{
            exit('图片不存在');
        }


        //删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        if ($err !== null) {
            Log::error($err);
        } else {
            if(AssetsModel::destroy($id)){
                return ajax_json(1,'图片删除成功');
            }else{
                return ajax_json(0,'图片删除失败');
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
