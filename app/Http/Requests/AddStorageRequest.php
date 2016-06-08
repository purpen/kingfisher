<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
class AddStorageRequest extends Request
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
                'name'=>'required|max:30|unique:storage',
//                'number'=>'required|max:10|unique:storage',
                'content'=>'required|max:500'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '仓库名已存在',
//            'number.unique' => '仓库编号已存在',
            'name.required' => '仓库名称不能为空',
            'name.max' =>'仓库名称不能大于30个字',
//            'number.required' => '仓库编号不能为空',
//            'number.max' => '仓库编号长度不能大于10',
            'content.required' => '仓库简介不能为空',
            'content.max' => '仓库简介字数不能超过500'
        ];
    }
}
