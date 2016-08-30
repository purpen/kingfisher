<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;  
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class UserModel extends Model implements AuthenticatableContract, CanResetPasswordContract {  
    
    use Authenticatable, Authorizable, CanResetPassword, EntrustUserTrait{
        EntrustUserTrait::can as may;
        Authorizable::can insteadof EntrustUserTrait;

    }
    
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account', 'phone', 'email', 'realname', 'position',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * 设置用户头像地址
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusValAttribute()
    {
        return $this->attributes['status'] ? '已审核' : '未审核';
    }
    
    //一对多关联采购表
    public function purchases(){
        return $this->hasMany('App\Models\PurchasesModel','user_id');
    }

    //一对多关联采购表
    public function returned(){
        return $this->hasMany('App\Models\ReturnedPurchasesModel','user_id');
    }
    
    //一对多关联入库表
    public function enterWarehouses(){
        return $this->hasMany('App\Models\EnterWarehousesModel','user_id');
    }

    //一对多关联出库表
    public function outWarehouses(){
        return $this->hasMany('App\Models\OutWarehousesModel','user_id');
    }

    //一对多关联调拨表
    public function changeWarehouse(){
        return $this->hasMany('App\Models\changeWarehouseModel','user_id');
    }

    /**
     * 一对多关联order 订单表
     */
    public function order(){
        return $this->hasMany('App\Models\OrderModel','user_id');
    }

    /**
     * 一对多关联payment_order 付款表
     */
    public function paymentOrder(){
        return $this->hasMany('App\Models\PaymentOrderModel','user_id');
    }

    /**
     * 一对多关联receive_order 付款表
     */
    public function receiveOrder(){
        return $this->hasMany('App\Models\ReceiveOrderModel','user_id');
    }

    /**
     * 一对多关联records 付款表
     */
    public function record(){
        return $this->hasMany('App\Models\RecordsModel','user_id');
    }
}
