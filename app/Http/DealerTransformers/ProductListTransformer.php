<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class ProductListTransformer extends TransformerAbstract
{

    public function transform($products)
    {
        return [
            'id' => $products->id,
            'product_id' => $products->id,
            'number' => $products->number,
            'name' => $products->title,
            'price' => $products->cost_price,
            'inventory' => intval($products->inventory),
            'image' => $products->image,
        ];
    }


}