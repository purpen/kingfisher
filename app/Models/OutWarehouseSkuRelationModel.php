<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutWarehouseSkuRelationModel extends Model
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
            $out_warehouse_id = $out_sku->out_warehouse_id;
            $sku_id = $out_sku->sku_id;
            $original = $out_sku->original;   //未更新前的数据对象
            $getDirty = $out_sku->getDirty(); //有更改的字段
            $count = $getDirty['out_count'] - $original['out_count'];
            $storage_id = OutWarehousesModel::find($out_warehouse_id)->storage_id;

            //SKU 入库
            $storage_sku_model = new StorageSkuCountModel();
            $storage_sku_model->out($storage_id, $sku_id, $count);
        });
    }
}
