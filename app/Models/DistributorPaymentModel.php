<?php
//代发渠道付款单表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributorPaymentModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'distributor_payment';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = ['number', 'distributor_user_id', 'start_time', 'end_time', 'price', 'user_id', 'status'];


//    相对关联到分销商(user表)
    public function user(){

        return $this->belongsTo('App\Models\UserModel','distributor_user_id');
    }

    public function PaymentReceiptOrderDetail(){
        return $this->hasMany('App\Models\PaymentReceiptOrderDetailModel','target_id');
    }
    //一对多关联order sku
    public function OrderSkuRelationModel(){
        return $this->hasMany('App\Models\OrderSkuRelationModel','distributor_payment_id');
    }


    /**
     * 审核状态访问设置
     * 0.关联人；1.待负责人确认 2.待分销商确认 3.待确认收款 4.完成
     */
    public function getReceiptStatusValAttribute()
    {
        switch ($this->status){
//            case 0:
//                $status = '默认';
//                break;
            case 1:
                $status = '待负责人确认';
                break;
            case 2:
                $status = '待分销商确认';
                break;
            case 3:
                $status = '待确认付款';
                break;
            case 4:
                $status = '完成';
                break;
            default:
                $status = '默认';
        }

        return $status;
    }


    /**
     * 代收分销商付款单审核通过状态修改
     * @param int $id  '代收分销商付款单id'
     * @param int $verified  ‘审核状态’
     * @return null|string
     */
    public function changeStatus($id,$status)
    {
        $id = (int) $id;
        switch ($status){
//                case 0:
//                    $status = 1;
//                    break;
            case 1:
                $status = 2;
                break;
            case 2:
                $status = 3;
                break;
            case 3:
                $status = 4;
                break;
        }
        $distributorPayment = DistributorPaymentModel::find($id);
        $distributorPayment->status = $status;
        $res = $distributorPayment->save();
        return $res;
    }






}
