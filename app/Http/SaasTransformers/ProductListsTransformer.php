<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ProductListsTransformer extends TransformerAbstract
{
    public function transform($product)
    {
        $erp_product = $product->ProductsModel;

        return [
            'id' => $product->id,
            'product_id' => $erp_product->id,
            'number' => $erp_product->number,
            'name' => $erp_product->title,
            'price' => sprintf("%0.2f", $product->price) ? sprintf("%0.2f", $product->price) : $erp_product->cost_price,
            'inventory' => $product->stock ? $product->stock : $erp_product->inventory,
            'image' => $erp_product->first_img,
            'status' => (int)$product->status,
        ];
    }


}