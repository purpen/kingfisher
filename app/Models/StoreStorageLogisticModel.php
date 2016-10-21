<?php
/**
 * 店铺默认物流及仓库配置
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreStorageLogisticModel extends BaseModel
{
    use SoftDeletes;
    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'store_storage_logistics';

    /*软删除设置*/
    protected  $datas = ['deleted_at'];

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['store_id' , 'storage_id' , 'logistics_id'];

    /**
     * 相对关联关联store表
     */
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

    /**
     * 相对关联关联storage表
     */
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    /**
     * 相对关联关联logistic表
     */
    public function logistic(){
        return $this->belongsTo('App\Models\LogisticsModel','logistics_id');
    }
}
