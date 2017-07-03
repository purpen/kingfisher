<?php

namespace App\Http\Transformers;

use App\Models\OrderModel;
use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class SalesInvoiceTransformer extends TransformerAbstract
{
    public function transform($salesInvoices)
    {
        return [
            'id' => $salesInvoices->order_sku_relation_id,
            'invoice_info' => $salesInvoices->invoice_info,
            'invoice_time' => $salesInvoices->order_start_time,
            'product_name' => $salesInvoices->sku_name,
            'buyer_name' => $salesInvoices->buyer_name,
            'mode' => $salesInvoices->mode,
            'weight' => $salesInvoices->weight,
            'quantity' => $salesInvoices->quantity,
            'price' => $salesInvoices->price,
        ];
    }
}
