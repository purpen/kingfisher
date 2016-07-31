<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnterWarehouseSkuRelationModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'enter_warehouse_sku_relation';
    
    public static function boot(){
        parent::boot();
        self::updated(function($enter_sku){
            $enter_warehouse_id = $enter_sku->enter_warehouse_id;
            $sku_id = $enter_sku->sku_id;
            $original = $enter_sku->original;
            $getDirty = $enter_sku->getDirty();
            $count = $getDirty['in_count'] - $original['in_count'];
            $storage_id = EnterWarehousesModel::find($enter_warehouse_id)->storage_id;
            
            //SKU 入库
            $storage_sku_model = new StorageSkuCountModel();
            $storage_sku_model->enter($storage_id, $sku_id, $count);
        });
    }
}
