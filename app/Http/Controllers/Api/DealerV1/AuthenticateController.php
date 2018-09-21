<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Helper\Tools;
use App\Http\ApiHelper;
use App\Http\DealerTransformers\UserTransformer;
use App\Libraries\YunPianSdk\Yunpian;
//use App\Models\CaptchaModel;
use App\Models\AssetsModel;
use App\Models\CaptchaModel;
use App\Models\DistributorModel;
use App\Models\UserModel;
use Dingo\Api\Exception\StoreResourceFailedException;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Captcha;
use Symfony\Component\Finder\Exception\ShellCommandFailureException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends BaseController
{
    /**
     * 创建验证码
     *
     */
    public function createCapcha($str)
    {
        $str = trim($str);

         if ($phrase = Cache::get($str)){
            $builder = new CaptchaBuilder($phrase);
        }else{
         //生成验证码图片的Builder对象，配置相应属性
             $builder = new CaptchaBuilder();
             $phrase = $builder->getPhrase();
            //设置缓存10分钟过期
            Cache::put($str,$phrase,10);
        }
        //可以设置图片宽高及字体
        $builder->build($width = 120, $height = 40, $font = null);
        //启用失真
        $builder->setDistortion(true);
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    /**
     * 验证验证码是否正确
     * @Param {string} str   随机字符串
     * @Param {string} captcha 图片验证码
     *
     * @SuccessExample 成功响应:
     *{
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     * }
     */
    public function checkCaptcha($str,$captcha)
    {
        $str = trim($str);
        $captcha = trim($captcha);
        $res = Cache::get($str);

        if ($res === null){
            return $this->response->array(ApiHelper::error('暂无匹配参数!', 403));
        }
        if (strtolower($res) == strtolower($captcha)){
            Cache::forget($str);
            return $this->response->array(ApiHelper::success());
        }
        return $this->response->array(ApiHelper::error('验证码错误!', 412));

    }

    /**
     * @api {get} /DealerApi/auth/captchaUrl 获取验证码路径
     * @apiVersion 1.0.0
     * @apiName DealerUser captchaUrl
     * @apiGroup DealerUser
     *
     * @apiSuccessExample 成功响应:
     *{
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     * "data":{
     * 'url':  "http://www.work.com/DealerApi/auth/createCapcha?ed17dd"    //图片验证码路径
     * 'str':    'abuxbsn'  //随机字符串

     * }
     * }
     */
    public function captchaUrl(Request $request)
    {
        $str = substr(md5(microtime(true)), 0, 10);
        $url = route('auth.createCapcha',$str);//路由加随机字符串
        $data = [
            'url'=>$url,
            'str'=>$str
        ];
        return $this->response->array(ApiHelper::success('ok！', 200,$data));
    }


    /**
     * @api {post} /DealerApi/auth/verify 验证注册短信验证码
     * @apiVersion 1.0.0
     * @apiName DealerUser verify
     * @apiGroup DealerUser
     *
     * @apiParam {string} phone 用户账号/手机号
     * @apiParam {string} code 验证码
     *
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "success！",
     *       "status_code": 200
     *     },
     *   }
     */
    public function verify(Request $request)
    {
        // 验证规则
        $rules = [
            'phone' => ['required', 'regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
            'code' => 'required',
        ];
        $message = [
            'phone.required' => '手机号必填',
            'phone.phone' => '手机号格式不对',
            'code.required' => '短信验证码必填',
        ];

        $payload = app('request')->only( 'code','phone');
        $validator = app('validator')->make($payload, $rules,$message);
        //  验证格式
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式有误！',  $validator->errors());
        }
        // 验证验证码
        if (!$this->isExistCode($payload['phone'], $payload['code'], 1)) {
            return $this->response->array(ApiHelper::error('验证码错误', 412));
        }
        return $this->response->array(ApiHelper::success('验证成功！', 200));
    }

    /**
     * @api {post} /DealerApi/auth/register 用户注册
     * @apiVersion 1.0.0
     * @apiName DealerUser register
     * @apiGroup DealerUser
     *
     * @apiParam {string} random 随机数
     * @apiParam {string} account 用户账号
     * @apiParam {string} password 设置密码
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
     * @apiParam {string} store_address  企业详细地址
     * @apiParam {string} enter_Address 门店详细地址
     * @apiParam {string} business_license_number 统一社会信用代码
     * @apiParam {integer} mode 是否月结
     * @apiParam {integer} contract_id 电子版合同照片id
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
            'phone' => ['required', 'regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
//            'password' => ['required', 'regex:/^(?=.*?[0-9])(?=.*?[A-Z])(?=.*?[a-z])[0-9A-Za-z!-)]{6,16}$/'],
            'password' => 'required',
            'province_id' => 'integer',
            'city_id' => 'integer',
            'county_id' => 'integer',
        ];
        $message = [
            'phone.required' => '手机号必填',
            'phone.phone' => '手机号格式不对',
            'province_id.province_id' => '省份id格式不对',
            'city_id.city_id' => '城市id格式不对',
            'county_id.county_id' => '区县id格式不对',
            'password.required' => '密码必填',
        ];

        $payload = app('request')->only('password','phone','province_id','city_id','county_id');
        $validator = app('validator')->make($payload, $rules,$message);
        // 验证格式
        if ($validator->fails()) {
            throw new StoreResourceFailedException('新用户注册失败！',  $validator->errors());
        }

//        // 验证验证码
//        if (!$this->isExistCode($payload['phone'], $payload['code'], 1)) {
//            return $this->response->array(ApiHelper::error('验证码错误', 412));
//        }

//        $account = UserModel::where('account', $request['account'])->first();
//        if ($account) {
//            return $this->response->array(ApiHelper::error('账号已存在', 412));
//
//        }
        // 创建用户
        $user = new UserModel();
        $user->account = $request['phone'];
        $user->phone = $request['phone'];
        $user->realname = $request['name'];
        $user->password = bcrypt($request['password']);
        $user->type = 0;
        $user->supplier_distributor_type = 3;     // 经销商类型
        $res = $user->save();

        if ($res){
            $uid = $user->id;
            $distributors = new DistributorModel();
            $distributors->name = $request['name'];
            $user_id = DistributorModel::where('user_id',$this->auth_user_id)->select('user_id')->first();
            if ($user_id) {
                return $this->response->array(ApiHelper::error('该用户已注册！', 403));
            }
            $distributors->user_id = (int)$uid;
            $distributors->enter_province = $request->input('enter_province','');
            $distributors->enter_city = $request->input('enter_city','');
            $distributors->enter_county = $request->input('enter_county','');
            $distributors->store_name = $request->input('store_name','');
            $distributors->enter_phone = $request->input('enter_phone','');
            $distributors->ein = $request->input('ein','');
            $distributors->province_id = (int)$request['province_id'];//省oid
            $distributors->city_id = (int)$request['city_id'];//市oid
            $distributors->county_id = (int)$request['county_id'];//区oid
            $distributors->phone = $request['phone'];//电话
//            $distributors->category_id = $request->input('category_id','');//商品分类为多选
//            $distributors->authorization_id = $request->input('authorization_id','');//授权条件为多选
            $distributors->operation_situation = $request['operation_situation'];
            $distributors->front_id = $request->input('front_id', 0);
            $distributors->Inside_id = $request->input('Inside_id', 0);
            $distributors->portrait_id = $request->input('portrait_id', 0);
            $distributors->national_emblem_id = $request->input('national_emblem_id', 0);
            $distributors->bank_number = $request->input('bank_number','');
            $distributors->bank_name = $request->input('bank_name','');
            $distributors->business_license_number = $request->input('business_license_number','');
            $distributors->taxpayer = $request->input('taxpayer','');
            $distributors->position = $request->input('position','');
            $distributors->full_name = $request->input('full_name','');
            $distributors->legal_person = $request->input('legal_person','');
            $distributors->legal_phone = $request->input('legal_phone','');
            $distributors->legal_number = $request->input('legal_number','');
            $distributors->store_address = $request->input('store_address','');
            $distributors->enter_Address = $request->input('enter_Address','');
            $distributors->contract_id = $request->input('enter_Address','');
            $distributors->mode = $request->input('mode','');
            $distributors->status = 1;
            $result = $distributors->save();
            if ($result) {
                $assets = AssetsModel::where('random',$request->input('random'))->get();
                foreach ($assets as $asset){
                    $asset->target_id = $distributors->id;
                    $asset->save();
                }
        }
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
     * @api {post} /DealerApi/auth/login 登录
     * @apiVersion 1.0.0
     * @apiName DealerUser login
     * @apiGroup DealerUser
     *
     * @apiParam {string} account 手机号
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
                if(preg_match("/^1[34578]{1}\d{9}$/",$credentials['account'])){//手机号
                    $data = [
                        'phone' => $credentials['account'],
                        'password' => $credentials['password'],
                    ];
            }else{//用户名
                    $data = [
                        'account' => $credentials['account'],
                        'password' => $credentials['password'],
                    ];
                }

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
     * @api {post} /DealerApi/auth/getRegisterCode 获取注册验证码
     * @apiVersion 1.0.0
     * @apiName DealerUser Code
     * @apiGroup DealerUser
     *
     * @apiParam {string} phone 用户手机号
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
        $credentials = $request->only('phone');

        $rules = [
            'phone' => ['required', 'regex:/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$/'],
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
            $captcha->phone = $request['phone'];
            $captcha->code = $code;
            $captcha->type = 1;
            $result = $captcha->save();
        }
        if (!$result) {

            return $this->response->array(ApiHelper::error('验证码获取失败', 500));
        }

        $data = array();
        $data['mobile'] = $credentials['phone'];
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
     * @api {get} /DealerApi/auth/phone 检测手机号是否注册
     * @apiVersion 1.0.0
     * @apiName DealerUser phone
     * @apiGroup DealerUser
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
     * @api {post} /DealerApi/auth/logout 退出登录
     *
     * @apiVersion 1.0.0
     * @apiName DealerUser logout
     * @apiGroup DealerUser
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
     * @api {post} /DealerApi/auth/upToken 更新或换取新Token
     * @apiVersion 1.0.0
     * @apiName DealerUser token
     * @apiGroup DealerUser
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
//        $token = JWTAuth::refresh( JWTAuth::getToken());
        $token = JWTAuth::refresh();
        return $this->response->array(ApiHelper::success('更新Token成功！', 200, compact('token')));
    }


    /**
     * @api {post} /DealerApi/auth/changePassword 修改密码
     * @apiVersion 1.0.0
     * @apiName DealerUser changePassword
     * @apiGroup DealerUser
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
     * @api {post} /DealerApi/auth/getRetrieveCode 忘记密码(验证身份)-获取手机验证码
     * @apiVersion 1.0.0
     * @apiName DealerUser getRetrieveCode
     * @apiGroup DealerUser
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
     * @api {post} /DealerApi/auth/retrievePassword 忘记密码-更改新密码
     * @apiVersion 1.0.0
     * @apiName DealerUser retrievePassword
     * @apiGroup DealerUser
     *
     * @apiParam {string} phone 手机号
     * @apiParam {string} code 短信验证码
     * @apiParam {string} password 密码
     * @apiParam {string} captcha 图片验证码
     * @apiParam {string} str   随机字符串
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
            'captcha' => 'required',
            'code' => 'required|size:6',
            'password' => 'required|between:6,16',
        ];

        $massage = [
            'phone.required' => '手机号码是必填的',
            'captcha.required' => '图片验证码是必填的',
            'password.required' => '密码是必填的',
            'password.between' => '密码必填是6到16位',
            'code.required' => '手机验证码是必填的',
            'code.size' => '手机验证码必须是6位',
        ];

        $validator = Validator::make($all, $rules, $massage);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
        }
        $captcha_img = $this->checkCaptcha($all['str'],$all['captcha']);//调用验证图片验证码
        if (!$captcha_img){
            return $this->response->array(ApiHelper::error('图片验证码错误', 403));
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


       /**
        * @api {get} /DealerApi/auth/user 获取用户信息
        * @apiVersion 1.0.0
        * @apiName DealerUser user
        * @apiGroup DealerUser
        *
        * @apiParam {string} token
        *
        * @apiSuccessExample 成功响应:
        * {
        * "data": {
        * "id": 1,
        * "realname": "张三疯",               // 真实姓名
        * "phone": "15810295774",                 // 手机号
        * "status": 1                             // 状态 0.未激活 1.激活
        * "type": 4                             // 类型 0.ERP ；1.分销商；2.c端用户; 4.经销商；
        * "verify_status": 1                       // 资料审核 1.待审核，2.拒绝，3.通过
        * "distributor_status": 0                       //审核状态：1.待审核；2.已审核；3.关闭；4.重新审核
        * "distributor_mode": "月结",               // 是否可以月结 1.月结 2.非月结
        * },
        *
        * "meta": {
        * "message": "Success.",
        * "status_code": 200
        * }
        * }Request $request
        */

       public function AuthUser()
       {
           $user_id = $this->auth_user_id;
           $users = UserModel::where('id', $user_id)->first();
//           获取经销商审核状态
           $distributor_status = DistributorModel::where('user_id',$users->id)->select('status','mode')->first();
           if ($distributor_status){
               $users['distributor_status'] = $distributor_status['status'];
               $users['distributor_mode'] = $distributor_status['mode'];
           }else{
               $users['distributor_status'] = 0;
               $users['distributor_mode'] = 0;
           }
           $assets = AssetsModel
               ::find($users->cover_id);
           if (count($assets)>0){
               $users->file = $assets->file->p500;
           }else{
               $users->file = url('images/default/erp_product.png');
           }
           return $this->response->item($users, new UserTransformer())->setMeta(ApiHelper::meta());

       }

        /**
         * @api {post} /DealerApi/auth/updateUser 更新用户信息
         * @apiVersion 1.0.0
         * @apiName DealerApi updateUser
         * @apiGroup DealerApi
         *
         * @apiParam {string} token
         * @apiParam {string} random random
         * @apiParam {integer} id id
         * @apiParam {string} phone 门店联系人手机号
         * @apiParam {string} name 门店联系人姓名
         * @apiParam {integer} cover_id 头像id
         * @apiParam {string} email email
         * @apiParam {integer} sex 性别
         *
         *
         * @apiSuccessExample 成功响应:
         * {
         * "meta": {
         * "message": "Success.",
         * "status_code": 200
         * }
         * }
         */

        public function updateUser(Request $request)
        {
            $all = $request->all();
            $all['id'] = $request->input('id');
            $rules = [
//                'phone' => 'required',
//                'name' => 'required',
                'cover_id' => 'required',
                ];

            $validator = Validator::make($all, $rules);
            if ($validator->fails()) {
                throw new StoreResourceFailedException('请求参数格式不正确！', $validator->errors());
            }
            $users = UserModel::where('id', $this->auth_user_id)->first();
            if ($users){
                $user = $users->update(['cover_id'=>$request['cover_id'],'verify_status'=>1,'supplier_distributor_type'=>3]);
//                if ($user){
//                    $distributors = new DistributorModel();
//                    $distributor =DB::table('distributor')
//                        ->where('user_id','=',$this->auth_user_id)
//                        ->update(['name'=>$request['name'],'phone'=>$request['phone']]);
//                }
            }else{
                return $this->response->array(ApiHelper::error('修改失败，请重试!', 412));
            }
            return $this->response->array(ApiHelper::success());
        }
}