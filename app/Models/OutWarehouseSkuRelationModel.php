<?php
/**
 * 出库单明细
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutWarehouseSkuRelationModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];



    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'out_warehouse_sku_relation';

    /**
     * 相对关联到出库单表
     */
    public function outWarehouse()
    {
        return $this->belongsTo('App\Models\OutWarehousesModel', 'out_warehouse_id');
    }

    public static function boot(){
        parent::boot();

    }
}
