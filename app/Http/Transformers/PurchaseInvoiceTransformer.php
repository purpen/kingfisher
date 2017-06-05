<?php

namespace App\Http\Transformers;

use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class PurchaseInvoiceTransformer extends TransformerAbstract
{
    public function transform(PurchaseModel $purchase)
    {
        return [
            'id' => $purchase->id,
            'invoice_info' => '',
            'invoice_time' => '',
            'supplier_name' => $purchase->supplier_name,
            'product_name' => $purchase->product_name,
            'mode' => $purchase->mode,
            'weight' => $purchase->weight,
            'unit_price' => $purchase->unit_price,
            'count' => $purchase->count,
            'total_price' => $purchase->price,
            'storage_status' => $purchase->storage_status,
            'storage_status_val' => $purchase->storage_status_val,
        ];
    }
}
