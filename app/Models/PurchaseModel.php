<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PurchaseModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'purchases';

    /**
     * 根据数组对象中的相关id,为对象添加 仓库/供货商/用户名;
     * @param $lists
     * @return mixed
     */
    public function lists($lists){
        foreach ($lists as $list){
            $list->supplier = $list->supplier->name;
            $list->storage = $list->storage->name;
            $list->user = $list->user->realname;
        }
        return $lists;
    }

    //相对关联供应商表
    public function supplier(){
        return $this->belongsTo('App\Models\SupplierModel','supplier_id');
    }

    //相对关联仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }
}
