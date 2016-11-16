<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddOrderUserRequest extends Request
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'phone' => 'required',
            'from_to' => 'required',
            'store_id' => 'required',
            'type' => 'required',
            'sex' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '收件人不能为空',
            'phone.required' => '手机号不能为空',
            'from_to.required' => '请选择会员来源',
            'store_id.required' => '请选择点店铺',
            'type.required' => '请选择会员性质',
            'sex.required' => '请选择性别'
        ];
    }
}
