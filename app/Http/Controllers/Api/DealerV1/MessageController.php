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
     *      "name": 小明,           // 门店联系人姓名
     *      "ein": 12345,           // 税号
     *      "phone": 13265363728,           // 电话
     *      "enter_phone": 13435363728,           // 企业电话
     *      "legal_phone": 13435233728,           // 法人电话
     *      "store_name": 铟立方,           // 门店名称
     *      "province_id": 1,                         // 省份
     *      "city_id": 1,                         // 城市
     *      "county_id": 1,                         // 县
     *      "enter_province": 1,                         // 企业省份
     *      "enter_city": 1,                         // 企业城市
     *      "enter_county": 1,                         // 企业县
     *      "category_id": "11，12",           // 商品分类id
     *      "authorization_id": 11,2,                          // 授权条件
     *      "operation_situation": 非常好,                         // 经营情况
     *      "front_id": "1",                  // 门店正面照片
     *      "Inside_id": "2",                  // 门店内部照片
     *      "portrait_id": "3",                  // 身份证人像面照片
     *      "national_emblem_id": "4",                  // 身份证国徽面照片
     *      "bank_number": "1234567890",              // 银行卡账号
     *      "bank_name": 中国银行,               // 开户行
     *      "legal_number":               // 法人身份证号
     *      "legal_person":               // 法人姓名
     *      "full_name":               // 企业全称
     *      "position":               // 职位
     *      "store_address":               // 门店详细地址
     *      "enter_Address":               // 企业详细地址
     *      "business_license_number":  "638272611291",     //统一社会信用代码
     *      "taxpayer": 1,                      // 纳税人类型:1.一般纳税人 2.小规模纳税人
     *     "status": 1,                    // 状态：1.待审核；2.已审核；3.关闭；4.重新审核
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
            $province_id = '';
            $city_id = '';
            $county_id = '';
            $enter_province = '';
            $enter_city = '';
            $enter_county = '';
            foreach ($distributors as $v){
                $province_id = $v['province_id'];
                $city_id = $v['city_id'];
                $county_id = $v['county_id'];
                $enter_province = $v['enter_province'];
                $enter_city = $v['enter_city'];
                $enter_county = $v['enter_county'];

                $province = ChinaCityModel::where('oid',$province_id)->select('name')->first();
                $city = ChinaCityModel::where('oid',$city_id)->select('name')->first();
                $county = ChinaCityModel::where('oid',$county_id)->select('name')->first();
                $enter_p = ChinaCityModel::where('oid',$enter_province)->select('name')->first();
                $enter_c = ChinaCityModel::where('oid',$enter_city)->select('name')->first();
                $enter_co = ChinaCityModel::where('oid',$enter_county)->select('name')->first();

                $authorizations = explode(',', $v['authorization_id']);
                $categorys = explode(',', $v['category_id']);
                }

                $authorization = CategoriesModel::whereIn('id', $authorizations)->where('type',2)->select('id','title')->get();
                $category = CategoriesModel::whereIn('id', $categorys)->where('type',1)->select('id','title')->get();
//                $authorizations = array_column($authorization->toArray(),'id');
//                $categorys = array_column($category->toArray(),'id');
            if ($authorization) {
                $str = '';
                foreach ($authorization as $value) {
                    $str .= $value['title'] . ',';
                }
            }

            if ($category) {
                $tit = '';
                foreach ($category as $value) {
                    $tit .= $value['title'] . ',';
                }
            }

                $distributors[0]['authorization'] = $str;
                $distributors[0]['category'] = $tit;
