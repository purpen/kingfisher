<?php
/**
 * 用户表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class UserModel extends Model implements AuthenticatableContract,
                                        CanResetPasswordContract
{
    // User模型中添加roles()、hasRole($name)、can($permission)
    // 以及ability($roles,$permissions,$options)方法
    use Authenticatable, CanResetPassword, EntrustUserTrait;
    
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['cover'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account', 'phone', 'email', 'realname', 'position', 'status', 'sex' ,'cover_id'
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

    /*
     * 一对一
     */
    public function userRole()
    {
        return $this->hasOne('App\Models\UserRoleModel','user_id');
    }

    /**
     * 一对多关联 SynchronousStock 同步记录表
     */
    public function synchronousStock()
    {
        return $this->hasMany('App\Models\SynchronousStockModel', 'user_id');
    }
    
    /**
     * 一对多关联assets表单
     */
    public function assets(){
        return $this->belongsTo('App\Models\AssetsModel','cover_id');
    }
    
    /**
     * 获取原文件及封面图
     */
    public function getCoverAttribute()
    {
        if ($this->assets()->count()) {
            return $this->assets()->orderBy('created_at', 'desc')->first();
        }
        
        return null;
    }

    /**
     * status 约束
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', (int)$status);
    }

    /**
     * 用户部门
     */
    public function getDepartmentValAttribute()
    {
        switch ($this->department){
            case 0:
                $department = '';
                break;
            case 1:
                $department = 'fiu';
                break;
            case 2:
                $department = 'D3IN';
                break;
            case 3:
                $department = '海外';
                break;
            case 4:
                $department = '电商';
                break;
            default:
                $department = '';
        }
        return $department;
    }
}
