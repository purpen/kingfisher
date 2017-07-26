<?php

namespace App\Http\SaasTransformers;

use App\Models\ProductUserRelation;
use League\Fractal\TransformerAbstract;

/**
 * 推荐列表
 *
 * Class ProductListsTransformer
 * @package App\Http\SaasTransformers
 */
class ProductListsTransformer extends TransformerAbstract
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function transform(ProductUserRelation $product)
    {
        $erp_product = $product->ProductsModel;

        return [
            'id' => $product->id,
            'product_id' => $erp_product->id,
            'number' => $erp_product->number,
            'name' => $erp_product->title,
            'price' => sprintf("%0.2f", $product->price) ? sprintf("%0.2f", $product->price) : $erp_product->cost_price,
            'inventory' => $product->stock ? $product->stock : $erp_product->inventory,
            'image' => $erp_product->middle_img,
            'status' => $product->isCooperation($this->user_id),
        ];
    }


}