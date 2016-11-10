<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CategoryRequest extends Request
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
            'title' => 'required|max:20',
            'order' => 'numeric',
            'type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '分类名不能为空！',
            'title.max' => '分类名不能超过20个字',
            'order.numeric' => '排序应输入数字',
            'type.required' => '请选择类型'
        ];
    }
}
