<?php

namespace App\Http\SaasTransformers;

use App\Models\OrderModel;
use App\Models\ProductsSkuModel;
use Illuminate\Support\Facades\Log;
use League\Fractal\TransformerAbstract;

class SupplierOrderTransformer extends TransformerAbstract
{
    public function transform($orders)
    {
        $order = OrderModel::where('id', $orders ? $orders->order_id : 0)->first();
        if($order){
            switch ($order) {
                case 0:
                    $status_val = '已取消';
                    break;
                case 1:
                    $status_val = '待付款';
                    break;
                case 5:
                    $status_val = '待审核';
                    break;
                case 8:
                    $status_val = '待发货';
                    break;
                case 10:
                    $status_val = '已发货';
                    break;
                case 20:
                    $status_val = '已完成';
                    break;
                default:
                    $status_val = '已取消';
            }
            $status = $order->status;
        }else{
            $status_val = '';
            $status = -1;
        }

        $order_sku = [];
        if($order){
            $orderSku = $order->orderSkuRelation;
        }
        if(!empty($orderSku)){
            $order_sku = $orderSku->toArray();
            foreach ($order_sku as $v){
                $sku_id = $v['sku_id'];
                $sku = ProductsSkuModel::where('id' , (int)$sku_id)->first();
                if($sku->assets){
                    $sku->path = $sku->assets->file->small;
                }else{
                    $sku->path = url('images/default/erp_product.png');
                }
                $order_sku[0]['path'] = $sku->path;
                $order_sku[0]['product_title'] = $sku->product ? $sku->product->title : '';

                $orders->order_skus = $order_sku;
            }
        }
        return [
            'id' => (int)$orders->order_id,
            'number' => $orders->number,
            'buyer_name' => $orders->buyer_name,
            'buyer_phone' => $orders->buyer_phone,
            'buyer_address' => $orders->buyer_address,
            'pay_money' => $orders->pay_money,
            'user_id' => (int)$orders->user_id,
            'count' => (int)$orders->count,
            'logistics_name' => $orders->name,
            'express_no' => $orders->express_no,
            'express_id' => (int)$orders->express_id,
            'order_start_time' => strtotime($orders->order_start_time),
            'buyer_summary' => $orders->buyer_summary,
            'seller_summary' => $orders->seller_summary,
            'status' =>  (int)$status,
            'status_val' => $status_val,
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
            'type' => (int)$orders->type,
//            'sku_id' => $orders->sku_id,
//            'product_id' => $orders->product_id,
//            'count' => $orders->count,
//            'market_price' => $orders->market_price,
//            'sale_price' => $orders->sale_price,
//            'cost_price' => $orders->cost_price,
////            'type_val' => $orders->type_val,
            'orderSku' => $order_sku,
        ];
    }
}
