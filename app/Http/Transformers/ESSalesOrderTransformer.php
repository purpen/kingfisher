<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class ESSalesOrderTransformer extends TransformerAbstract
{
    public function transform(OrderModel $ESSalesOrder)
    {
        return [
            'id' => $ESSalesOrder->id,
            'number' => $ESSalesOrder->number,
            'order_start_time' => $ESSalesOrder->order_start_time,
            'product_name' => $ESSalesOrder->product_name,
            'form_app' => $ESSalesOrder->form_app,
            'form_app_val' => $ESSalesOrder->form_app_val,
            'mode' => $ESSalesOrder->mode,
            'weight' => $ESSalesOrder->weight,
            'unit_price' => $ESSalesOrder->unit_price,
            'quantity' => $ESSalesOrder->quantity,
            'pay_money' => $ESSalesOrder->pay_money,
            'status' => $ESSalesOrder->status,
            'status_val' => $ESSalesOrder->status_val,
        ];
    }
}
