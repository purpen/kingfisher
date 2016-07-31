<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EnterWarehouseRequest extends Request
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
            'enter_warehouse_id' => 'required|integer',
            'enter_sku_id' => 'required',
            'sku_id' => 'required',
            'count' => 'required',
            'summary' => 'max:500'
        ];
    }
}
