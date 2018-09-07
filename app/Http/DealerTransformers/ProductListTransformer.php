<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class ProductListTransformer extends TransformerAbstract
{

    public function transform(ProductsModel $products)
    {
        return [
            'id' => $products->id,
            'product_id' => $products->id,
            'number' => $products->number,
            'name' => $products->title,
            'price' => $products->market_price,
            'inventory' => intval($products->inventory),
            'image' => $products->big_img,
            'product_details' =>$products->detial_img,
            'categories' => $products->categories?$products->categories:'',
            'follow' => $products->follow
        ];
    }


}