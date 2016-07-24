<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoleRequest extends Request
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
            'name' => 'required',
            'display_name' => 'required',
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
            'name.required'  => '帐号是必填的',
            'display_name.required'  => '帐号是必填的',
        ];
    }
}
