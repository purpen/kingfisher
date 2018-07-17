<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Models\DistributorPaymentModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class MessageController extends BaseController
{
    /**
     * @api {post} /DealerApi/message/addMessage 经销商信息添加
     * @apiVersion 1.0.0
     * @apiName Message addMessage
     * @apiGroup Message
     *
     * @apiParam {string} token token
     * @apiParam {string} name 姓名
     * @apiParam {string} store_name 门店名称
     * @apiParam {integer} area_id 地域分类id
     * @apiParam {integer} category_id 商品分类id
     * @apiParam {string} authorization_id 授权条件
     * @apiParam {string} store_address 门店地址
     * @apiParam {string} operation_situation 经营情况
     * @apiParam {integer} cover_id 图片ID
     * @apiParam {integer} bank_number 银行卡账号
     * @apiParam {string} bank_name 开户行
     * @apiParam {integer} business_license_number 营业执照号
     * @apiParam {string} taxpayer  纳税人类型:1.一般纳税人 2.小规模纳税人
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                            // ID
     *      "name": 小明,           // 姓名
     *      "store_name": 铟立方,           // 门店名称
     *      "area_id": "11",           // 地域分类id
     *      "category_id": "116",           // 商品分类id
     *      "authorization_id": 11,2,                          // 授权条件
     *      "store_address": 北京市朝阳区,                      // 门店地址
     *      "operation_situation": 非常好,                         // 经营情况
     *      "cover_id": "23",                  // 图片ID
     *      "bank_number": "1234567890",              // 银行卡账号
     *      "bank_name": 中国银行,               // 开户行
     *      "business_license_number":  "638272611291",     //营业执照号
     *      "taxpayer": 1,                      // 纳税人类型:1.一般纳税人 2.小规模纳税人
     *      "status": 1,                    // 状态：0.禁用；1.启用；
     *      }
     * ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *       }
     *   }
     */

    public function addMessage(Request $request)
    {
        $distributors = new DistributorPaymentModel();
        $distributors->name = $request['name'];
        $distributors->store_name = $request['store_name'];

        $area_id = $request['area_id'];//地域分类为多选
        $area_ids = substr($area_id,0,-1);
        $distributors->sku_id_arr = explode(',',$area_ids);

        $distributors->category_id = $request['category_id'];

        $authorization_id = $request['authorization_id'];//授权条件为多选
        $authorization_ids = substr($authorization_id,0,-1);
        $distributors->authorization_id = explode(',',$authorization_ids);

        $distributors->store_address = $request['store_address'];
        $distributors->operation_situation = $request['operation_situation'];
        $distributors->cover_id = $request['cover_id'];
        $distributors->bank_number = $request['bank_number'];
        $distributors->bank_name = $request['bank_name'];
        $distributors->business_license_number = $request['business_license_number'];
        $distributors->taxpayer = $request['taxpayer'];
        $res = $distributors->save();

        if ($res) {
            $token = JWTAuth::fromUser($distributors);
            return $this->response->array(ApiHelper::success('添加成功', 200, compact('token')));
        } else {
            return $this->response->array(ApiHelper::error('添加失败，请重试!', 412));
        }

    }
}