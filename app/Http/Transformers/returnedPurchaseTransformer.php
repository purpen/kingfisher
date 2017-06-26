<?php

namespace App\Http\Transformers;

use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class returnedPurchaseTransformer extends TransformerAbstract
{
    public function transform($returnedPurchases)
    {
        return [
            'id' => $returnedPurchases->purchase_id,
            'number' => $returnedPurchases->purchase_number,
            'predict_time' => $returnedPurchases->predict_time,
            'product_name' => $returnedPurchases->title,
            'storage_status' => $returnedPurchases->storage_status,
            'verified' => $returnedPurchases->verified,
            'mode' => $returnedPurchases->mode,
            'weight' => $returnedPurchases->weight,
            'quantity' => $returnedPurchases->count,
            'price' => $returnedPurchases->price,
        ];
    }
}
