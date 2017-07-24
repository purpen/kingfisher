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
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    public function ProductsModel(){
        return $this->belongsTo('App\Models\ProductsModel', 'product_id');
    }

    /**
     * 返回用户关联商品详情
     *
     * @param $user_id
     * @param $product_id
     * @return array|null
     */
    public function productInfo($user_id, $product_id)
    {
        $product = self::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
        if(!$product){
            return null;
        }
        $erp_product = $product->ProductsModel;
        if (!$erp_product){
            return null;
        }

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
            'image' => $erp_product->middle_img,
            'status' => (int)$product->status,
            'skus' => $all,
        ];
    }
}