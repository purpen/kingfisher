<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{

    public function transform(ProductsModel $product)
    {
        $all = [];
        $sku_region = [];
        $skus = $product->productsSku;
        $region = $product->sku_region;

        foreach ($skus as $k=>$sku) {
            $all[] = [
                'sku_id' => $sku->id,
                'number' => $sku->number,
                'mode' => $sku->mode,
                'price' => $sku->price,
                'market_price' => $sku->bid_price,
                'image' => $sku->first_img,
                'inventory' => intval($sku->quantity),
//                'sku_region' => $sku_region,
            ];
            if (count($region) > 0) {
                foreach ($region as $value) {
                    $sku_region[] = [
                        'id' => $value['id'],
                        'user_id' => $value['user_id'],
                        'sku_id' => $value['sku_id'],
                        'min' => $value['min'],
                        'max' => $value['max'],
                        'sell_price' => $value['sell_price'],
                    ];

                        if ($sku->id == $value['sku_id']) {
                            $all[$k]['sku_region'][] = $value;
                    }
                }

            }
        }

        return [
            'id' => $product->id,
            'product_id' => $product->id,
            'number' => $product->number,
            'category' => $product->category,
            'market_price' => $product->market_price,
            'weight' => $product->weight,
            'sales_number' => $product->sales_number,
            'name' => $product->title,
            'price' => $product->cost_price,
            'inventory' => intval($product->inventory),
            'image' => $product->saas_img,
            'skus' => $all,

        ];
    }


}