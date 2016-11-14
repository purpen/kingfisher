<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateOrderRequest extends Request
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
            'express_id' => 'required|integer',        //物流ID
            'storage_id' => 'required|integer',
            'buyer_name' => 'required',	               //收货人姓名
            'buyer_tel' => 'regex:/^[0-9]+$/',          //收货人电话
            'buyer_phone' => 'required|regex:/^1[34578][0-9]{9}$/',               //收货人手机
            'buyer_zip' => 'numeric',                 //收货人邮编
            'buyer_address' => 'required',
            'buyer_summary' => 'max:500',              //买家备注
            'seller_summary' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'express_id.required' => '请选择物流',
            'storage_id.required' => '请选择仓库',
            'buyer_name.required' => '收货人姓名不能为空',
            'buyer_phone.required' => '收货人手机不能为空',
            'buyer_phone.regex' => '收货人手机格式不正确',
            'buyer_zip.numeric' => '收货人邮编格式不正确',
            'buyer_address.required' => '收货人地址不能为空'
        ];
    }
}
