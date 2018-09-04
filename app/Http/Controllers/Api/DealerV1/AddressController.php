<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\AddressTransformer;
use App\Models\AddressModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     *      "zip": "101500",                      // 邮编
     *      "province":北京市,                         // 省份
     *      "city": 朝阳区,                         // 城市
     *      "county": 三环到四环,                         // 区县
     *      "town": 某某村,                         // 城镇／乡
     *      "address": "酒仙桥798"                // 详细地址
     *      "is_default": 1,                      // 是否默认收货地址
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
     *           "next": "http://www.work.com/DealerApi/address/lists?page=2"
     *           }
     *       }
     *   }
     * }
     */

    public function lists(Request $request)
    {
        $user_id = $this->auth_user_id;
        $this->per_page = $request->input('per_page', $this->per_page);

        $addresses = AddressModel::where(['user_id' => $user_id, 'status' => 1])->orderBy('id', 'desc')
            ->paginate($this->per_page);

        return $this->response->paginator($addresses, new AddressTransformer($user_id))->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /DealerApi/address/show 收货地址详情(暂未使用)
     * @apiVersion 1.0.0
     * @apiName Address show
     * @apiGroup Address
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data":
     *      {
     *      "id": 2,                            // ID
     *      "name": 张明,                   // 收货人
     *      "phone": "15000000000",           // 电话
     *      "zip": "101500",                      // 邮编
     *      "province_id": 1,                         // 省份oid
     *      "city_id": 1,                         // 城市oid
     *      "county_id": 1,                         // 区县oid
     *      "town_id": 1,                         // 城镇／乡oid
     *      "address": "酒仙桥798"                // 详细地址
     *      "is_default": 1,                      // 是否默认收货地址
     *      "status": 1,                            // 状态: 0.禁用；1.正常；
     *      }
     *
     * *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *          "pagination": {
     *           "total": 705,
     *           "count": 15,
     *           "per_page": 15,
     *           "current_page": 1,
     *           "total_pages": 47,
     *           "links": {
     *           "next": "http://www.work.com/DealerApi/address/show?page=2"
     *           }
     *       }
     *   }
     * }
     */

    public function show(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        $address = AddressModel::find($id);
        if (empty($address)) {
            return $this->response->array(ApiHelper::error('收货地址不存在！', 402));
        }

        if ($address->user_id !== $user_id) {
            return $this->response->array(ApiHelper::error('无权限查看!', 403));
        }

        return $this->response->item($address, new AddressTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {post} /DealerApi/address/submit 添加/编辑收货地址
     * @apiVersion 1.0.0
     * @apiName Address submit
     * @apiGroup Address
     *
     * @apiParam {string}   id 编辑时必传
     * @apiParam {string}   name 姓名
     * @apiParam {string}   phone 电话
     * @apiParam {integer} province_id 省份oiD
     * @apiParam {integer} city_id 城市oiD
     * @apiParam {integer} county_id 城镇oiD
     * @apiParam {integer} town_id 乡oiD
     * @apiParam {integer} is_default 是否默认：0.否；1.是；
     * @apiParam {string}   address 详细地址
     * @apiParam {string} token token
     */

    public function submit(Request $request)
    {
        $user_id = $this->auth_user_id;
        $address = AddressModel::where('user_id',$this->auth_user_id)->get();
        if (count($address) > 5){
            return $this->response->array(ApiHelper::error('最多只能添加5个收货地址！', 402));
        }
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        $name = $request->input('name') ? $request->input('name') : '';
        $phone = $request->input('phone') ? $request->input('phone') : '';
        $is_default = $request->input('is_default') ? (int)$request->input('is_default') : 0;
        $province_id = $request->input('province_id') ? (int)$request->input('province_id') : 0;
        $city_id = $request->input('city_id') ? (int)$request->input('city_id') : 0;
        $county_id = $request->input('county_id') ? (int)$request->input('county_id') : 0;
        $town_id = $request->input('town_id') ? (int)$request->input('town_id') : 0;
        $address = $request->input('address') ? $request->input('address') : '';

        $data = array(
            'name' => $name,
            'phone' => $phone,
            'is_default' => $is_default,
            'province_id' => $province_id,
            'city_id' => $city_id,
            'county_id' => $county_id,
            'town_id' => $town_id,
            'address' => $address,
        );


        $rules = [
            'name' => 'required|max:20',
            'phone' => ['required' , 'regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
            'address' => 'required|max:100',
            'province_id' => 'required',
            'city_id' => 'required',
        ];

        $massage = [
            'name.required' => '收货人不能为空',
            'name.max' => '收货人不能超过20个字符',
            'phone.required' => '手机号不能为空',
            'phone.regex' => '手机号格式不正确',
            'address.required' => '详细地址不能为空',
            'address.max' => '详细地址不能超过100个字符',
            'province_id.required' => '省份不能为空',
            'city_id.required' => '城市不能为空',
        ];

        $validator = Validator::make($data, $rules, $massage);
        if ($validator->fails()) {
            return $this->response->array(ApiHelper::error('请求参数格式不正确！', 412));
        }


        $oldDefault = false;
        if (empty($id)) { // 创建
            $data['user_id'] = $user_id;
            $address = AddressModel::create($data);
        } else {  // 更新
            $address = AddressModel::find($id);
            if (!$address) {
                return $this->response->array(ApiHelper::error('收货地址不存在！', 402));
            }
            if ($address->user_id !== $user_id) {
                return $this->response->array(ApiHelper::error('没有权限操作！', 403));
            }
            if ($address->is_default === 0) {
                $oldDefault = true;
            }
            $address->update($data);
        }
        if(!$address) {
            return $this->response->array(ApiHelper::error('操作失败！', 500));
        }

        // 更新其它默认值
        if ($address->is_default === 1) {
            if (empty($id) || $oldDefault) {
                AddressModel::updateDefault($address->id, $user_id);
            }
        }

        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $address->id)));
    }

    /**
     * @api {post} /DealerApi/address/deleted 删除收货地址
     * @apiVersion 1.0.0
     * @apiName Address deleted
     * @apiGroup Address
     *
     * @apiParam {integer} id
     * @apiParam {string} token token
     */

    public function deleted(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        if (empty($id)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 412));
        }

        $address = AddressModel::find($id);
        if (!$address) {
            return $this->response->array(ApiHelper::error('收货地址不存在！', 402));
        }

        if ($address->user_id !== $user_id) {
            return $this->response->array(ApiHelper::error('无权限操作!', 403));
        }
        $result = $address->delete();
        if (!$result) {
            return $this->response->array(ApiHelper::error('删除收货地址失败!', 500));
        }
        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $id)));
    }

    /**
     * @api {post} /DealerApi/address/defaulted 更新默认收货地址
     * @apiVersion 1.0.0
     * @apiName Address defaulted
     * @apiGroup Address
     *
     * @apiParam {integer} id
     * @apiParam {string} token token
     */

    public function defaulted(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        $address = AddressModel::find($id);
        if (empty($address)) {
            return $this->response->array(ApiHelper::error('收货地址不存在！', 402));
        }

        if ($address->user_id !== $user_id) {
            return $this->response->array(ApiHelper::error('无权限操作!', 403));
        }

        if ($address->is_default == 1) {
            return $this->response->array(ApiHelper::error('当前已经是默认状态！', 411));
        }
        $address->is_default = 1;
        $result = $address->update();

        if (!$result) {
            return $this->response->array(ApiHelper::error('更新失败！', 500));
        }

        // 更新其它默认收货值
        AddressModel::updateDefault($id, $user_id);

        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $id)));
    }

}