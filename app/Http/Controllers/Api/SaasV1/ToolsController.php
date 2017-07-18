<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Helper\QiniuApi;
use App\Http\ApiHelper;

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
     */

    /**
     * @api {get} /saasApi/tools/getToken 获取图片上传token
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
     *          "token": "asdassfdg"
     *      }
     *   }
     */
    public function getToken()
    {
        $token = QiniuApi::upToken();

        return $this->response->array(ApiHelper::success('Success', 200, ['token' => $token]));
    }
}