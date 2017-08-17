<?php
/**
 * Qiniu云上传接口工具类
 *
 * @author purpen
 */
namespace App\Helper;

use Log;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class QiniuApi
{
    /**
     * 生成上传图片upToken
     * @return string
     */
    static public function upToken()
    {
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        
        $auth = new Auth($accessKey, $secretKey);
        $bucket = config('qiniu.bucket_name');
        
        // 上传文件到七牛后， 七牛将callbackBody设置的信息回调给业务服务器
        $policy = array(
            'callbackUrl' => config('qiniu.call_back_url'),
            'callbackFetchKey' => 1,
            'callbackBody' => 'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&random=$(x:random)&user_id=$(x:user_id)&target_id=$(x:target_id)&type=$(x:type)&domain=$(x:domain)',
        );

        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);
        
        return $upToken;
    }
    
    /**
     * 安全的Url编码urlsafe_base64_encode函数
     */
    function urlsafe_base64_encode($data)
    {
        $data = base64_encode($data);
        $data = str_replace(array('+','/'),array('-','_'),$data);
        
        return $data;
    }

    /**
     * 生成上传素材库upToken
     * @return string
     */
    static public function upMaterialToken()
    {
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('qiniu.material_bucket_name');
        // 上传文件到七牛后， 七牛将callbackBody设置的信息回调给业务服务器
        $policy = array(
            'callbackUrl' => config('qiniu.material_call_back_url'),
            'callbackFetchKey' => 1,
            'callbackBody' => 'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&random=$(x:random)',
            'persistentNotifyUrl' => config('qiniu.material_persistent_url'),

        );
        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);

        return $upToken;
    }

    /**
     * 上传七牛--不回调
     * @param fileUrl, options
     * @return Array
     */
    static public function uploadFile($fileUrl, $options=array())
    {
        $result = array();
        $bucket_type = isset($options['bucket_type']) ? (int)$options['bucket_type'] : 1;
        $domain = isset($options['domain']) ? $options['domain'] : '';

        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        if($bucket_type === 1){
            $bucket = config('qiniu.bucket_name');
        }elseif($bucket_type === 2){
            $bucket = config('qiniu.material_bucket_name');
        }else{
            $bucket = config('qiniu.bucket_name');       
        }

        $token = $auth->uploadToken($bucket);
        //$filePath = file_get_contents($url);
        $date = time();
        $key = '/'.$domain.'/'.$date.'/'.uniqid();
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $fileUrl);
        if ($err !== null) {
            $result['success'] = false;
            $result['message'] = $err;
        } else {
            $data = array( 'path' => $key);
            $result['success'] = true;
            $result['data'] = $data;
        }

        return $result;
    }
    
}
