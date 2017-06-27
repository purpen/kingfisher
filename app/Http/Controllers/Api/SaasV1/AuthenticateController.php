<?php

namespace App\Http\Controllers\Api\SaasV1;

use App\Libraries\YunPianSdk\Yunpian;
use App\Models\CaptchaModel;
use App\Models\UserModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
class AuthenticateController extends BaseController
{
    /**
     * @api {post} /api/auth/register 用户注册
     * @apiVersion 1.0.0
     * @apiName SaasUser register
     * @apiGroup SaasUser
     *
     * @apiParam {string} account 用户账号
     * @apiParam {string} password 设置密码
     * @apiParam {integer} code 短信验证码
     *
     * @apiSuccessExample 成功响应:
     *  {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *     "data": {
     *          "token": ""
     *      }
     *   }
     */
    public function register (Request $request)
    {
        // 验证规则
        $rules = [
            'account' => ['required','regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
            'password' => ['required', 'min:6'],
            'code' => 'required',
        ];
        
        $payload = app('request')->only('account', 'password','code');
        $validator = app('validator')->make($payload, $rules);

        // 验证格式
        if ($validator->fails()) {
            throw new ApiExceptions\ValidationException('新用户注册失败！', $validator->errors());
        }

        // 验证验证码
        if(!$this->isExistCode($rules['account'], $rules['code'], 1)){
            return $this->response->array(ApiHelper::error('验证码错误', 412));
        }

        $account = UserModel::where('account', $request['account'])->first();
        if($account){
            return $this->response->array(ApiHelper::error('账号已存在', 412));

        }
        // 创建用户
        $user = new UserModel();
        $user->account = $request['account'];
        $user->phone = $request['account'];
        $user->password = bcrypt($request['password']);
        $res = $user->save();

        if ($res) {
            return $this->response->array(ApiHelper::success());
        } else {
            return $this->response->array(ApiHelper::error('注册失败，请重试!', 412));
        }
    }

    /**
     * Aliases authenticate
     */
    public function login (Request $request) {
        return $this->authenticate($request);
    }
    
    /**
     * @api {post} /api/auth/login 登录
     * @apiVersion 1.0.0
     * @apiName SaasUser login
     * @apiGroup SaasUser
     *
     * @apiParam {string} account 用户账号
     * @apiParam {string} password 设置密码
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "登录成功！",
     *       "status_code": 200
     *     },
     *     "data": {
     *       "token": "eyJ0eXAiOiiOiJIUzI1NiJ9.sIm5iZiI6MTzkifQ.piS_YZhOqsjAF4XbxELIs2y70cq8",
     *     }
     *   }
     */
    public function authenticate (Request $request)
    {
        $credentials = $request->only('account', 'password');

        try {
            // 验证规则
            $rules = [
                'account' => ['required'],
                'password' => ['required', 'min:6']
            ];

            $payload = app('request')->only('account', 'password');
            $validator = app('validator')->make($payload, $rules);

            // 验证格式
            if ($validator->fails()) {
                throw new StoreResourceFailedException('请求参数格式不对！', $validator->errors());
            }
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->array(ApiHelper::error('账户名或密码错误', 401));
            }
        } catch (JWTException $e) {
            return $this->response->array(ApiHelper::error('could_not_create_token', 500));
        }
        // return the token
        return $this->response->array(ApiHelper::success('登录成功！', 200, compact('token')));
    }

    /**
     * @api {post} /api/auth/getRegisterCode 获取注册验证码
     * @apiVersion 1.0.0
     * @apiName SaasUser Code
     * @apiGroup SaasUser
     *
     * @apiParam {string} account 用户账号
     *
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200
     *     }
     *   }
     */
    public function getRegisterCode(Request $request)
    {
        $credentials = $request->only('account');

        $rules = [
            'account' => ['required','regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        if($this->phoneCaptcha($rules['account'])){
            return $this->response->array(ApiHelper::error('该手机号已注册', 402));
        }

        $code = (string)mt_rand(100000,999999);

        $captcha = CaptchaModel::firstOrCreate(['phone' => $credentials, 'type' => 1]);
        $captcha->code = $code;
        $result = $captcha->save();

        if(!$result){
            return $this->response->array(ApiHelper::error('验证码获取失败', 500));
        }

        $data = array();
        $data['mobile'] = $credentials;
        $data['text'] = '【太火鸟】验证码：'.$code.'，切勿泄露给他人，如非本人操作，建议及时修改账户密码。';

        $yunpian = new Yunpian();
        $yunpian->sendOneSms($data);

        return $this->response->array(ApiHelper::success('请求成功！', 200, compact('code')));
    }


    /**
     * 手机号是否已注册
     *
     * @param $phone
     * @return bool
     */
    public function phoneCaptcha($phone)
    {
        $result = UserModel::where('phone', $phone)->first();
        if(!$result){
            return false;
        }
        return true;
    }

    // 验证注册验证码是否正确,并删除验证码数据
    public function isExistCode($phone, $code, $type)
    {

        $result = CaptchaModel::where(['phone' => $phone, 'code' => $code, 'type' => $type])->first();
        if(!$result){
            return false;
        }
        $result->delete();
        return true;
    }

}
