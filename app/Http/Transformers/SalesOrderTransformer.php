<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class SalesOrderTransformer extends TransformerAbstract
{
    public function transform($salesOrders)
    {
        return [
            'id' => $salesOrders->order_sku_relation_id,
            'number' => $salesOrders->number,
            'order_start_time' => $salesOrders->order_start_time,
            'product_name' => $salesOrders->title.$salesOrders->sku_name,
            'buyer_name' => $salesOrders->buyer_name,
            'mode' => $salesOrders->mode,
            'weight' => $salesOrders->weight,
            'quantity' => $salesOrders->quantity,
            'price' => $salesOrders->price,
            'status' => $salesOrders->status,
            'refund_status' => $salesOrders->refund_status,
        ];
    }
}
