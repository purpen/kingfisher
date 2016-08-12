<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoragePlaceModel extends Model
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


}
