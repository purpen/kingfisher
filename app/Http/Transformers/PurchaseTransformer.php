<?php

namespace App\Http\Transformers;

use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class PurchaseTransformer extends TransformerAbstract
{
    public function transform(PurchaseModel $purchase)
    {
        return [
            'id' => $purchase->id,
            'number' => $purchase->number,
            'predict_time' => $purchase->predict_time,
            'supplier_name' => $purchase->supplier_name,
            'sup_random_id' => $purchase->sup_random_id,
            'total_price' => $purchase->price,
            'storage_status' => $purchase->storage_status,
            'verified' => $purchase->verified,
            'purchaseSkus' => $purchase->purchaseSku,

        ];
    }
}
