<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Libraries\YunPianSdk\Yunpian;
use App\Models\CaptchaModel;
use App\Models\MicroUserModel;
use App\Models\UserModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Hash;
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
     * @api {post} /MicroApi/auth/register 用户注册
     * @apiVersion 1.0.0
     * @apiName MicroUser register
     * @apiGroup MicroUser
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
    public function register(Request $request)
    {
        // 验证规则
        $rules = [
            'account' => ['required', 'regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
//            'password' => ['required', 'min:6'],
            'password' => ['required', 'regex:/^(?=.*?[0-9])(?=.*?[A-Z])(?=.*?[a-z])[0-9A-Za-z!-)]{6,16}$/'],
            'code' => 'required',
        ];

        $payload = app('request')->only('account', 'password', 'code');
        $validator = app('validator')->make($payload, $rules);

        // 验证格式
        if ($validator->fails()) {
//            throw new \Exception('新用户注册失败！');
            throw new StoreResourceFailedException('新用户注册失败！',  $validator->errors());

        }

        // 验证验证码
        if (!$this->isExistCode($payload['account'], $payload['code'], 1)) {
            return $this->response->array(ApiHelper::error('验证码错误', 412));
        }

        $account = UserModel::where('account', $request['account'])->first();
        if ($account) {
            return $this->response->array(ApiHelper::error('账号已存在', 412));

        }
        // 创建用户
        $user = new UserModel();
        $user->account = $request['account'];
        $user->phone = $request['account'];
        $user->password = bcrypt($request['password']);
        $user->type = 2;
        $res = $user->save();

        if ($res) {
            $token = JWTAuth::fromUser($user);
            return $this->response->array(ApiHelper::success('注册成功', 200, compact('token')));
        } else {
            return $this->response->array(ApiHelper::error('注册失败，请重试!', 412));
        }
    }

    /**
     * Aliases authenticate
     */
    public function login(Request $request)
    {
        return $this->authenticate($request);
    }

    /**
     * @api {post} /MicroApi/auth/login 登录
     * @apiVersion 1.0.0
     * @apiName MicroUser login
     * @apiGroup MicroUser
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
    public function authenticate(Request $request)
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
            $data = [
                'phone' => $credentials['account'],
                'password' => $credentials['password'],
            ];
            if (!$token = JWTAuth::attempt($data)) {
                return $this->response->array(ApiHelper::error('账户名或密码错误', 412));
            }
        } catch (JWTException $e) {
            return $this->response->array(ApiHelper::error('could_not_create_token', 500));
        }
        // return the token
        return $this->response->array(ApiHelper::success('登录成功！', 200, compact('token')));
    }

    /**
     * @api {post} /MicroApi/auth/getRegisterCode 获取注册验证码
     * @apiVersion 1.0.0
     * @apiName MicroUser Code
     * @apiGroup MicroUser
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
            'account' => ['required', 'regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        if ($this->phoneCaptcha($credentials)) {
            return $this->response->array(ApiHelper::error('该手机号已注册', 402));
        }

        $code = (string)mt_rand(100000, 999999);

        $captcha = new CaptchaModel();
        if ($captcha_find = $captcha::where('phone', $credentials)->first()) {
            $captcha_find->code = $code;
            $captcha_find->type = 1;
            $result = $captcha_find->save();
        } else {
            $captcha->phone = $request['account'];
            $captcha->code = $code;
            $captcha->type = 1;
            $result = $captcha->save();
        }
        if (!$result) {

            return $this->response->array(ApiHelper::error('验证码获取失败', 500));
        }

        $data = array();
        $data['mobile'] = $credentials['account'];
        $data['text'] = '【太火鸟】验证码：' . $code . '，切勿泄露给他人，如非本人操作，建议及时修改账户密码。';

        $yunpian = new Yunpian();
        $yunpian->sendOneSms($data);

        return $this->response->array(ApiHelper::success('请求成功！', 200));
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
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * @api {get} /MicroApi/auth/phone 检测手机号是否注册
     * @apiVersion 1.0.0
     * @apiName MicroUser phone
     * @apiGroup MicroUser
     *
     * @apiParam {string} phone 手机号
     *
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "可以注册.",
     *       "status_code": 200
     *     }
     *   }
     */
    public function phone(Request $request)
    {
        $phone = $request->input('phone');
        $result = $this->isExistPhone($phone);
        if ($result) {
            return $this->response->array(ApiHelper::error('该手机号已注册', 402));
        } else {
            return $this->response->array(ApiHelper::success('可以注册', 200));
        }

    }

    /**
     * 手机是否已注册
     *
     * @param $phone
     * @return bool
     */
    public function isExistPhone($phone)
    {
        $result = UserModel::where('phone', $phone)->first();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // 验证注册验证码是否正确,并删除验证码数据
    public function isExistCode($phone, $code, $type)
    {

        $result = CaptchaModel::where(['phone' => $phone, 'code' => $code, 'type' => $type])->first();
        if (!$result) {
            return false;
        }
        $result->delete();
        return true;
    }

    /**
     * @api {post} /MicroApi/auth/logout 退出登录
     *
     * @apiVersion 1.0.0
     * @apiName MicroUser logout
     * @apiGroup MicroUser
     *
     * @apiParam {string} token
     *
     * @apiSuccessExample 成功响应:
     *  {
     *     "meta": {
     *       "message": "A token is required",
     *       "status_code": 500
     *     }
     *  }
     */
    public function logout()
    {
        // 强制Token失效
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->response->array(ApiHelper::success('退出成功', 200));
    }

    /**
     * @api {post} /MicroApi/auth/upToken 更新或换取新Token
     * @apiVersion 1.0.0
     * @apiName MicroUser token
     * @apiGroup MicroUser
     *
     * @apiParam {string} token
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "更新Token成功！",
     *       "status_code": 200
     *     },
     *     "data": {
     *       "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"
     *    }
     *   }
     */
    public function upToken()
    {
        $token = JWTAuth::refresh();
        return $this->response->array(ApiHelper::success('更新Token成功！', 200, compact('token')));
    }

    /**
     * @api {post} /MicroApi/auth/changePassword 修改密码
     * @apiVersion 1.0.0
     * @apiName MicroUser changePassword
     * @apiGroup MicroUser
     *
     * @apiParam {string} old_password 原密码
     * @apiParam {string} password     新密码
     * @apiParam {string} token
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     },
     *     "data": {
     *       "token": "sdfs1sfcd"
     *    }
     *   }
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required',
        ]);

        $old_password = $request->input('old_password');
        $newPassword = $request->input('password');

        $user = JWTAuth::parseToken()->authenticate();

        if (!Hash::check($old_password, $user->password)) {
            return $this->response->array(ApiHelper::error('原密码不正确', 403));
        }

        $user->password = bcrypt($newPassword);
        if ($user->save()) {
            $token = JWTAuth::refresh();
            return $this->response->array(ApiHelper::success('Success', 200, compact('token')));
        } else {
            return $this->response->array(ApiHelper::error('Error', 500));
        }
    }

    /**
     * @api {post} /MicroApi/auth/getRetrieveCode 忘记密码-获取手机验证码
     * @apiVersion 1.0.0
     * @apiName MicroUser getRetrieveCode
     * @apiGroup MicroUser
     *
     * @apiParam {string} phone 手机号
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function getRetrieveCode(Request $request)
    {
        $phone = $request->input('phone');
        if ($this->isExistPhone($phone)) {        // 手机号存在
            $this->createCode($phone, 3);
            return $this->response->array(ApiHelper::success('Success', 200));
        } else {                                  // 手机号不存在
            return $this->response->array(ApiHelper::error("该手机号尚未注册", 403));
        }
    }

    // 创建返回 手机验证码
    protected function createCode($phone, $type)
    {
        $code = (string)mt_rand(100000, 999999);
        $captcha = CaptchaModel::firstOrCreate(['phone' => $phone]);
        $captcha->code = $code;
        $captcha->type = $type;
        $captcha->save();

        $data['mobile'] = $phone;
        $data['text'] = '【太火鸟】验证码：' . $code . '，切勿泄露给他人，如非本人操作，建议及时修改账户密码。';

        $yunpian = new Yunpian();
        $yunpian->sendOneSms($data);

        return $code;
    }

    /**
     * @api {post} /MicroApi/auth/retrievePassword 忘记密码-更改新密码
     * @apiVersion 1.0.0
     * @apiName MicroUser retrievePassword
     * @apiGroup MicroUser
     *
     * @apiParam {string} phone 手机号
     * @apiParam {string} code 验证码
     * @apiParam {string} password 密码
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function retrievePassword(Request $request)
    {
        $all = $request->all();

        $rules = [
            'phone' => 'required',
            'code' => 'required|size:6',
            'password' => 'required|between:6,16',
        ];

        $massage = [
            'phone.required' => '手机号码是必填的',
            'password.required' => '密码是必填的',
            'password.between' => '密码必填是6到16位',
            'code.required' => '手机验证码是必填的',
            'code.size' => '手机验证码必须是6位',
        ];

        $validator = Validator::make($all, $rules, $massage);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }

        // 验证验证码
        $captcha = CaptchaModel::where(['phone' => $all['phone'], 'code' => $all['code'], 'type' => 3])->first();
        if (!$captcha) {
            return $this->response->array(ApiHelper::error('验证码错误', 403));
        }

        $auth = UserModel::query()->where('phone', $all['phone'])->first();
        $auth->password = bcrypt($all['password']);
        if ($auth->save()) {
            $captcha->delete();
            return $this->response->array(ApiHelper::success('Success', 200));
        } else {
            return $this->response->array(ApiHelper::error('error', 500));
        }
    }

}
