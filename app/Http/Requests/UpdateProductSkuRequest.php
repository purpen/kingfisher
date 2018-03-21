<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateProductSkuRequest extends Request
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
            'mode' => 'required|max:50',
            'bid_price' => 'required',
            'cost_price' => 'required',
            'price' => 'required',
            'unique_number' => 'required|unique:products_sku',
        ];
    }

    public function messages()
    {
        return [
            'mode.required' => '颜色或型号不能为空',
            'mode.max' => '颜色或型号长度不能大于50个字符',
            'price.required' => '价格不能为空',
            'bid_price.required' => '标准进价不能为空',
            'cost_price.required' => '成本价不能为空',
            'unique_number.unique' => '站外编号已存在',

        ];
    }
}
