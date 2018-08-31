<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Helper\QiniuApi;
use App\Http\ApiHelper;
use Illuminate\Http\Request;
use App\Models\AssetsModel;
use Illuminate\Support\Facades\Log;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

class ToolsController extends BaseController
{
    /**
     * @api {post} http://upload.qiniu.com 测试服务器七牛上传url
     * @apiVersion 1.0.0
     * @apiName Tools upload
     * @apiGroup Tools
     *
     * @apiParam {string} token 图片上传upToken
     * @apiParam {integer} x:user_id  用户ID
     * @apiParam {string} x:random   附件随机数
     * @apiParam {integer} x:target_id  目标ID
     * @apiparam {integer} x:type   类型：17.门店正面照片；18.门店内部照片；19.营业执照；20.身份证人像面；21.身份证国徽面
     */

    /**
     * @api {get} /DealerApi/tools/getToken 获取图片上传token
     * @apiVersion 1.0.0
     * @apiName Tools getToken
     * @apiGroup Tools
     *
     * @apiParam {string} token
     *
     * @apiSuccessExample 成功响应:
     *  {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *     "data": {
     *          "token": "asdassfdg",
     *          "url": http://xxx.qinxiu.com,
     *          "random": 5b557dd599c508.76159328,
     *      }
     *   }
     */
    public function getToken()
    {
        $token = QiniuApi::upToken();
        $random = uniqid('', true);

        $data = [
            'token' => $token,
            'random' => $random,
            'url' => config('qiniu.upload_url'),
        ];
        return $this->response->array(ApiHelper::success('Success', 200, $data));
    }

    /**
     * @api {post} http://upload.qiniu.com 测试服务器七牛上传url
     * @apiVersion 1.0.0
     * @apiName Tools upload
     * @apiGroup Tools
     *
     * @apiParam {string} token 图片上传upToken
     * @apiParam {integer} x:user_id  用户ID
     * @apiParam {string} x:random   附件随机数
     * @apiParam {integer} x:target_id  目标ID
     * @apiparam {integer} x:type   17.门店正面照片；18.门店内部照片；19.营业执照；20.身份证人像面；21.身份证国徽面
     */

    /**
     * @api {post} /DealerApi/tools/deleteAsset 删除上传附件
     * @apiVersion 1.0.0
     * @apiName Tools deleteAsset
     * @apiGroup Tools
     *
     * @apiParam {string} token
     * @apiParam {integer} id  图片ID
     *
     * @apiSuccessExample 成功响应:
     *  {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function deleteAsset(Request $request)
    {
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
            if($asset->user_id != $this->auth_user_id){
                return $this->response->array(ApiHelper::error('不是你创建的，你不能删',403));
            }
            $key = $asset->path;
        }else{
            return $this->response->array(ApiHelper::error('文件不存在',404));
        }


        //删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        if ($err !== null) {
            Log::error($err);
        } else {
            if(AssetsModel::destroy($id)){
                return $this->response->array(ApiHelper::success());
            }else{
                return $this->response->array(ApiHelper::error());
            }
        }
    }


}