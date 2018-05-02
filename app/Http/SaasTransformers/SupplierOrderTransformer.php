<?php

namespace App\Http\SaasTransformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class SupplierOrderTransformer extends TransformerAbstract
{
    public function transform($orders)
    {
        switch ($orders->status) {
            case 0:
                $status = '已取消';
                break;
            case 1:
                $status = '待付款';
                break;
            case 5:
                $status = '待审核';
                break;
            case 8:
                $status = '待发货';
                break;
            case 10:
                $status = '已发货';
                break;
            case 20:
                $status = '已完成';
                break;
            default:
                $status = '已取消';
        }

        $order = OrderModel::where('id', $orders->id)->first();

        return [
            'id' => $orders->id,
            'number' => $orders->number,
            'buyer_name' => $orders->buyer_name,
            'buyer_phone' => $orders->buyer_phone,
            'buyer_address' => $orders->buyer_address,
            'pay_money' => $orders->pay_money,
            'user_id' => $orders->user_id,
            'count' => $orders->count,
            'logistics_name' => $orders->name,
            'express_no' => $orders->express_no,
            'express_id' => $orders->express_id,
            'order_start_time' => strtotime($orders->order_start_time),
            'buyer_summary' => $orders->buyer_summary,
            'seller_summary' => $orders->seller_summary,
            'status' => $orders->status,
            'status_val' => $status,
            'buyer_province' => $orders->buyer_province,
            'buyer_city' => $orders->buyer_city,
            'buyer_county' => $orders->buyer_county,
            'buyer_township' => $orders->buyer_township,
            'buyer_zip' => $orders->buyer_zip,
            'freight' => $orders->freight,
            'user_id_sales' => $orders->user_id_sales,
//            'storage_id' => $orders->storage_id,
            'payment_type' => $orders->payment_type,
            'discount_money' => $orders->discount_money,
            'type' => $orders->type,
//            'sku_id' => $orders->sku_id,
//            'product_id' => $orders->product_id,
//            'count' => $orders->count,
//            'market_price' => $orders->market_price,
//            'sale_price' => $orders->sale_price,
//            'cost_price' => $orders->cost_price,
////            'type_val' => $orders->type_val,
            'orderSku' => $order ? $order->order_skus : '',
        ];
    }
}
