<?php

namespace App\Http\MicroTransformers;

use App\Models\OrderModel;
use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{

    public function transform(OrderModel $orders)
    {

        $all = [];
        $orderSkus = $orders->orderSkuRelation;
        //订单明细
        foreach ($orderSkus as $orderSku){
            $all[] = [
                'sku_number' => $orderSku->sku_number,
                'price' => $orderSku->price,
                'quantity' => $orderSku->quantity,
                'image' => $orderSku->product ? $orderSku->product->saas_img : '' ,
                'product_title' => $orderSku->product ? $orderSku->product->title : '' ,
                'sku_mode' => $orderSku->productsSku ? $orderSku->productsSku->mode : '' ,
            ];
        }

        return [
            'id' => $orders->id,
            'number' => $orders->number,
            'express_id' => $orders->express_id,
            'express_no' => $orders->express_no,
            'son_order_count' => count($orderSkus),
            'total_money' => $orders->total_money,
            'count' => $orders->count,
            'buyer_name' => $orders->buyer_name,
            'buyer_phone' => $orders->buyer_phone,
            'buyer_address' => $orders->buyer_address,
            'buyer_province' => $orders->buyer_province,
            'buyer_city' => $orders->buyer_city,
            'buyer_county' => $orders->buyer_county,
            'buyer_township' => $orders->buyer_township,
            'buyer_zip' => $orders->buyer_zip,
            'payment_type' => $orders->payment_type,
            'order_start_time' => $orders->order_start_time,
            'order_send_time' => $orders->order_send_time,
            'invoice_info' => $orders->invoice_info,
            'invoice_type' => $orders->invoice_type,
            'invoice_header' => $orders->invoice_header,
            'orderSkus' => $all,
        ];
    }


}