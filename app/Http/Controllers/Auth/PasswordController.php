<?php

namespace App\Http\Controllers\Auth;
use DB;
use Auth;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\CaptchaModel;
use App\Http\Requests\ForgetRequest;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    /*
     * 初始化用户model
     */
    protected $user_model;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /*
    *找回密码
    **/
    public function getForget(Request $request)
    {

        $phone_verify_key = mt_rand(100000,999999);
        // 将手机验证key存入一次性session
        session(['phone_verify_key' => $phone_verify_key]);
        $result = array(
             'towhere' => 'forget',
             'phone_verify_key' => $phone_verify_key,
        );
        return view('auth.forget',['data' => $result]);
    }
    /**
     * 获取验证码
     *
     * @return html
     */
    public function getCaptcha()
    {
        return captcha_src();
    }

    /**
     * 校验验证码
     *
     * @return string json
     */
    public function postCaptcha(Request $request)
    {
        if ($request->getMethod() == 'POST')
        {
            $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                return ajax_json(0, '输入的验证码错误！');
            }
            return ajax_json(1, '输入的验证码正确！');
        }
    }

    public function postForget(ForgetRequest $request)
    {
        // 判断手机验证码是否正确
        $captcha = CaptchaModel::where('phone', $request['phone'])->where('code', $request['phone_verify'])->first();
        if(!$captcha){
            return redirect('/forget')->with('error-message', '手机号码，验证码不正确，请重新验证。')->withInput();
        }
        // 去掉不需要的字段
        $password = $request->only('password');

        $user = new UserModel();
        // 加密密码
        $user->password = bcrypt($password['password']);
        $password['password'] = $user->password;
        // 更新
        if(UserModel::where('phone',$request['phone'])->update($password)){
            $captcha->delete(); // 删除手机验证码记录
            return redirect('/login')->with('error_message','重置成功');
        }else{
            return ajax_json(0, '重置失败，请输入正确的手机号');
        }
    }


}
