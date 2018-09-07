<?php

namespace App\Http\DealerTransformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(OrderModel $orders)
    {
        $price_sku =$orders->orderSkuRelation;

        return [
            'id' => (int)$orders->id,
            'number' => $orders->number,
            'pay_money' => $orders->pay_money,
            'user_id' => (int)$orders->user_id,
            'count' => (int)$orders->count,
            'express_no' => $orders->express_no,
            'express_id' => (int)$orders->express_id,
            'order_start_time' =>$orders->order_start_time,
            'status' => (int)$orders->status,
            'status_val' => $orders->status_val,
            'freight' => $orders->freight,
            'user_id_sales' => (int)$orders->user_id_sales,
            'payment_type' => $orders->payment_type,
            'orderSku' => $orders->order_skus,
            'address_list' => $orders->address_list,
        ];
    }
}
