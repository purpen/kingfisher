<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Models\UserModel;
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
        dd($request->all());
    }
    
    /**
     * 创建注册用户信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @return User
     */
    public function testRegister(RegisterRequest $request)
    {
        dd($request->all());
    }
}
