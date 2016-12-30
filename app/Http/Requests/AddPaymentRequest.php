<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddPaymentRequest extends Request
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
     *
     */
    public function rules()
    {
        return [
            'amount' => 'required',
            'receive_user' => 'required',
            'type' => 'required',
            'payment_account_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => '金额不能为空',
            'receive_user.required' => '付款人不能为空',
            'type.required' => '请选择类型',
            'payment_account_id.required' => '请选择付款账户',
        ];
    }
}
