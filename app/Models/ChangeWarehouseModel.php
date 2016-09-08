<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangeWarehouseModel extends BaseModel
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
            case 0:
                $value = '未开始';
                break;
            case 1:
                $value = '调拨中';
                break;
            case 5:
                $value = '完成';
                break;
        }
        return $value;
    }

    /**
     * 修改调拨单状态
     * @param int $id (调拨单ID)
     * @param int $verified (状态码)
     * @return bool
     */
    public function changeStatus($id,$verified){
        if(!empty($id) && is_int($id) &&!empty($verified) && is_int($verified)){
            $change_warehouse = ChangeWarehouseModel::find($id);
            $change_warehouse->verified = $verified;
            if($change_warehouse->save()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            RecordsModel::addRecord($obj, 1, 11);
        });

        self::deleted(function ($obj)
        {
            RecordsModel::addRecord($obj, 3, 11);
        });

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            if(array_key_exists('verified', $remark)){
                $verified = $remark['verified'];
                switch ($verified){
                    case 0:
                        RecordsModel::addRecord($obj, 5, 11);
                        break;
                    default:
                        RecordsModel::addRecord($obj, 4, 11);
                }
            }else{
                RecordsModel::addRecord($obj, 2, 11,$remark);
            }

        });
    }
}
