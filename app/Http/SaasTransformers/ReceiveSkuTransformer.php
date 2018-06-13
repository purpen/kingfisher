<?php
namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ReceiveSkuTransformer extends TransformerAbstract
{
    public function transform($channels)
    {
        $distributor = $channels->paymentReceiptOrderDetail;
        return [
            'id' => (int)$channels->id,
            'number' => $channels->number,
            'distributor_user_id' => $channels->distributor_user_id,
            'created_at' => strtotime($channels->created_at),
            'price' => $channels->price,
            'user_id' => $channels->user_id,
            'status' => (int)$channels->status,

            'id as payment_id' =>(int)$distributor->id,
            'type' =>(int)$distributor->type,//类型需要改为1
            'target_id' =>(int)$distributor->target_id,
            'skuID' =>(int)$distributor->skuID,
            'sku_number' =>(int)$distributor->sku_number,
            'sku_name' =>(int)$distributor->sku_name,
            'price as total_price' =>(int)$distributor->price,
            'quantity' =>(int)$distributor->quantity,
            'favorable' =>(int)$distributor->favorable,
        ];

    }

}