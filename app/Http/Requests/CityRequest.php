<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CityRequest extends Request
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
            'name' => 'required|max:50',
            'number' => 'required',
            'p_number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
            'name.max' => '名称不能超过50个字符',
            'number.required' =>'编号不能为空',
            'p_number.required' => '请选择省份',
        ];
    }
}
