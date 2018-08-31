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
            'buyer_name' => $orders->buyer_name,
            'buyer_phone' => $orders->buyer_phone,
            'buyer_address' => $orders->buyer_address,
            'pay_money' => $orders->pay_money,
            'user_id' => (int)$orders->user_id,
            'count' => (int)$orders->count,
            'logistics_name' => $orders->logistics ? $orders->logistics->name : '',
            'express_no' => $orders->express_no,
            'express_id' => (int)$orders->express_id,
            'order_start_time' => strtotime($orders->order_start_time),
            'buyer_summary' => $orders->buyer_summary,
            'seller_summary' => $orders->seller_summary,
            'status' => (int)$orders->status,
            'status_val' => $orders->status_val,
            'buyer_province' => $orders->buyer_province,
            'buyer_city' => $orders->buyer_city,
            'buyer_county' => $orders->buyer_county,
            'buyer_township' => $orders->buyer_township,
            'buyer_zip' => $orders->buyer_zip,
            'freight' => $orders->freight,
            'user_id_sales' => (int)$orders->user_id_sales,
            'payment_type' => $orders->payment_type,
            'discount_money' => $orders->discount_money,
            'type' => (int)$orders->type,
            'invoice_type'=>$orders->invoice_type,
            'type_val' => $orders->type_val,
            'orderSku' => $orders->order_skus,
        ];
    }
}
