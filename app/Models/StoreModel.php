<?php
/**
 * 店铺表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreModel extends BaseModel
{
    use SoftDeletes;
    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'stores';

    /*软删除设置*/
    protected  $datas = ['deleted_at'];

    /**
     * 可被批量赋值字段
     * @var array
     */
    protected $fillable = ['name','number','target_id','outside_info','type','status','user_id','summary','contact_user','contact_number'];

    /**
     * 一对多关联order 订单表
     */
    public function order()
    {
        return $this->hasMany('App\Models\OrderModel','store_id');
    }

    /**
     * 一对多关联paymentAccount表
     */
    public function paymentAccount()
    {
        return $this->hasMany('App\Models\PaymentAccountModel','store_id');
    }

    /**
     * 一对多关联RefundMoneyOrder表
     */
    public function refundMoneyOrder()
    {
        return $this->hasMany('App\Models\RefundMoneyOrderModel','store_id');

    }

    /**
     * 一对一关联storeStorageLogistic表
     */
    public function storeStorageLogistic()
    {
        return $this->hasOne('App\Models\StoreStorageLogisticModel','store_id');
    }

    /**
     * 获取平台店铺的授权token 集合
     *
     * @param integer $platform 平台代码
     */
    public function getToken($platform)
    {
        $tokens = StoreModel::where('platform',$platform)->select('access_token')->get();
        return $tokens;
    }
}
