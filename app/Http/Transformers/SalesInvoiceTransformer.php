<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class SalesInvoiceTransformer extends TransformerAbstract
{
    public function transform(OrderModel $salesOrder)
    {
        return [
            'id' => $salesOrder->id,
            'invoice_info' => $salesOrder->invoice_info,
            'invoice_time' => $salesOrder->invoice_info ? $salesOrder->created_at->format('Ymd hms') : '',
            'buyer_name' => $salesOrder->buyer_name,
            'pay_money' => $salesOrder->pay_money,
            'supplier_name' => $salesOrder->supplier_name,
            'sup_random_id' => $salesOrder->sup_random_id,
            'orderSkuRelation' => $salesOrder->orderSkuRelation,

        ];
    }
}
