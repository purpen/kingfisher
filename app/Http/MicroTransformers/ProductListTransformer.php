<?php

namespace App\Http\MicroTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class ProductListTransformer extends TransformerAbstract
{

    public function transform(ProductsModel $product)
    {

        return [
            'id' => $product->id,
            'product_id' => $product->id,
            'number' => $product->number,
            'name' => $product->title,
            'price' => $product->cost_price,
            'inventory' => $product->inventory,
            'image' => $product->saas_img,
        ];
    }


}