<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoragePlaceModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'storage_places';

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','content','type','user_id','status','storage_rack_id'];

    //库位列表
    static public function storagePlaceList($storage_rack_id)
    {
        $list = StoragePlaceModel::where('storage_rack_id',$storage_rack_id)->select('id','name','storage_rack_id')->get();
        return $list;
    }

    /**
     *
     * 一对多关联SKU表
     *
     */
    public function StoragePlaces(){
        return $this->hasMany('App\Models\ProductsSkuModel','storage_place_id');
    }

    /**
     *
     * 一对多关联库位表
     *
     */
    public function StorageRacks(){
        return $this->hasMany('App\Models\StorageRackModel','storage_place_id');
    }

    /**
     *
     * 一对多关联rack_place表
     *
     */
    public function RackPlace(){
        return $this->hasMany('App\Models\RackPlaceModel','storage_place_id');
    }

    /**
     *
     * 相对关联库区表
     *
     */
    public function StoragePlace(){
        return $this->hasMany('App\Models\StorageRackModel','storage_place_id');
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj) {
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 1, 4, $remark);
        });

        self::updated(function ($obj) {
            $remark = $obj->getDirty();

            RecordsModel::addRecord($obj, 2, 4, $remark);
        });

        self::deleted(function ($obj) {
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 3, 4, $remark);
        });
    }
}
