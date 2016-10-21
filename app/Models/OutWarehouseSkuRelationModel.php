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

    public static function boot(){
        parent::boot();
        self::updated(function($out_sku){
//            $out_warehouse_id = $out_sku->out_warehouse_id;
//            $original = $out_sku->original;   //未更新前的数据对象
//            $getDirty = $out_sku->getDirty(); //有更改的字段

        });

    }
}
