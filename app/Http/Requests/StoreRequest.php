<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreRequest extends Request
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
            'id' => 'integer',
            'name' => 'required|max:30',
//            'number' => 'required|max:10',
            'platform' => 'required|integer',
            'outside_info' => 'string',
            'type' => 'integer',
            'status' => 'integer',
            'user_id' => 'integer',
            'summary' => 'max:500',
            'contact_user' => 'max:15',
            'contact_number' => 'max:20',
        ];
    }

    //验证提示
    public function messages()
    {
        return [
            'id.integer' => 'ID不能为空',
            'name.required' => '店铺名称不能为空',
            'name.max' => '店铺名称不能超过30字',
//            'number.required' => '编号不能为空',
//            'number.max' => '编号长度不能超过10字符',
            'platform.required' => '平台不能为空',
            'platform.integer' => '平台参数不正确',
            'type.integer' => '类型格式不正确',
            'status.integer' => '类型格式不正确',
            'user_id.integer' => '用户id格式不正确',
            'summary.max' => '备注长度不能超过500',
            'contact_user.max' => '联系人不能超过15个字符',
            'contact_number.max' => '联系方式不能超过20个字符'
        ];
    }
}
