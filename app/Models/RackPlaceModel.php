<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RackPlaceModel extends BaseModel
{
    use SoftDeletes;
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'rack_place';

    /**
     *软删除
     */
    protected $dates = ['deleted_at'];

    /**
     * 相对关联库区表
     */
    public function StorageRack(){
        return $this->belongsTo('App\Models\StorageRackModel','storage_rack_id');
    }

    /**
     *
     * 相对关联库位表
     *
     */
    public function StoragePlace(){
        return $this->belongsTo('App\Models\StoragePlaceModel','storage_place_id');
    }

    /**
     * 相对关联storage_sku_count表
     */
    public function StorageSkuCount(){
        return $this->belongsTo('App\Models\StorageSkuCountModel','storage_sku_count_id');
    }
}