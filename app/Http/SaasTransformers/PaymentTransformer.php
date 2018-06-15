<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class PaymentTransformer extends TransformerAbstract
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
        ];

    }
}