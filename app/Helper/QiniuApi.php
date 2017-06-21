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
            'callbackBody' => 'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&random=$(x:random)&user_id=$(x:user_id)&target_id=$(x:target_id)',
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
            'callbackBody' => 'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&product_number=$(x:product_number)',
        );
        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);

        return $upToken;
    }
    
}