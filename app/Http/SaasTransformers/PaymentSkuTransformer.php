<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class PaymentSkuTransformer extends TransformerAbstract
{
    public function transform($payment_skus)
    {
        return [
            'id' => (int)$payment_skus->id,
            'number' => $payment_skus->number,
            'supplier_user_id' => $payment_skus->supplier_user_id,
            'created_at' => strtotime($payment_skus->created_at),
            'total_price' => $payment_skus->total_price,
            'user_id' => $payment_skus->user_id,
            'status' => (int)$payment_skus->status,

            'payment_id' =>(int)$payment_skus['payment_receipt'][0]['id'],
            'type' =>(int)$payment_skus['payment_receipt'][0]['type'],//类型需要改为2
            'target_id' =>(int)$payment_skus['payment_receipt'][0]['target_id'],
            'skuID' =>(int)$payment_skus['payment_receipt'][0]['sku_id'],
            'sku_number' =>(int)$payment_skus['payment_receipt'][0]['sku_number'],
            'sku_name' =>$payment_skus['payment_receipt'][0]['sku_name'],
            'price' =>$payment_skus['payment_receipt'][0]['price'],
            'quantity' =>$payment_skus['payment_receipt'][0]['quantity'],
            'favorable' =>$payment_skus['payment_receipt'][0]['favorable'],
        ];

    }

}