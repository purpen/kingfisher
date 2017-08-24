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


    /**
     * 分发saas sku信息详情
     *
     * @param $user_id
     * @param $sku_id
     * @return array|null
     */
    public function skuInfo($user_id, $sku_id)
    {
        $sku = self::where(['user_id' => $user_id, 'sku_id' => $sku_id])->first();
        if ($sku) {
            $erp_sku = $sku->ProductsSkuModel;
            return [
                'sku_id' => $erp_sku->id,
                'number' => $erp_sku->number,
                'mode' => $erp_sku->mode,
                'price' => sprintf("%0.2f", $sku->price) ? sprintf("%0.2f", $sku->price) : $erp_sku->cost_price,
            ];
        } else if ($erp_sku = ProductsSkuModel::find($sku_id)) {
            return [
                'sku_id' => $erp_sku->id,
                'number' => $erp_sku->number,
                'mode' => $erp_sku->mode,
                'price' => $erp_sku->cost_price,
            ];
        } else {
            return null;
        }
    }


}