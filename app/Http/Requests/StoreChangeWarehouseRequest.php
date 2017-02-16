<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreChangeWarehouseRequest extends Request
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
            'out_storage_id' => 'required|integer',
            'in_storage_id' => 'required|integer',
            'sku_id' => 'required',
            'count' => 'required',
            'summary' => 'max:500',
            'out_department' => 'required|integer',
            'in_department' => 'required|integer',

        ];
    }
        public function messages()
    {
        return [
            'out_storage_id.required' => "出库仓库不能为空！",
            'in_storage_id.required' => '入库仓库仓库不能为空！',
            'sku_id.required' => 'ｓｋｕ不能为空！',
            'count.required' => '数量不能为空！',
            'summary.max' => '备注字数不能超过500字！',
            'out_department.required' => '请选择调出部门',
            'in_department.required' => '请选择调入部门',
        ];
    }
}
