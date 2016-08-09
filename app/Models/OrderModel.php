<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'order';

    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['type', 'store_id', 'payment_type', 'outside_target_id', 'express_id', 'freight', 'seller_summary', 'buyer_name', 'buyer_phone', 'buyer_tel', 'buyer_zip', 'buyer_address', 'user_id', 'status', 'total_money', 'discount_money', 'pay_money',];

    //相对关联到商铺表
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

    //相对关联到user用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //相对关联到物流表
    public function logistics(){
        return $this->belongsTo('App\Models\LogisticsModel','express_id');
    }
}
