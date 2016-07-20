<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ReturnedPurchasesModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'returned_purchases';

    //相对关联仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联供应商表
    public function supplier(){
        return $this->belongsTo('App\Models\SupplierModel','supplier_id');
    }

    //相对关联用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }
}
