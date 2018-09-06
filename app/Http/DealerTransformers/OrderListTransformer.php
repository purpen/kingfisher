<?php

namespace App\Http\DealerTransformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class OrderListTransformer extends TransformerAbstract
{
    public function transform(OrderModel $orders)
    {
        $sku_relation = [];
        $order_sku = $orders->orderSkuRelation;
        //订单明细
        foreach ($order_sku as $orderSku){
            $sku_relation[] = [
                'sku_id' => $orderSku->id,
                'price' => $orderSku->price,
                'quantity' => $orderSku->quantity,
                'image' => $orderSku->productsSku ? $orderSku->productsSku->first_img : '' ,
                'product_title' => $orderSku->product ? $orderSku->product->title : '' ,
                'sku_mode' => $orderSku->productsSku ? $orderSku->productsSku->mode : '' ,
            ];
        }

        return [
            'id' => (int)$orders->id,
            'number' => $orders->number,
            'buyer_name' => $orders->buyer_name,
            'pay_money' => $orders->pay_money,
            'total_money' => $orders->total_money,
            'count' => $orders->count,
            'user_id' => (int)$orders->user_id,
            'order_start_time' =>$orders->order_start_time,
            'status' => (int)$orders->status,
            'status_val' => $orders->status_val,
            'payment_type' => $orders->payment_type,
            'sku_relation' => $sku_relation,
        ];
    }
}
