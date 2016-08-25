<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
            'title' => 'required|max:50',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'sale_price' => 'required',
            'number' => 'required|unique:products',
            'status' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '名称不能为空',
            'title.max' => '名称长度不能大于50',
            'category_id.required' => '请选择分类',
            'supplier_id.required' => '请选择供应商',
            'sale_price.required' => '销售价格不能为空',
            'number.required' => '货号不能为空',
            'number.unique' => '货号已存在',
            'unit.required' => '单位不能为空',
            'unit.max' => '单位长度不能大于10字符',
            'published.required' => '请选择是否发布'
        ];
    }
}
