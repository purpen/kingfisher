<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ReceiveSkuTransformer extends TransformerAbstract
{
    public function transform($channels)
    {
        return [
            'id' => (int)$channels->id,
            'number' => $channels->number,
            'distributor_user_id' => $channels->distributor_user_id,
            'created_at' => strtotime($channels->created_at),
            'price' => $channels->price,
            'user_id' => $channels->user_id,
            'status' => (int)$channels->status,

            'payment_id' =>(int)$channels['payment_receipt'][0]['id'],
            'type' =>(int)$channels['payment_receipt'][0]['type'],
            'target_id' =>(int)$channels['payment_receipt'][0]['target_id'],
            'skuID' =>(int)$channels['payment_receipt'][0]['sku_id'],
            'sku_number' =>$channels['payment_receipt'][0]['sku_number'],
            'sku_name' =>$channels['payment_receipt'][0]['sku_name'],
            'price as total_price' =>$channels['payment_receipt'][0]['price'],
            'quantity' =>$channels['payment_receipt'][0]['quantity'],
            'favorable' =>$channels['payment_receipt'][0]['favorable'],
        ];

    }

}