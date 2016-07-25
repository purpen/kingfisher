<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnterWarehousesModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'enter_warehouses';
    
    //相对关联用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //相对关联仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联采购订单表
    public function purchase(){
        return $this->belongsTo('App\Models\PurchaseModel','target_id');
    }

    /**
     * 入库单入库状态修改
     * @return bool
     */
    public function setStorageStatus(){
        $status = false;
        if($this->in_count !== 0){
            if($this->count === $this->in_count){
                $this->storage_status = 5;
                if($this->save()){
                    $status = true;
                }
            }else{
                $this->storage_status = 1;
                if($this->save()){
                    $status = true;
                }
            }
        }else{
            $status = true;
        }
        return $status;
    }
}
