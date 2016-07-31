<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangeWraehouseModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'change_warehouse';

    //相对关联仓库表
    public function storage()
    {
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联用户表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //一对一关联入库表
    public function enterWarehouses()
    {
        return $this->hasOne('App\Models\EnterWarehousesModel','target_id');
    }

    /**调拨单出库状态
     * @param $value
     * @return string
     */
    public function getStorageStatusAttribute($value)
    {
        switch ($value){
            case 1:
                $value = '未开始';
                break;
            case 2:
                $value = '调拨中';
                break;
            case 5:
                $value = '调拨完成';
                break;
        }
        return $value;
    }
}
