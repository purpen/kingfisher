<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Models\UserModel;
use App\Models\CaptchaModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    /*
     * 设置登录成功后，重定向路径
     */
    protected $redirectPath = '/';
    
    /*
     * 设置登录失败后，重定向路径
     */
    protected $loginPath = '/login';
    
    /*
     * 初始化用户model
     */
    protected $user_model;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserModel $user)
    {
        $this->user_model = new $user;
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    
    /**
     * 显示登录表单页面
     *
     * @return view
     */
    public function getLogin()
    {
        $result = array(
            'towhere' => 'login'
        );
        return view('auth.login',['data' => $result]);
    }
    
    /**
     * 显示注册表单页面
     *
     * @return view
     */
    public function getRegister()
    {
        $result = array(
            'towhere' => 'register',
        );
        return view('auth.register',['data' => $result]);
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

    /**
     * 创建注册用户信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @return User
     */
    public function postRegister(RegisterRequest $request)
    {
        $request = $request->all();
        
        // 判断手机验证码是否正确
        $captcha = new CaptchaModel;
        $captcha = $captcha::where('phone', $request['phone'])->where('code', $request['phone_verify'])->first();
        
        if(!$captcha)
        {
            return redirect('/register')->with('phone-error-message', '手机号码验证失败，请重新验证。')->withInput();
        }
        
        $user = $this->user_model;
        $user->account = $request['phone'];
        $user->email = $request['phone'].'@qq.com';
        $user->phone = $request['phone'];
        $user->password = bcrypt($request['password']);
        $user->status = 0;
        $result = $user->save();
        
        if($result)
        {
            $captcha->delete(); // 删除手机验证码记录
            return redirect('/login')->with('message', '欢迎注册，好好玩耍!');
        }else{
            return redirect('/register')->with('message', '注册失败，请重新注册。')->withInput();
        }
    }
}
