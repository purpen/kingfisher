<?php
/**
 * Created by PhpStorm.
 * User: clg
 * Date: 16-7-26
 * Time: 下午2:01
 */

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ForgetRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 获取适用于请求的验证规则。
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|digits:11|regex:/^1[34578][0-9]{9}$/',
            'password' => 'required|between:6,16',
            'repassword'=>'required|same:password',
            'phone_verify' => 'required|size:6',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     *
     */
    public function messages()
    {
        return [
            'phone.required' => '手机号码是必填的',
            'phone.digits' => '手机号码是11位',
            'phone.regex' => '手机号码格式不合法',
            'password.required'  => '密码是必填的',
            'password.between'  => '密码必填是6到16位',
            'repassword.same'=>'两次密码不一致',
            'phone_verify.required'  => '手机验证码是必填的',
            'phone_verify.size'  => '手机验证码必须是6位',
        ];
    }
}




