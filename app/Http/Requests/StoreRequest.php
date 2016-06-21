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
            'target_id' => 'max:15',
            'outside_info' => 'string',
            'type' => 'integer',
            'status' => 'integer',
            'user_id' => 'integer',
            'summary' => 'max:500'
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
            'target_id.max' => '关联站外店铺ID不能超过15字符',
            'type.integer' => '类型格式不正确',
            'status.integer' => '类型格式不正确',
            'user_id.integer' => '用户id格式不正确',
            'summary.max' => '备注长度不能超过500'
        ];
    }
}
