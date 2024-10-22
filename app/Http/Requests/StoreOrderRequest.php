<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreOrderRequest extends Request
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
            'type' => 'required|integer',              //类型：1.自营；2.淘宝；3.天猫；4.京东；5.--u
            'store_id' => 'required|integer',          //关联店铺ID
            'payment_type' => 'required|integer',      //付款方式：1.在线；2. 货到付款
            'freight' => 'required',	               //运费
            'express_id' => 'required|integer',        //物流ID
            'buyer_name' => 'required',	               //收货人姓名
            'buyer_tel' => 'regex:/^[0-9]+$/',          //收货人电话
            'buyer_phone' => 'required|regex:/^1[34578][0-9]{9}$/',    //收货人手机
            'buyer_address' => 'required',
            'buyer_summary' => 'max:500',              //买家备注
            'seller_summary' => 'max:500',             //卖家备注
            'summary' => 'max:50',
            'storage_id' => 'required',
            'sku_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '订单类型不能为空',
            'payment_type.required' => '付款方式不能为空',
            'pay_money.required' => '支付金额不能为空',
            'freight.required' => '运费不能为空',
            'discount_money.required' => '优惠金额不能为空',
            'express_id.required' => '请选择物流',
            'storage_id.required' => '请选择仓库',
            'buyer_name.required' => '收货人姓名不能为空',
            'buyer_phone.required' => '收货人手机不能为空',
            'buyer_phone.regex' => '收货人手机格式不正确',
            'buyer_address.required' => '收货人地址不能为空'
        ];
    }

}
