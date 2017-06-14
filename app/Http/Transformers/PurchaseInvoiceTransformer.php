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
            'invoice_info' => $purchase->invoice_info,
            'invoice_time' => $purchase->invoice_info ? $purchase->created_at->format('Ymd hms') : '',
            'supplier_name' => $purchase->supplier_name,
            'sup_random_id' => $purchase->sup_random_id,
            'total_price' => $purchase->price,
            'storage_status' => $purchase->storage_status,
            'purchaseSkus' => $purchase->purchaseSku,
        ];
    }
}
