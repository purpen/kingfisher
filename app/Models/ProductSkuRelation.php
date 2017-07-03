<?php
namespace App\Models;

/**
 * 分发saas 用户-sku 关联表
 *
 * Class ProductSkuRelation
 * @package App\Models
 */
class ProductSkuRelation extends BaseModel
{
    protected $table = 'product_sku_relation';

    protected $fillable = ['product_user_relation_id', 'sku_id'];

    /**
     * 一对多 相对关联 ProductUserRelation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ProductUserRelation()
    {
        return $this->belongsTo('App\Models\ProductUserRelation', 'product_user_relation_id');
    }

    /**
     * 一对多相对关联 ProductsSkuModel
     *
     */
    public function ProductsSkuModel()
    {
        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
    }


}