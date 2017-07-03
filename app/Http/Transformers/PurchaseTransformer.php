<?php

namespace App\Http\Transformers;

use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class PurchaseTransformer extends TransformerAbstract
{
    public function transform($purchases)
    {
        return [
            'id' => $purchases->purchase_sku_id,
            'number' => $purchases->purchase_number,
            'predict_time' => $purchases->predict_time,
            'product_name' => $purchases->title,
            'storage_status' => $purchases->storage_status,
            'verified' => $purchases->verified,
            'mode' => $purchases->mode,
            'weight' => $purchases->weight,
            'quantity' => $purchases->count,
            'price' => $purchases->price,
            'supplier_name' => $purchases->name,
        ];
    }
}
