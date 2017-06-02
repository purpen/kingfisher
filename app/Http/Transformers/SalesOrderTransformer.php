<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class SalesOrderTransformer extends TransformerAbstract
{
    public function transform(OrderModel $salesOrder)
    {
        return [
            'id' => $salesOrder->id,
            'number' => $salesOrder->number,
            'order_start_time' => $salesOrder->order_start_time,
            'product_name' => $salesOrder->product_name,
            'buyer_name' => $salesOrder->buyer_name,
            'mode' => $salesOrder->mode,
            'weight' => $salesOrder->weight,
            'unit_price' => $salesOrder->unit_price,
            'quantity' => $salesOrder->quantity,
            'pay_money' => $salesOrder->pay_money,
            'status' => $salesOrder->status,
            'status_val' => $salesOrder->status_val,
        ];
    }
}
