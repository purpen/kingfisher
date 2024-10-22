<?php
/**
 * 调拨单明细表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangeWarehouseSkuRelationModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'change_warehouse_sku_relation';

    /**
     * 相对关联sku表
     */
    public function productSku()
    {
        return $this->belongsTo('App\Models\ProductsSkuModel','sku_id');
    }
    
}
