<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ProductsTransformer extends TransformerAbstract
{
    public function transform($sku_list)
    {
        return [
            'count' => $sku_list->count,
            'sku_number' => $sku_list->productsSku ? $sku_list->productsSku->number : '',
            'product_title' => $sku_list->product ? $sku_list->product->title : '',
            'mode' => $sku_list->productsSku ? $sku_list->productsSku->mode : '',
            'price' => $sku_list->productsSku ? $sku_list->productsSku->price : '',
            'sale_money' =>$sku_list->sale_money,
        ];
    }
}
