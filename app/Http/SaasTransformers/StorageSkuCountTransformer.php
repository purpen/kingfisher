<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class StorageSkuCountTransformer extends TransformerAbstract
{
    public function transform($storageSkuCounts)
    {
        return [
            'product_number' => $storageSkuCounts->product_number,
            'sku_number' => $storageSkuCounts->productsSku ? $storageSkuCounts->productsSku->number : '',
            'product_title' => $storageSkuCounts->Products ? $storageSkuCounts->Products->title : '',
            'mode' => $storageSkuCounts->productsSku ? $storageSkuCounts->productsSku->mode : '',
            'price' => $storageSkuCounts->productsSku ? $storageSkuCounts->productsSku->price : '',
            'Storage_name' => $storageSkuCounts->Storage ? $storageSkuCounts->Storage->name : '',
            'count' =>$storageSkuCounts->count,
            'sale_money' =>$storageSkuCounts->count * ($storageSkuCounts->ProductsSku ? $storageSkuCounts->ProductsSku->cost_price : 0),
        ];
    }
}
