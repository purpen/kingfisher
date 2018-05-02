<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Models\UserModel;
use App\Models\CaptchaModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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

    // 退出后跳转地址
    protected $redirectAfterLogout = '/login';

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
        $this->middleware('guest', ['except' => 'logout']);
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
        $phone_verify_key = mt_rand(100000,999999);
        // 将手机验证key存入一次性session
        session(['phone_verify_key' => $phone_verify_key]);
        $result = array(
            'towhere' => 'register',
            'phone_verify_key' => $phone_verify_key
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
     * 退出登录操作
     *
     * @return view
     */
    public function logout()
    {
        Auth::logout();
		return redirect()->intended($this->loginPath());
    }
    
     /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('phone', 'password');
    }

    
    /**
     * 验证登录用户信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @return User
     */
    public function postLogin(LoginRequest $request)
    {

        $credentials = $this->getCredentials($request);

        if (!Auth::attempt($credentials, $request->has('remember'))) {

            return redirect('/login')->with('error_message','帐号或密码不正确,请重新登录！')->withInput($request->only('phone'));

        }
        $user_id = Auth::user()->id;

        if (Auth::user()->status == 0){

            Auth::logout();
            return redirect('/login')->with('error_message','还没有被审核！')->withInput();
        }
        $user = UserModel::where('id' , $user_id)->first();
        if($user->status == 0){
            Auth::logout();
            return redirect('/login')->with('error_message','还没有被审核！')->withInput();
        }
        if($user->type !== 1){
            Auth::logout();
            return redirect('/login')->with('error_message','不是erp后台管理员！')->withInput();
        }
        $user_role = DB::table('role_user')->where('user_id' , $user_id)->first();
        if(!$user_role){
            return redirect()->intended($this->redirectPath());
        }
        $role_id = $user_role->role_id;
        $role = Role::where('id' , $role_id)->first();
        if(in_array($role->name , ['servicer', 'sales', 'salesdirector', 'shopkeeper', 'director', 'vp', 'admin' , 'financer'])){
            return redirect()->intended($this->redirectPath());
        }else{
            return redirect()->intended('/saas/image');
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

        // 判断手机验证码是否正确
        $captcha = CaptchaModel::where('phone', $request['phone'])->where('code', $request['phone_verify'])->where('type', $request['type'])->first();

        if(!$captcha){
            return redirect('/register')->with('phone-error-message', '手机号码验证失败，请重新验证。')->withInput();
        }
        $user = $this->user_model;
        $user->account = $request['account'];
        $user->phone = $request['phone'];
        $user->password = bcrypt($request['password']);
        $user->type = 1;
        $result = $user->save();
        if($result == true){
            $captcha->delete(); // 删除手机验证码记录
            return redirect('/login')->with('error_message', '欢迎注册，请等待审核!');
        }else{
            return redirect('/register')->with('error_message', '注册失败，请重新注册。')->withInput();
        }
    }

    /**
     * 判断数据库是否存在手机号
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string json
     */
    public function phoneCaptcha(Request $request)
    {
        $result = UserModel::where('phone', $request['phone'])->first();
        if(!$result){
            return ajax_json(0, '该手机号还没有注册！');
        }
        return ajax_json(1, '该手机号已注册！');
    }

    /**
     * 校验用户名
     *
     * @return string json
     */
    public function postAccount(Request $request)
    {

        $account = UserModel::where('account', $request['account'])->first();
        if (!$account)
        {
            return ajax_json(0, '用户名可以注册！');
        }
        return ajax_json(1, '用户名已经注册！');

    }
}
