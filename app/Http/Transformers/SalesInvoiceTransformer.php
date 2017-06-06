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
            'product_name' => $salesOrder->product_name,
            'buyer_name' => $salesOrder->buyer_name,
            'mode' => $salesOrder->mode,
            'weight' => $salesOrder->weight,
            'unit_price' => $salesOrder->unit_price,
            'quantity' => $salesOrder->quantity,
            'pay_money' => $salesOrder->pay_money,
        ];
    }
}
