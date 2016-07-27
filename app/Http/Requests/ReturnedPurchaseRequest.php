<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReturnedPurchaseRequest extends Request
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
            'purchase_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'storage_id' => 'required|integer',
            'sku_id' => 'required',
            'price' => 'required',
            'count' => 'required',
            'summary' => 'max:500'
        ];
    }

    public function messages()
    {
        return [
            'storage_id.required' => '仓库不能为空！',
            'count.required' => '退货数量不能为空！',
            'price.required' => '退货价格不能为空！',
            'summary.max' => '备注字数不能超过500字！'
        ];
    }
}
