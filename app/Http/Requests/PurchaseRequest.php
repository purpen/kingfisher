<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PurchaseRequest extends Request
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
            'supplier_id' => 'required|integer',
            'storage_id' => 'required|integer',
            'price' => 'required',
            'count' => 'required',
            'summary' => 'max:500',
            'department' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => "供应商不能为空！",
            'storage_id.required' => '仓库不能为空！',
            'count.required' => '采购数量不能为空！',
            'price.required' => '采购价格不能为空！',
            'summary.max' => '备注字数不能超过500字！',
            'department.required' => '部门不能为空',
        ];
    }
}
