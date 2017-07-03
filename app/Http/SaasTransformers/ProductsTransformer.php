<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class ProductsTransformer extends TransformerAbstract
{
    public function transform($product)
    {
        $erp_product = $product->ProductsModel;
        return [
            'id' => $product->id,
            'product_id' => $erp_product->id,
            'number' => $erp_product->number,
            'category' => $erp_product->CategoriesModel ? $erp_product->CategoriesModel->title : '',
            'name' => $erp_product->title,
            'short_name' => $erp_product->tit,
            'price' => sprintf("%0.2f", $product->price) ? sprintf("%0.2f", $product->price) : $erp_product->cost_price,
            'weight' => $erp_product->weight,
            'summary' => $erp_product->summary,
            'inventory' => $product->stock ? $product->stock : $erp_product->inventory,
            'image' => $erp_product->first_img,
            'skus' => $this->sku($product),
        ];
    }

    protected function sku($product)
    {
        $all = [];
        $skus = $product->ProductSkuRelation;
        foreach ($skus as $sku){
            $erp_sku = $sku->ProductsSkuModel;
           $all[] = [
               'sku_id' => $erp_sku->id,
               'number' => $erp_sku->number,
               'mode' => $erp_sku->mode,
               'price' => sprintf("%0.2f", $sku->price) ? sprintf("%0.2f", $sku->price) : $erp_sku->cost_price,
           ];
        }

        return $all;
    }
}
