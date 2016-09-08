<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class OrderModel extends BaseModel
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
    protected $fillable = ['type', 'store_id', 'payment_type', 'outside_target_id', 'express_id', 'freight','buyer_summary', 'seller_summary', 'buyer_name', 'buyer_phone', 'buyer_tel', 'buyer_zip', 'buyer_address', 'user_id', 'status', 'total_money', 'discount_money', 'pay_money','number','count','storage_id'];

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

    //相对关联到仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联调拨表
    public function outWarehouses(){
        return $this->hasOne('App\Models\OutWarehousesModel','target_id');
    }

    //一对一关联收款单表
    public function receiveOrder(){
        return $this->hasOne('App\Models\ReceiveOrderModel','target_id');
    }

    /**
     * 订单状态status 访问修改器   状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @param $value
     * @return string
     */
    public function getStatusValAttribute()
    {
        switch ($this->status){
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

    /**
     * 付款类型方位修改器
     * @param $key
     * @return string
     */
    public function getPaymentTypeAttribute($key)
    {
        switch ($key){
            case 1:
                $value = '在线付款';
                break;
            case 2:
                $value = '货到付款';
                break;
            default:
                $value = '在线付款';
        }
        return $value;
    }

    /**
     * 修改订单状态
     * @param $order_id
     * @param $status
     * @return bool
     */
    public function changeStatus($order_id,$status){
        $order_id = (int)$order_id;

        $status_arr = [0,1,5,8,10,20];
        if(!in_array($status, $status_arr)){
            return false;
        }

        if(empty($order_id)){
            return false;
        }
        if(!$order_model = self::find($order_id)){
            return false;
        }
        $order_model->status = $status;
        if(!$order_model->save()){
            return false;
        }
        return true;
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            RecordsModel::addRecord($obj, 1, 12);
        });

        self::deleted(function ($obj)
        {
            RecordsModel::addRecord($obj, 3, 12);
        });

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            if(array_key_exists('status', $remark)){
                $status = $remark['status'];
                switch ($status){
                    case 8:
                        RecordsModel::addRecord($obj, 4, 12);
                        break;
                    case 5:
                        RecordsModel::addRecord($obj, 5, 12);
                        break;
                    case 10:
                        RecordsModel::addRecord($obj, 6, 12);
                        break;
                }
            }else{
                RecordsModel::addRecord($obj, 2, 12,$remark);
            }

        });
    }
}
