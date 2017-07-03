<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class DeliveryTransformer extends TransformerAbstract
{
    public function transform($deliveries)
    {
        return [
            'id' => $deliveries->order_sku_relation_id,
            'number' => $deliveries->number,
            'order_start_time' => $deliveries->order_start_time,
            'order_send_time' => $deliveries->order_send_time,
            'status' => $deliveries->status,
            'express_no' => $deliveries->express_no,
            'mode' => $deliveries->mode,
            'weight' => $deliveries->weight,
            'quantity' => $deliveries->quantity,
            'price' => $deliveries->price,
            'product_name' => $deliveries->title,
        ];
    }
}
