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
            'form_app' => $ESSalesOrder->form_app,
            'pay_money' => $ESSalesOrder->pay_money,
            'status' => $ESSalesOrder->status,
            'supplier_name' => $ESSalesOrder->supplier_name,
            'sup_random_id' => $ESSalesOrder->sup_random_id,
            'orderSkuRelation' => $ESSalesOrder->orderSkuRelation,

        ];
    }
}
