<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use League\Fractal\TransformerAbstract;

class ESSalesOrderTransformer extends TransformerAbstract
{
    public function transform($ESSalesOrders)
    {
        return [
            'id' => $ESSalesOrders->id,
            'number' => $ESSalesOrders->number,
            'order_start_time' => $ESSalesOrders->order_start_time,
            'form_app' => $ESSalesOrders->form_app,
            'pay_money' => $ESSalesOrders->pay_money,
            'status' => $ESSalesOrders->status,
            'mode' => $ESSalesOrders->mode,
            'weight' => $ESSalesOrders->weight,
            'quantity' => $ESSalesOrders->quantity,
            'price' => $ESSalesOrders->price,
        ];
    }
}
