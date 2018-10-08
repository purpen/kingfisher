<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class FollowListTransformer extends TransformerAbstract
{

    public function transform(ProductsModel $products)
    {
        return [
            'product_id' => $products->id,
            'name' => $products->title,
            'status' => $products->status,
            'price' => $products->market_price,
            'inventory' => intval($products->inventory),
            'image' => $products->big_img,
        ];
    }


}