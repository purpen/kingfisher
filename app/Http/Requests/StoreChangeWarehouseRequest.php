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
        ];
    }
}
