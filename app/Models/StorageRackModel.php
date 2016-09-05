<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StorageRackModel extends BaseModel
{
    use SoftDeletes;
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'storage_racks';

    /**
     *软删除
     */
    protected $dates = ['deleted_at'];

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','content','type','user_id','status','storage_id'];

    /**
     * 相对关联Storage表
     */
    public function Storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    /**
     * 相对关联StorageSkuCount表
     */
    public function storage_Rack(){
        return $this->belongsTo('App\Models\StorageSkuCountModel','storage_id');
    }


    /**
     *
     * 一对多关联rack_place表
     *
     */
    public function StorageRack(){
        return $this->hasMany('App\Models\RackPlaceModel','storage_rack_id');
    }
    /**
     * 仓区列表
     *
     * @param  $storage_id integer
     * @return $list array
     */
    static public function storageRackList($storage_id)
    {
        $list = self::where('storage_id',$storage_id)->select('id','name','storage_id')->get();
        return $list;
    }

    public static function boot(){
        parent::boot();
        self::created(function ($obj){
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 1, 3,$remark);
        });

        self::updated(function ($obj){
            $remark = $obj->getDirty();

            RecordsModel::addRecord($obj, 2, 3,$remark);
        });

        self::deleted(function ($obj){
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 3, 3,$remark);
        });
    }
}