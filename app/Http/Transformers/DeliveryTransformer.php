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
            'status' => $delivery->status,
            'express_no' => $delivery->express_no,
            'supplier_name' => $delivery->supplier_name,
            'sup_random_id' => $delivery->sup_random_id,
            'orderSkuRelation' => $delivery->orderSkuRelation,

        ];
    }
}
