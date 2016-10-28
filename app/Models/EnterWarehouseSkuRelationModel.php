<?php
/**
 * 入库单明细
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnterWarehouseSkuRelationModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     *   id
     *   enter_warehouse_id
     *   sku_id
     *   count
     *   in_count
     *   created_at,updated_at
     * @var string
     */
    protected $table = 'enter_warehouse_sku_relation';
    
    
    public static function boot(){
        parent::boot();
        self::updated(function($enter_sku){
//            $enter_warehouse_id = $enter_sku->enter_warehouse_id;
//            $original = $enter_sku->original;
//            $getDirty = $enter_sku->getDirty();

           

        });
    }
}
