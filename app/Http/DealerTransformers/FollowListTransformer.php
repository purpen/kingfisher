<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class FollowListTransformer extends TransformerAbstract
{

    public function transform($products)
    {
        $product = new ProductsModel();
        return [
            'product_id' => $products->id,
            'name' => $products->title,
            'price' => $products->market_price,
            'inventory' => intval($products->inventory),
            'image' => $product->first_img,
        ];
    }


}