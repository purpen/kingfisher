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
            'id' => $salesInvoices->id,
            'invoice_info' => $salesInvoices->invoice_info,
            'invoice_time' => $salesInvoices->invoice_info ? $salesInvoices->created_at : '',
            'product_name' => $salesInvoices->sku_name,
            'buyer_name' => $salesInvoices->buyer_name,
            'mode' => $salesInvoices->mode,
            'weight' => $salesInvoices->weight,
            'quantity' => $salesInvoices->quantity,
            'price' => $salesInvoices->price,
        ];
    }
}
