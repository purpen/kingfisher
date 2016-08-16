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
                'name'=>'required|max:30',
//                'number'=>'required|max:10|unique:storages',
                'content'=>'required|max:500'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '仓库名称不能为空',
            'name.max' =>'仓库名称不能大于30个字',
            'content.required' => '仓库简介不能为空',
            'content.max' => '仓库简介字数不能超过500'
        ];
    }
}
