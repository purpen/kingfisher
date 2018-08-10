<?php

namespace App\Http\SaasTransformers;

use App\Models\ProductsModel;
use App\Models\ProductUserRelation;
use League\Fractal\TransformerAbstract;

/**
 * 推荐列表
 *
 * Class ProductListsTransformer
 * @package App\Http\SaasTransformers
 */
class SupplierProductListsTransformer extends TransformerAbstract
{
    public function transform(ProductsModel $product)
    {

        return [
            'id' => $product->id,
            'number' => $product->number,
            'name' => $product->title,
            'price' => $product->price ? sprintf("%0.2f", $product->price) : $product->cost_price,
            'inventory' => $product->stock ? $product->stock : $product->inventory,
            'image' => $product->saas_img,
        ];
    }


}