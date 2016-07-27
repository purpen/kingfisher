<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddStoragePlaceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:30|unique:storage_places',
            'storage_rack_id' => 'required|integer',
//            'number'=>'required|max:10|unique:storage_places',
            'content'=>'required|max:500'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '仓位名已存在',
//            'number.unique' => '仓区编号已存在',
            'name.required' => '仓位名称不能为空！',
            'name.max' =>'仓位名称不能大于30个字',
//            'number.required' => '仓区编号不能为空',
//            'number.max' => '仓区编号长度不能大于10',
            'content.required' => '仓位简介不能为空',
            'content.max' => '仓位简介字数不能超过500'
        ];
    }
}
