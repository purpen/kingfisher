<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class ProductListTransformer extends TransformerAbstract
{

    public function transform(ProductsModel $collection)
    {

        return [
            'id' => $collection->id,
            'product_id' => $collection->id,
            'number' => $collection->number,
            'name' => $collection->title,
            'price' => $collection->cost_price,
            'inventory' => intval($collection->inventory),
            'image' => $collection->saas_img,
        ];
    }


}