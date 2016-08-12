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
     * 可被批量赋值的属性。
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

    /**
     * 订单状态status 访问修改器   状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @param $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        switch ($value){
            case 0:
                $status = '取消';
                break;
            case 1:
                $status = '待付款';
                break;
            case 5:
                $status = '待审核';
                break;
            case 8:
                $status = '待发货';
                break;
            case 10:
                $status = '已发货';
                break;
            case 20:
                $status = '完成';
                break;
            default:
                $status = '取消';
        }
        return $status;
    }
}
