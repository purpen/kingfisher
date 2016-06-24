<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Auth;
use Qiniu\Config;

class AssetController extends Controller
{
    /**
     * 生成上传图片upToken
     * @return string
     */
    public function upToken(){
        $accessKey = Config::ACCESS_KEY;
        $secretKey = Config::SECRET_KEY;
        $auth = new Auth($accessKey, $secretKey);

        $bucket = Config::BUCKET_NAME;

        // 上传文件到七牛后， 七牛将文件名和文件大小回调给业务服务器
        $policy = array(
            'callbackUrl' => 'http:///asset/callback',
            'callbackFetchKey' => 1,
            'callbackBody' => 'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&random=$(x:random)',
        );
        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);
        return $upToken;
    }

    //七牛回调方法
    public function callback(){
        $post = $_POST;
        if(empty($post)){
            return false;
        }
        $authstr = $_SERVER['HTTP_AUTHORIZATION'];
        if(strpos($authstr,"QBox ")!=0){
            return false;
        }
        $auth = explode(":",substr($authstr,5));
        if(sizeof($auth)!=2||$auth[0]!=Config::ACCESS_KEY){
            return false;
        }

        $data = "/asset/callback\n".http_build_query($post);
        if($this->urlsafe_base64_encode(hash_hmac('sha1',$data,Config::SECRET_KEY, true)) == $auth[1]){
            /*id	int(11)	否		ID
user_id	int(11)	是		用户ID
target_id	int(11)	是		关联ID
type	tinyint(1)	是	1	附件类型: 1.默认； 2.商品封面；3.商品Banner；4.--
name	varchar(50)	否		文件名
summary	varchar(100)	是		文件描述
random	varchar(20)	是		随机字符串(回调查询)
path	varchar(100)	否		文件路径
size	int(11)	否	0	文件大小
width	int(11)	是	0	宽
height	int(11)	是	0	高
mime	varchar(10)	否		文件类型
domain	varchar(10)	否		存储域
status	tinyint(1)	否	1	状态：0.否；1.是*/
            $imageData = [];
            $imageData['user_id'] = \Illuminate\Support\Facades\Auth::user()->id;
            $imageData['name'] = $post['fname'];
            $imageData['random'] = $post['random'];
            $imageData['size'] = $post['size'];
            $imageData['width'] = $post['width'];
            $imageData['height'] = $post['height'];
            $imageData['mime'] = $post['mime'];
            $imageData['domain'] = Config::DOMAIN;
            $mongoId = new \MongoId();  //获取唯一字符串
            $fix = strrchr($post['fname'],'.');
            $imageData['path'] = '/' . Config::DOMAIN . '/' .date("Ymd") . '/' . $mongoId->id . $fix;
        }
    }

    //安全的url编码 urlsafe_base64_encode函数
    function urlsafe_base64_encode($data) {
        $data = base64_encode($data);
        $data = str_replace(array('+','/'),array('-','_'),$data);
        return $data;
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
