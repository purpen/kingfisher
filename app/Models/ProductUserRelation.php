<?php

namespace App\Models;

class ProductUserRelation extends BaseModel
{
    protected $table = 'product_user_relation';

    protected $fillable = ['product_id', 'user_id'];

    /**
     * 一对多关联ProductSkuRelation表单
     */
    public function ProductSkuRelation()
    {
        return $this->hasMany('App\Models\ProductSkuRelation', 'product_user_relation_id');
    }

    /**
     * 相对一对多关联user单
     */
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    public function ProductsModel()
    {
        return $this->belongsTo('App\Models\ProductsModel', 'product_id');
    }

    /**
     * 返回用户关联商品及sku详情，如没有推荐关联，则返回公开的商品及sku信息
     *
     * @param $user_id
     * @param $product_id
     * @return array|null
     */
    public function productInfo($user_id, $product_id)
    {
        $product = ProductUserRelation::with('ProductSkuRelation')
            ->where(['user_id' => $user_id, 'product_id' => $product_id])
            ->first();

        if ($product) {
            return $product->relationProductInfo($user_id);
        }

        // SaaS商品基础信息
        $product = ProductUserRelation::where(['user_id' => 0, 'product_id' => $product_id])
            ->first();

        if ($product) {
            return $product->saasProductInfo($user_id);
        }

        return null;
    }

    /**
     * 返回用户关联商品详情，如没有推荐关联，则返回公开的商品信息 -- 列表用
     *
     * @param $user_id
     * @param $product_id
     * @return array|null
     */
    public function productListInfo($user_id, $product_id)
    {
        $product = ProductUserRelation::where(['user_id' => $user_id, 'product_id' => $product_id])
            ->first();
        if ($product) {
            return $product->relationProductListInfo($user_id);
        }

        // SaaS商品基础信息
        $product = ProductUserRelation::where(['user_id' => 0, 'product_id' => $product_id])
            ->first();
        if ($product) {
            return $product->saasProductListInfo($user_id);
        }
        return null;
    }

    /**
     * 用户关联商品及sku详情
     *
     * @param $user_id
     * @return array|null
     */
    public function relationProductInfo($user_id)
    {
        $erp_product = $this->ProductsModel;
        if (!$erp_product) {
            return null;
        }

        $all = [];
        $skus = $this->ProductSkuRelation;
        foreach ($skus as $sku) {
            $erp_sku = $sku->ProductsSkuModel;

            $all[] = [
                'sku_id' => $erp_sku->id,
                'number' => $erp_sku->number,
                'mode' => $erp_sku->mode,
                'price' => $sku->price ? sprintf("%0.2f", $sku->price) : $erp_sku->saasSkuInfo()->price,
                'market_price' => $erp_sku->bid_price,
                'image' => $erp_sku->saas_img,
                'inventory' => $sku->quantity,
            ];
        }

        return [
            'id' => $this->id,
            'product_id' => $erp_product->id,
            'number' => $erp_product->number,
            'category' => $erp_product->CategoriesModel ? $erp_product->CategoriesModel->title : '',
            'name' => $erp_product->title,
            'short_name' => $erp_product->tit,
            'price' => $this->price ? sprintf("%0.2f", $this->price) : $erp_product->saasInfo()->price,
            'market_price' => $erp_product->market_price,
            'weight' => $erp_product->weight,
            'summary' => $erp_product->summary,
            'inventory' => $this->stock ? $this->stock : $erp_product->inventory,
            'image' => $erp_product->saas_img,
            'status' => $this->isCooperation($user_id),
            'skus' => $all,
            'slaes_number' => $erp_product->slaes_number,
        ];
    }


    /**
     * 获取SaaS商品及下属sku基础信息
     *
     * @param $user_id
     * @return array
     */
    public function saasProductInfo($user_id)
    {
        $erp_product = $this->ProductsModel;

        $all = [];
        $skus = $erp_product->productsSku;
        foreach ($skus as $sku) {
            $all[] = [
                'sku_id' => $sku->id,
                'number' => $sku->number,
                'mode' => $sku->mode,
                'price' => $sku->saasSkuInfo() ? $sku->saasSkuInfo()->price : 0,
                'market_price' => $sku->bid_price,
                'image' => $sku->saas_img,
                'inventory' => $sku->quantity,
            ];
        }

        return [
            'id' => $erp_product->id,
            'product_id' => $erp_product->id,
            'number' => $erp_product->number,
            'category' => $erp_product->CategoriesModel ? $erp_product->CategoriesModel->title : '',
            'name' => $erp_product->title,
            'short_name' => $erp_product->tit,
            'price' => $erp_product->saasInfo()->price,
            'market_price' => $erp_product->market_price,
            'weight' => $erp_product->weight,
            'summary' => $erp_product->summary,
            'inventory' => $erp_product->inventory,
            'image' => $erp_product->saas_img,
            'status' => $erp_product->isCooperation($user_id), //是否合作
            'skus' => $all,
            'slaes_number' => $erp_product->slaes_number,
        ];
    }


    /**
     * 用户关联商品列表详情
     *
     * @param $user_id
     * @return array|null
     */
    public function relationProductListInfo($user_id)
    {
        $erp_product = $this->ProductsModel;

        if (!$erp_product) {
            return null;
        }

        return [
            'id' => $this->id,
            'product_id' => $erp_product->id,
            'number' => $erp_product->number,
            'category' => $erp_product->CategoriesModel ? $erp_product->CategoriesModel->title : '',
            'name' => $erp_product->title,
            'short_name' => $erp_product->tit,
            'price' => $this->price ? sprintf("%0.2f", $this->price) : $erp_product->saasInfo()->price,
            'weight' => $erp_product->weight,
            'summary' => $erp_product->summary,
            'inventory' => $this->stock ? $this->stock : $erp_product->inventory,
            'image' => $erp_product->saas_img,
            'status' => $this->isCooperation($user_id),
        ];
    }

    /**
     * 获取SaaS公开的商品列表展示信息
     *
     * @param $user_id
     * @return array
     */
    public function saasProductListInfo($user_id)
    {
        $erp_product = $this->ProductsModel;

        return [
            'id' => $erp_product->id,
            'product_id' => $erp_product->id,
            'number' => $erp_product->number,
            'category' => $erp_product->CategoriesModel ? $erp_product->CategoriesModel->title : '',
            'name' => $erp_product->title,
            'short_name' => $erp_product->tit,
            'price' => $erp_product->saasInfo()->price,
            'weight' => $erp_product->weight,
            'summary' => $erp_product->summary,
            'inventory' => $erp_product->inventory,
            'image' => $erp_product->saas_img,
            'status' => $erp_product->isCooperation($user_id), //是否合作
        ];
    }

    /**
     * 判断SaaS商品是否与请求的用户合作
     *
     * @param $user_id
     * @return bool
     */
    public function isCooperation($user_id)
    {
        return (int)CooperationRelation::isCooperation($user_id, $this->product_id);
    }

}