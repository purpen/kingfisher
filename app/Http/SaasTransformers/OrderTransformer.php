<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform($orders)
    {
        return [
            'id' => $orders->id,
            'number' => $orders->number,
            'buyer_name' => $orders->buyer_name,
            'buyer_phone' => $orders->buyer_phone,
            'buyer_address' => $orders->buyer_address,
            'pay_money' => $orders->pay_money,
            'user_id' => $orders->user_id,
            'count' => $orders->count,
            'logistics_name' => $orders->logistics ? $orders->logistics->name : '',
            'express_no' => $orders->express_no,
            'order_start_time' => $orders->order_start_time,
            'buyer_summary' => $orders->buyer_summary,
            'seller_summary' => $orders->seller_summary,
            'status' => $orders->status,
            'status_val' => $orders->status_val,
            'buyer_province' => $orders->buyer_province,
            'buyer_city' => $orders->buyer_city,
            'buyer_county' => $orders->buyer_county,
            'buyer_township' => $orders->buyer_township,
        ];
    }
}
