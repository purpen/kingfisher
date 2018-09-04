<?php

namespace App\Http\DealerTransformers;

use App\Models\ProductsModel;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{

    public function transform(ProductsModel $product)
    {
        $skus = $product->productsSku;
        $all=[];
        foreach ($skus as $sku){
            $sku_region=$sku->SkuRegion;
            if ($sku_region->isEmpty()){
                continue;
            }
            $sku_region_array = [];

            foreach ($sku_region as $value) {
                $sku_region_array[] = [
                    'id' => $value['id'],
                    'user_id' => $value['user_id'],
                    'sku_id' => $value['sku_id'],
                    'min' => $value['min'],
                    'max' => $value['max'],
                    'sell_price' => $value['sell_price'],
                ];
            }

            $all[] = [
                'sku_id' => $sku->id,
                'number' => $sku->number,
                'mode' => $sku->mode,
                'price' => $sku->price,
                'market_price' => $sku->bid_price,
//                'image' => $sku->saas_img,
                'image' => $sku->first_img,
                'inventory' => intval($sku->quantity),
                'sku_region' => $sku_region_array,
            ];
        }


//        $region = $product->sku_region;
//
//        foreach ($skus as $k=>$sku) {
//
//            $all[] = [
//                'sku_id' => $sku->id,
//                'number' => $sku->number,
//                'mode' => $sku->mode,
//                'price' => $sku->price,
//                'market_price' => $sku->bid_price,
//                'image' => $sku->first_img,
//                'inventory' => intval($sku->quantity),
////                'sku_region' => $sku_region,
//            ];
////            var_dump($all[$k]);
//            if (count($region) > 0) {
//                foreach ($region as $value) {
//                    $sku_region[] = [
//                        'id' => $value['id'],
//                        'user_id' => $value['user_id'],
//                        'sku_id' => $value['sku_id'],
//                        'min' => $value['min'],
//                        'max' => $value['max'],
//                        'sell_price' => $value['sell_price'],
//                    ];
//
//                        if ($sku->id == $value['sku_id']) {
//                            $all[$k]['sku_region'][] = $value;
//                    }
//                }
//
//            }
//        }

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
//            'image' => $product->first_img,
            'image' => $product->imag,
//            'product_details' =>$product->detial_img,
            'product_details' =>$product->product_detail,
            'follows' =>$product->follows,
            'follow' =>$product->follow,
            'skus' => $all,

        ];
    }


}