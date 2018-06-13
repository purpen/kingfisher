<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class PaymentSkuTransformer extends TransformerAbstract
{
    public function transform($payment_skus)
    {
        $payment = $payment_skus->paymentReceiptOrderDetail;
        return [
//            'id' => (int)$payment_skus->id,
//            'number' => $payment_skus->number,
//            'supplier_user_id' => $payment_skus->supplier_user_id,
//            'created_at' => strtotime($payment_skus->created_at),
//            'total_price' => $payment_skus->total_price,
//            'user_id' => $payment_skus->user_id,
//            'status' => (int)$payment_skus->status,

            'id as payment_id' =>(int)$payment->id,
            'type' =>(int)$payment->type,//类型需要改为2
            'target_id' =>(int)$payment->target_id,
            'skuID' =>(int)$payment->skuID,
            'sku_number' =>(int)$payment->sku_number,
            'sku_name' =>(int)$payment->sku_name,
            'price' =>(int)$payment->price,
            'quantity' =>(int)$payment->quantity,
            'favorable' =>(int)$payment->favorable,
        ];

    }

}