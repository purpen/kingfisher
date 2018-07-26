<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class OpenProductListTransformer extends TransformerAbstract
{
    public function transform(ProductsModel $product)
    {

        return [
            'id' => $product->id,
            'product_id' => $product->id,
            'number' => $product->number,
            'name' => $product->title,
            'price' => $product->cost_price,
            'inventory' => intval($product->inventory),
            'image' => $product->saas_img,
        ];
    }


}