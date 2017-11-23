<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Models\DeliveryAddressModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Illuminate\Support\Facades\Validator;

class DeliveryAddressController extends BaseController
{
    /**
     * @api {get} /MicroApi/delivery_address/list 我的收货地址
     * @apiVersion 1.0.0
     * @apiName DeliveryAddress lists
     * @apiGroup DeliveryAddress
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
        $user_id = $this->auth_user_id;
        $this->per_page = $request->input('per_page', $this->per_page);

        $addresses = DeliveryAddressModel::where(['user_id' => $user_id, 'type' => 1, 'status' => 1])->orderBy('id', 'desc')
            ->paginate($this->per_page);

        return $this->response->paginator($addresses, new ProductListTransformer($user_id))->setMeta(ApiHelper::meta());
    }

    /**
     * @api {post} /MicroApi/delivery_address/submit 添加/编辑收货地址
     * @apiVersion 1.0.0
     * @apiName DeliveryAddress submit
     * @apiGroup DeliveryAddress
     *
     * @apiParam {string}   name 姓名
     * @apiParam {string}   phone 电话
     * @apiParam {string}   email 邮箱
     * @apiParam {integer} province_id 省份ID
     * @apiParam {integer} city_id 城市ID
     * @apiParam {integer} county_id 城镇ID
     * @apiParam {integer} town_id 乡ID
     * @apiParam {integer} is_default 是否默认：0.否；1.是；
     * @apiParam {integer} type 备选，默认1
     * @apiParam {string}   zip 邮编
     * @apiParam {string}   address 详细地址
     * @apiParam {string} token token
     */
    public function submit(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        $name = $request->input('name') ? $request->input('name') : '';
        $phone = $request->input('phone') ? $request->input('phone') : '';
        $email = $request->input('email') ? $request->input('email') : '';
        $is_default = $request->input('is_default') ? (int)$request->input('is_default') : 0;
        $type = $request->input('type') ? (int)$request->input('type') : 1;
        $province_id = $request->input('province_id') ? (int)$request->input('province_id') : 0;
        $city_id = $request->input('city_id') ? (int)$request->input('city_id') : 0;
        $county_id = $request->input('county_id') ? (int)$request->input('county_id') : 0;
        $town_id = $request->input('town_id') ? (int)$request->input('town_id') : 0;
        $address = $request->input('address') ? $request->input('address') : '';

        $data = array(
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'is_default' => $is_default,
            'type' => $type,
            'province_id' => $province_id,
            'city_id' => $city_id,
            'county_id' => $county_id,
            'town_id' => $town_id,
            'address' => $address,
        );

        $rules = [
            'name' => 'required|max:20',
            'phone' => 'required|regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'
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
            // throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
            return $this->response->array(ApiHelper::error('请求参数格式不正确！', 401)); 
        }

        $oldDefault = false;
        if (empty($id)) { // 创建
            $data['user_id'] = $user_id;
            $address = DeliveryAddressModel::create($data);
        } else {  // 更新
            $address = DeliveryAddressModel::find($id);
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
                DeliveryAddressModel::updateDefault($address->id, $user_id);
            }
        }

        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $address->id)));
    }

    /**
     * @api {post} /MicroApi/delivery_address/deleted 删除收货地址
     * @apiVersion 1.0.0
     * @apiName DeliveryAddress deleted
     * @apiGroup DeliveryAddress
     *
     * @apiParam {integer} id
     * @apiParam {string} token token
     */
    public function deleted(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        if (empty($id)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 401));
        }

        $address = DeliveryAddressModel::find($id);
        if (!$address) {
            return $this->response->array(ApiHelper::error('收货地址不存在！', 402));
        }

        if ($address->user_id != $user_id) {
            return $this->response->array(ApiHelper::error('无权限操作!', 403));       
        }
        $ok = $address->delete();
        if (!$ok) {
            return $this->response->array(ApiHelper::error('删除收货地址失败!', 500));       
        }
        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $id)));
    }

    /**
     * @api {get} /MicroApi/delivery_address/defaulted 快捷更新默认收货地址
     * @apiVersion 1.0.0
     * @apiName DeliveryAddress defaulted 
     * @apiGroup DeliveryAddress
     *
     * @apiParam {integer} id 
     * @apiParam {string} token token
     */
    public function defaulted(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id') ? (int)$request->input('id') : 0;
        $type = $request->input('type') ? (int)$request->input('type') : 1;
        $address = DeliveryAddressModel::find($id);
        if (empty($address)) {
            return $this->response->array(ApiHelper::error('收货地址不存在！', 402));       
        }

        if ($address->is_default === 1) {
            return $this->response->array(ApiHelper::error('当前已经是默认状态！', 411));        
        }
        $address->is_default = 0;
        $ok = $address->save();

        if (!$ok) {
            return $this->response->array(ApiHelper::error('更新失败！', 500));        
        }

        // 更新其它默认收货值
        DeliveryAddressModel::updateDefault($id, $user_id);

        return $this->response->array(ApiHelper::success('Success.', 200, array('id' => $id)));
    }


}
