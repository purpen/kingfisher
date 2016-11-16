<?php
/**
 * 采购退货单明细
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnedSkuRelationModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'returned_sku_relation';
    
    /**
     * 相对关联sku表
     */
    public function productSku()
    {
        $this->belongsTo('App\Models\ProductsSkuModel','sku_id');
    }
    
}
