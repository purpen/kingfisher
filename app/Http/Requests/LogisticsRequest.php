<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LogisticsRequest extends Request
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
     */
    public function rules()
    {
        return [
            'id' => 'integer',
            'name' => 'required|max:50|unique:logistics',
            'logistics_id' => 'required|max:20',
            'area' => 'max:50',
            'contact_user' => 'required|max:15',
            'contact_number' => 'required|max:15',
            'summary' => 'max:500'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '公司名称不能为空',
            'name.unique' => '公司名称已存在',
            'logistics_id.required' => '快递代码不能为空',
            'contact_user.required' => '联系人不能为空',
            'contact_number.required' => '联系电话不能为空',
            'contact_number.integer' => '联系电话格式不正确',
            'summary.max' => '备注不能超过500字'
        ];
    }
}
