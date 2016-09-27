<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'account' => 'required|between:2,20',
            'phone' => 'required|digits:11|regex:/^1[34578][0-9]{9}$/|unique:users',
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
            'account.required'  => '帐号是必填的',
            'account.between'  => '帐号必填是6到16位',
            'phone.required' => '手机号码是必填的',
            'phone.digits' => '手机号码是11位',
            'phone.regex' => '手机号码格式不合法',
            'phone.unique' => '手机号码已存在',
        ];
    }
}
