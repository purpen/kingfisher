<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class ESSalesOrderTransformer extends TransformerAbstract
{
    public function transform($ESSalesOrders)
    {
        return [
            'id' => $ESSalesOrders->order_sku_relation_id,
            'number' => $ESSalesOrders->number,
            'order_start_time' => $ESSalesOrders->order_start_time,
            'product_name' => $ESSalesOrders->title.$ESSalesOrders->sku_name,
            'form_app' => $ESSalesOrders->form_app,
            'total_money' => $ESSalesOrders->total_money,
            'status' => $ESSalesOrders->status,
            'mode' => $ESSalesOrders->mode,
            'weight' => $ESSalesOrders->weight,
            'quantity' => $ESSalesOrders->quantity,
            'price' => $ESSalesOrders->price,
            'refund_status' => $ESSalesOrders->refund_status,
            'platform' => $ESSalesOrders->platform,

        ];
    }
}
