<?php

namespace App\Http\Transformers;

use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class PurchaseInvoiceTransformer extends TransformerAbstract
{
    public function transform($pInvoices)
    {
        return [
            'id' => $pInvoices->purchase_sku_id,
            'invoice_info' => $pInvoices->invoice_info,
            'invoice_time' => $pInvoices->created_at,
            'price' => $pInvoices->price,
            'storage_status' => $pInvoices->storage_status,
            'mode' => $pInvoices->mode,
            'weight' => $pInvoices->weight,
            'quantity' => $pInvoices->count,
            'product_name' => $pInvoices->title,
            'verified' => $pInvoices->verified,

        ];
    }
}
