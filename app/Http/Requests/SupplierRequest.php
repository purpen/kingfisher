<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SupplierRequest extends Request
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
            'name' => 'required|max:50',
            'address' => 'max:100',
            'legal_person' => 'max:15',
            'tel' => 'max:15',
            'contact_user' => 'max:15',
            'contact_number' => 'max:20',
            'contact_email' => 'max:50|email',
            'contact_qq' => 'max:20',
            'contact_wx' => 'max:30',
            'summary' => 'max:500',
            'relation_user_id' => 'required|integer',
//            'status' => 'max:5',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
            'name.max' => '名称不能超过50个字符',
            'address.max' => '地址不能超过100个字符',
            'legal_person.max' => '企业法人不能超过15个字符',
            'tel.max' => '电话不能超过15个字符',
            'contact_user.max' => '联系人不能超过15个字符',
            'contact_number.max' => '联系人电话不能超过20个字符',
            'contact_qq.max' => 'qq不能超过20个字符',
            'summary.max' => '备注不能超过500个字符'
        ];
    }
}
