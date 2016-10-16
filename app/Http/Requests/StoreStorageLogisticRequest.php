<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreStorageLogisticRequest extends Request
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
            'id' => 'integer',
            'store_id' => 'unique:store_storage_logistics',
        ];
    }

    public function messages()
    {
        return [
            'store_id' => '店铺已存在'
        ];
    }
}
