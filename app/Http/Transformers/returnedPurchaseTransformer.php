<?php

namespace App\Http\Transformers;

use App\Models\PurchaseModel;
use League\Fractal\TransformerAbstract;

class returnedPurchaseTransformer extends TransformerAbstract
{
    public function transform($returnedPurchases)
    {
        return [
            'id' => $returnedPurchases->returned_purchases_id,
            'sku_number' => $returnedPurchases->sku_number,
            'returned_purchases_number' => $returnedPurchases->returned_purchases_number,
            'product_name' => $returnedPurchases->title,
            'mode' => $returnedPurchases->mode,
            'weight' => $returnedPurchases->weight,
            'returned_sku_count' => $returnedPurchases->returned_sku_count,
            'price' => $returnedPurchases->price,
            'created_at' => $returnedPurchases->created_at,
        ];
    }
}
