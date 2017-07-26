<?php

namespace App\Http\SaasTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class OpenProductListTransformer extends TransformerAbstract
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function transform(ProductsModel $product)
    {
        return [
            'id' => $product->id,
            'product_id' => $product->id,
            'number' => $product->number,
            'name' => $product->title,
            'price' => $product->cost_price,
            'inventory' => $product->inventory,
            'image' => $product->middle_img,
            'status' => $product->isCooperation($this->user_id),
        ];
    }


}