<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Http\DealerTransformers\CategoryTransformer;
use App\Http\DealerTransformers\CityTransformer;
use App\Http\DealerTransformers\DistributorTransformer;
use App\Models\AssetsModel;
use App\Models\CategoriesModel;
use App\Models\ChinaCityModel;
use App\Models\DistributorPaymentModel;
use App\Models\DistributorModel;
use App\Models\User;
use App\Models\UserModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class MessageController extends BaseController
{

    /**
     * @api {get} /DealerApi/message/show 经销商信息展示
     * @apiVersion 1.0.0
     * @apiName Message show
     * @apiGroup Message
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                            // ID
     *      "user_id": 1,                            // 用户ID
     *      "name": 小明,           // 姓名
     *      "phone": 13265363728,           // 电话
     *      "store_name": 铟立方,           // 门店名称
     *      "province_id": 1,                         // 省份ID
     *      "city_id": 1,                         // 城市ID
     *      "category_id": "116",           // 商品分类id
     *      "authorization_id": 11,2,                          // 授权条件
     *      "store_address": 北京市朝阳区,                      // 门店地址
     *      "operation_situation": 非常好,                         // 经营情况
     *      "front_id": "1",                  // 门店正面照片
     *      "Inside_id": "2",                  // 门店内部照片
     *      "portrait_id": "3",                  // 身份证人像面照片
     *      "national_emblem_id": "4",                  // 身份证国徽面照片
     *      "license_id": "5",                  // 营业执照照片
     *      "bank_number": "1234567890",              // 银行卡账号
     *      "bank_name": 中国银行,               // 开户行
     *      "business_license_number":  "638272611291",     //营业执照号
     *      "taxpayer": 1,                      // 纳税人类型:1.一般纳税人 2.小规模纳税人
     *  *    "status": 1,                    // 状态：1.待审核；2.已审核；3.关闭；4.重新审核
     *      }
     * ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *       }
     *   }
     */

    public function show(Request $request)
    {
        $user_id = $this->auth_user_id;
        $distributors = DistributorModel::where('user_id', $this->auth_user_id)->get();
        if (count($distributors)>0){
            $a = '';
            $b = '';
            foreach ($distributors as $v){
                $a = $v['province_id'];
                $b = $v['category_id'];

            $province = ChinaCityModel::where('oid',$a)->select('name')->first();
            $category = CategoriesModel::where('id',$b)->select('title')->first();

            $authorizations = explode(',', $v['authorization_id']);

            }

            $authorization = CategoriesModel::whereIn('id', $authorizations)->select('title')->get();

            $str = '';
            foreach ($authorization as $value) {
                $str .= $value['title'] . ',';
            }

            $distributors[0]['authorization'] = $str;
            $distributors[0]['category'] = $category->toArray()['title'];
            $distributors[0]['province'] = $province->toArray()['name'];

        }
        return $this->response->collection($distributors, new DistributorTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /DealerApi/message/city 省份列表
     * @apiVersion 1.0.0
     * @apiName Message cities
     * @apiGroup Message
     *
     * @apiParam {string} token token
     */
    public function city()
    {
        $china_city = ChinaCityModel::where('layer',1)->get();
        return $this->response()->collection($china_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /DealerApi/message/fetchCity 根据省份查看下级城市的列表
     * @apiVersion 1.0.0
     * @apiName Message fetchCity
     * @apiGroup Message
     *
     * @apiParam {integer} oid 唯一（父id）
     * @apiParam {integer} layer 级别（子id）2
     * @apiParam {string} token token
     */
    public function fetchCity(Request $request)
    {
        $oid = (int)$request->input('value');
        $layer = (int)$request->input('layer');
        $chinaModel = new ChinaCityModel();
        $fetch_city = $chinaModel->fetchCity($oid,$layer);
        
        if ($layer == 1){
            $fetch_city = ChinaCityModel::where('layer',1)->where('oid',$oid)->first();
        }

        return $this->response()->collection($fetch_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }


    /**
     * @api {get} /DealerApi/message/category 商品分类列表
     * @apiVersion 1.0.0
     * @apiName Message category
     * @apiGroup Message
     *
     * @apiParam {string} token token
     */
    public function category()
    {
        $category = CategoriesModel::where('type','=',1)->where('status',1)->get();
        return $this->response()->collection($category, new CategoryTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /DealerApi/message/authorization 获取授权条件
     * @apiVersion 1.0.0
     * @apiName Message authorization
     * @apiGroup Message
     *
     * @apiParam {string} token token
     */
    public function authorization()
    {
        $category = CategoriesModel::where('type','=',2)->where('status',1)->get();
        return $this->response()->collection($category, new CategoryTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {post} /DealerApi/message/addMessage 经销商信息添加
     * @apiVersion 1.0.0
     * @apiName Message addMessage
     * @apiGroup Message
     *
     * @apiParam {string} token token
     * @apiParam {string} random 随机数
     * @apiParam {string} name 姓名
     * @apiParam {string} store_name 门店名称
     * @apiParam {string} phone 电话
     * @apiParam {integer} user_id 用户ID
     * @apiParam {integer} province_id 省份ID
     * @apiParam {integer} city_id 城市ID
     * @apiParam {integer} category_id 商品分类id
     * @apiParam {string} authorization_id 授权条件
     * @apiParam {string} store_address 门店地址
     * @apiParam {string} operation_situation 经营情况
     * @apiParam {integer} front_id 门店正面照片
     * @apiParam {integer} Inside_id 门店内部照片
     * @apiParam {integer} portrait_id 身份证人像面照片
     * @apiParam {integer} national_emblem_id 身份证国徽面照片
     * @apiParam {integer} license_id 营业执照照片
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
     *      "user_id": 2,                            // 用户ID
     *      "name": 小明,           // 姓名
     *      "phone": 13265363728,           // 电话
     *      "store_name": 铟立方,           // 门店名称
     *      "province_id": 1,                         // 省份oid
     *      "city_id": 1,                         // 城市oid
     *      "category_id": "116",           // 商品分类id
     *      "authorization_id": 11,2,                          // 授权条件
     *      "store_address": 北京市朝阳区,                      // 门店地址
     *      "operation_situation": 非常好,                         // 经营情况
     *      "front_id": "1",                  // 门店正面照片
     *      "Inside_id": "2",                  // 门店内部照片
     *      "portrait_id": "3",                  // 身份证人像面照片
     *      "national_emblem_id": "4",                  // 身份证国徽面照片
     *      "license_id": "5",                  // 营业执照照片
     *      "bank_number": "1234567890",              // 银行卡账号
     *      "bank_name": 中国银行,               // 开户行
     *      "business_license_number":  "638272611291",     //营业执照号
     *      "taxpayer": 1,                      // 纳税人类型:1.一般纳税人 2.小规模纳税人
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
        $distributors = new DistributorModel();
        $distributors->name = $request['name'];

        $user_id = DistributorModel::where('user_id',$this->auth_user_id)->select('user_id')->first();
        if ($user_id) {
            return $this->response->array(ApiHelper::error('error', 403));
        }
        $distributors->user_id = $this->auth_user_id;
        $distributors->store_name = $request['store_name'];

        $distributors->province_id = $request['province_id'];//省oid
        $distributors->city_id = $request['city_id'];//市oid

        $distributors->phone = $request['phone'];//电话
        $distributors->category_id = $request['category_id'];

        $distributors->authorization_id = $request['authorization_id'];//授权条件为多选
//        $authorization_ids = substr($authorization_id,0,-1);
//        $authorization_id = explode(',',$authorization_ids);

        $distributors->store_address = $request['store_address'];
        $distributors->operation_situation = $request['operation_situation'];
        $distributors->front_id = $request->input('front_id', 0);
        $distributors->Inside_id = $request->input('Inside_id', 0);
        $distributors->portrait_id = $request->input('portrait_id', 0);
        $distributors->national_emblem_id = $request->input('national_emblem_id', 0);
        $distributors->license_id = $request->input('license_id', 0);
        $distributors->bank_number = $request['bank_number'];
        $distributors->bank_name = $request['bank_name'];
        $distributors->business_license_number = $request['business_license_number'];
        $distributors->taxpayer = $request['taxpayer'];
        $distributors->status = 1;
        $res = $distributors->save();
        if ($res) {
            $assets = AssetsModel::where('random',$request->input('random'))->get();
            foreach ($assets as $asset){
                $asset->target_id = $distributors->id;
                $asset->save();
            }
            return $this->response->array(ApiHelper::success('添加成功', 200, compact('token')));
        } else {
            return $this->response->array(ApiHelper::error('添加失败，请重试!', 412));
        }

    }



    /**
     * @api {post} /DealerApi/message/updateMessage 经销商信息修改
     * @apiVersion 1.0.0
     * @apiName Message updateMessage
     * @apiGroup Message
     *
     * @apiParam {string} token token
     * @apiParam {integer} id ID
     * @apiParam {integer} target_id 关联id
     * @apiParam {string} name 姓名
     * @apiParam {string} store_name 门店名称
     * @apiParam {string} phone 电话
     * @apiParam {integer} user_id 用户ID
     * @apiParam {integer} province_id 省份ID
     * @apiParam {integer} city_id 城市ID
     * @apiParam {integer} category_id 商品分类id
     * @apiParam {string} authorization_id 授权条件
     * @apiParam {string} store_address 门店地址
     * @apiParam {string} operation_situation 经营情况
     * @apiParam {integer} front_id 门店正面照片
     * @apiParam {integer} Inside_id 门店内部照片
     * @apiParam {integer} portrait_id 身份证人像面照片
     * @apiParam {integer} national_emblem_id 身份证国徽面照片
     * @apiParam {integer} license_id 营业执照照片
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
     *      "user_id": 2,                            // 用户ID
     *      "name": 小明,           // 姓名
     *      "phone": 187254262512,           // 电话
     *      "store_name": 铟立方,           // 门店名称
     *      "province_id": 1,                         // 省份ID
     *      "city_id": 1,                         // 城市ID
     *      "category_id": "116",           // 商品分类id
     *      "authorization_id": 11,2,                          // 授权条件
     *      "store_address": 北京市朝阳区,                      // 门店地址
     *      "operation_situation": 非常好,                         // 经营情况
     *      "front_id": "1",                  // 门店正面照片
     *      "Inside_id": "2",                  // 门店内部照片
     *      "portrait_id": "3",                  // 身份证人像面照片
     *      "national_emblem_id": "4",                  // 身份证国徽面照片
     *      "license_id": "5",                  // 营业执照照片
     *      "bank_number": "1234567890",              // 银行卡账号
     *      "bank_name": 中国银行,               // 开户行
     *      "business_license_number":  "638272611291",     //营业执照号
     *      "taxpayer": 1,                      // 纳税人类型:1.一般纳税人 2.小规模纳税人
     *      "status": 1,                    // 状态：1.待审核；2.已审核；3.关闭；4.重新审核
     *      }
     * ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *       }
     *   }
     */

    public function updateMessage(Request $request)
    {
        $all = $request->all();
        $all['id'] = $request->input('id');

        $rules = [
            'name' => 'max:30',
            'phone' => 'max:11',
            'store_name' => 'max:50',
            'store_address' => 'max:500',
            'operation_situation' => 'max:500',
            'bank_number' => 'max:19',
            'bank_name' => 'max:20',
            'authorization_id' => 'max:50',
            'business_license_number' => 'max:15',
            'province_id' => 'integer',
            'city_id' => 'integer',
            'category_id' => 'integer',
            'taxpayer' => 'integer',
            'front_id' => 'integer',
            'Inside_id' => 'integer',
            'portrait_id' => 'integer',
            'national_emblem_id' => 'integer',
            'license_id' => 'integer',
        ];
        $validator = Validator::make($all, $rules);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        $distributors = DistributorModel::where('user_id', $this->auth_user_id)->where('id',$all['id'])->first();
        if ($distributors){
            if($distributors->status == 2){//已完成不能再修改
                return $this->response->array(ApiHelper::error('error', 403));
            }
            if($distributors->status == 3) {
                $distributors->status = "4";//重新审核
            }

            $distributor = $distributors->update($all);
        }else{
            return $this->response->array(ApiHelper::error('修改失败，请重试!', 412));
        }

        return $this->response->array(ApiHelper::success());
    }


}