<?php

namespace App\Models;

/**
 * sku唯一标识表
 *
 * Class SkuUniqueModel
 * @package App\Models
 */
class SkuUniqueModel extends BaseModel
{
    protected $table = 'sku_unique';

    protected $dates = ['deleted_at'];

    /**
     * 相对关联Storage表
     */
    public function Storage()
    {
        return $this->belongsTo('App\Models\StorageModel', 'storage_id');
    }

    //相对关联sku表
    public function productSku()
    {
        return $this->belongsTo('App\Models\ProductSkuModel', 'sku_id');
    }

    //相对关联purchase表
    public function purchase()
    {
        return $this->belongsTo('App\Models\PurchaseModel', 'purchase_id');
    }


}