<?php

namespace App\Http\MicroTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{

    public function transform(ProductsModel $product)
    {
        $all = [];
        $skus = $product->productsSku;
        foreach ($skus as $sku) {
            $all[] = [
                'sku_id' => $sku->id,
                'number' => $sku->number,
                'mode' => $sku->mode,
                'price' => $sku->price,
                'market_price' => $sku->bid_price,
                'image' => $sku->saas_img,
                'inventory' => $sku->quantity,
            ];
        }
        return [
            'id' => $product->id,
            'product_id' => $product->id,
            'number' => $product->number,
            'name' => $product->title,
            'price' => $product->cost_price,
            'inventory' => $product->inventory,
            'image' => $product->saas_img,
            'skus' => $all,
        ];
    }


}