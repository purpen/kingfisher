<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class DeliveryTransformer extends TransformerAbstract
{
    public function transform(OrderModel $delivery)
    {
        return [
            'id' => $delivery->id,
            'number' => $delivery->number,
            'order_start_time' => $delivery->order_start_time,
            'order_send_time' => $delivery->order_send_time,
            'product_name' => $delivery->product_name,
            'mode' => $delivery->mode,
            'weight' => $delivery->weight,
            'quantity' => $delivery->quantity,
            'status' => $delivery->status,
            'status_val' => $delivery->status_val,
            'express_no' => $delivery->express_no,
        ];
    }
}