//                $distributors[0]['authorizations'] = $authorizations;
//                $distributors[0]['categorys'] = $categorys;
            if (count($province) > 0 && count($city) > 0 && count($county) > 0) {
                $distributors[0]['province'] = $province->toArray()['name'];
                $distributors[0]['city'] = $city->toArray()['name'];
                $distributors[0]['county'] = $county->toArray()['name'];
            }else{
                $distributors[0]['province'] = '';
                $distributors[0]['city'] = '';
                $distributors[0]['county'] = '';
            }
            if (count($enter_p) > 0 && count($enter_c) > 0 && count($enter_co) > 0) {
                $distributors[0]['e_province'] = $enter_p->toArray()['name'];
                $distributors[0]['e_city'] = $enter_c->toArray()['name'];
                $distributors[0]['e_county'] = $enter_co->toArray()['name'];
            }else{
                $distributors[0]['e_province'] = '';
                $distributors[0]['e_city'] = '';
                $distributors[0]['e_county'] = '';
            }
        }
        return $this->response->collection($distributors, new DistributorTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /DealerApi/message/city 省份列表
     * @apiVersion 1.0.0
     * @apiName Message cities
     * @apiGroup Message
     *
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
     * @api {get} /DealerApi/message/county 根据城市查看下级县(区)的列表
     * @apiVersion 1.0.0
     * @apiName Message county
     * @apiGroup Message
     *
     * @apiParam {integer} oid 唯一（父id）
     * @apiParam {integer} layer 级别（子id）3
     */
    public function county(Request $request)
    {
        $oid = (int)$request->input('value');
        $layer = (int)$request->input('layer');
        $chinaModel = new ChinaCityModel();
        $fetch_city = $chinaModel->fetchCity($oid,$layer);

        if ($layer == 2){
            $fetch_city = ChinaCityModel::where('layer',2)->where('oid',$oid)->first();
        }
        return $this->response()->collection($fetch_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }
    /**
     * @api {get} /DealerApi/message/town 根据区县查看下级乡镇的列表
     * @apiVersion 1.0.0
     * @apiName Message town
     * @apiGroup Message
     *
     * @apiParam {integer} oid 唯一（父id）
     * @apiParam {integer} layer 级别（子id）4
     */
    public function town(Request $request)
    {
        $oid = (int)$request->input('value');
        $layer = (int)$request->input('layer');
        $chinaModel = new ChinaCityModel();
        $fetch_city = $chinaModel->fetchCity($oid,$layer);

        if ($layer == 3){
            $fetch_city = ChinaCityModel::where('layer',3)->where('oid',$oid)->first();
        }
        return $this->response()->collection($fetch_city, new CityTransformer())->setMeta(ApiHelper::meta());

    }


    /**
     * @api {get} /DealerApi/message/category 所有商品分类列表
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
     * @api {post} /DealerApi/message/addMessage 经销商信息添加(暂不使用)
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
     * @apiParam {string} name 门店联系人姓名
     * @apiParam {string} store_name 门店名称
     * @apiParam {string} phone  门店联系人手机号
     * @apiParam {integer} user_id 用户ID
     * @apiParam {integer} province_id 门店所在省份oID
     * @apiParam {integer} city_id 门店城市oID
     * @apiParam {integer} county_id 下级区县oID
     * @apiParam {integer} enter_province 企业所在省份oID
     * @apiParam {integer} enter_city 企业城市oID
     * @apiParam {integer} enter_county 企业区县oID
     * @apiParam {string} operation_situation 主要情况
     * @apiParam {integer} front_id 门店正面照片
     * @apiParam {integer} Inside_id 门店内部照片
     * @apiParam {integer} portrait_id 身份证人像面照片
     * @apiParam {integer} national_emblem_id 身份证国徽面照片
     * @apiParam {string} position 职位
     * @apiParam {string} full_name 企业全称
     * @apiParam {string} legal_person 法人姓名
     * @apiParam {string} legal_phone 法人手机号
     * @apiParam {string} enter_phone 企业电话
     * @apiParam {string} legal_number 法人身份证号
     * @apiParam {string} ein 税号
     * @apiParam {string} taxpayer 纳税人类型
     * @apiParam {string} bank_name 开户行
     * @apiParam {string} store_address 门店详细地址
     * @apiParam {string} enter_Address 企业详细地址
     * @apiParam {string} business_license_number 统一社会信用代码
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
    *      "id": 2,                            // ID
    *      "ein": 23452,                       // 税号
    *      "user_id": 2,                       // 用户ID
    *      "name": 小明,                        // 姓名
    *      "phone": 187254262512,              // 电话
    *      "store_name": 铟立方,                // 门店名称
    *      "province_id": 1,                   // 省份ID
    *      "city_id": 1,                       // 城市ID
    *      "county_id": 1,                      //区县ID
    *      "enter_province": 1,                // 企业省份oID
    *      "enter_city": 1,                    // 企业城市oID
    *      "enter_county": 1,                   //企业区县oID
    *      "operation_situation": 非常好,      //  经营情况
    *      "front_id": "1",                  //   门店正面照片
    *      "Inside_id": "2",                  //  门店内部照片
    *      "portrait_id": "3",                  //身份证人像面照片
    *      "national_emblem_id": "4",          // 身份证国徽面照片
    *      "bank_number": "1234567890",        // 银行卡账号
    *      "bank_name": 中国银行,               // 开户行
    *      "business_license_number":  "",      //统一社会信用代码
     *      "position"                          //职位
     *      "enter_phone"                       //企业电话
     *      "full_name"                         //企业全称
     *      "legal_person"                      //法人姓名
     *      "legal_phone"                       //法人手机号
     *      "legal_number"                      //法人身份证号
     *      "store_address"                      //门店详细地址
     *      "enter_Address"                      //企业详细地址
     *      "taxpayer": 1,                      //纳税人类型:1.一般纳税人 2.小规模纳税人
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
            'operation_situation' => 'max:500',
            'bank_number' => 'max:50',
            'bank_name' => 'max:20',
            'authorization_id' => 'max:50',
            'business_license_number' => 'max:20',
            'province_id' => 'integer',
            'city_id' => 'integer',
            'county_id' => 'integer',
            'taxpayer' => 'integer',
            'front_id' => 'integer',
            'Inside_id' => 'integer',
            'portrait_id' => 'integer',
            'enter_province' => 'integer',
            'enter_city' => 'integer',
            'enter_county' => 'integer',
            'national_emblem_id' => 'integer',
        ];
        $validator = Validator::make($all, $rules);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        $distributors = DistributorModel::where('user_id', $this->auth_user_id)->where('id',$all['id'])->first();
        if (count($distributors)>0){
            if($distributors->status == 2){//已完成再修改变成重新审核
                $distributors->status = "4";
            }
            if($distributors->status == 3) {
                $distributors->status = "4";//重新审核
            }
            $distributors->store_address = $request->input('store_address');
            $distributors->enter_Address = $request->input('enter_Address');
            $distributor = $distributors->update($all);
//            if ($distributor){
//                $users = new UserModel();
////                $users->realname = $request['name'];
////                $users->phone = $request['phone'];
////                $user = $users->update();
//                $user =DB::table('users')
//                    ->where('id','=',$this->auth_user_id)
//                    ->update(['realname'=>$request['name'],'phone'=>$request['phone']]);
//            }
        }else{
            return $this->response->array(ApiHelper::error('修改失败，请重试!', 412));
        }

        return $this->response->array(ApiHelper::success());
    }


}