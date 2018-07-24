<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use App\Models\ProductUserRelation;
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
        $productUserRelation = new ProductUserRelation();

        return $productUserRelation->productListInfo($this->user_id, $product->id);
    }


}