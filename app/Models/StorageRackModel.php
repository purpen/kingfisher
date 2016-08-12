<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StorageRackModel extends Model
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
     *
     * 一对多关联仓库sku表
     *
     */
    public function StorageSkuCount(){
        return $this->hasMany('App\Models\StorageSkuCountModel','storage_rack_id');
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
}