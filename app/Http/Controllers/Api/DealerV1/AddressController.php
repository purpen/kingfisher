<?php

namespace App\Http\Controllers\Api\DealerV1;

use Illuminate\Http\Request;

class AddressController extends BaseController
{

    /**
     * @api {get} /DealerApi/address/list 我的收货地址
     * @apiVersion 1.0.0
     * @apiName Address lists
     * @apiGroup Address
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                            // ID
     *      "name": 张明,                   // 收货人
     *      "phone": "15000000000",           // 电话
     *      "email": "test@taihuoniao.com",    // 邮箱
     *      "zip": "101500",                      // 邮编
     *      "province_id": 1,                         // 省份ID
     *      "city_id": 1,                         // 城市ID
     *      "county_id": 1,                         // 区县ID
     *      "town_id": 1,                         // 城镇／乡ID
     *      "address": "酒仙桥798"                // 详细地址
     *      "is_default": 1,                      // 是否默认收货地址
     *      "type": 1,                              // 类型：1 备用
     *      "status": 1,                            // 状态: 0.禁用；1.正常；
     *      }
     * ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "pagination": {
     *           "total": 705,
     *           "count": 15,
     *           "per_page": 15,
     *           "current_page": 1,
     *           "total_pages": 47,
     *           "links": {
     *           "next": "http://erp.me/MicroApi/product/lists?page=2"
     *           }
     *       }
     *   }
     * }
     */

    public function lists(Request $request)
    {

        echo 54321;die;
    }

}