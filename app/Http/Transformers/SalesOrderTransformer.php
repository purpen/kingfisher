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
            'buyer_name' => $salesOrder->buyer_name,
            'pay_money' => $salesOrder->pay_money,
            'status' => $salesOrder->status,
            'supplier_name' => $salesOrder->supplier_name,
            'sup_random_id' => $salesOrder->sup_random_id,
            'orderSkuRelation' => $salesOrder->orderSkuRelation,
        ];
    }
}
