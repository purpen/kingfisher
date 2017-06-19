<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Log;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Tymon\JWTAuth\Facades\JWTFactory;
class AuthenticateController extends BaseController
{

    public function register (Request $request)
    {
        // 验证规则
        $rules = [
            'account' => ['required','regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
            'password' => ['required', 'min:6']
        ];

        $payload = app('request')->only('account', 'password');
        $validator = app('validator')->make($payload, $rules);

        // 验证格式
        if ($validator->fails()) {
            throw new ApiExceptions\ValidationException('新用户注册失败！', $validator->errors());
        }
        $account = UserModel::where('account', $request['account'])->first();
        if($account){
            return $this->response->array(ApiHelper::error('账号以存在', 412));

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
     * @api {post} /api/auth/login 获取token
     * @apiVersion 1.0.0
     * @apiName ApiToken login
     * @apiGroup ApiToken
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

}
