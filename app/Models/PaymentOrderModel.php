<?php
/**
 * 付款单
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PaymentOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'payment_order';

    /**
     * 相对关联user表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    /**
     * 相对关联采购单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public  function purchase(){
        return $this->belongsTo('App\Models\PurchaseModel','target_id');
    }

    /**
     * 相对关联售后单
     */
    public function refundMoneyOrder()
    {
        return $this->belongsTo('App\Models\RefundMoneyOrderModel','target_id');
    }
    
    /**
     * 更改付款单状态
     * @param int $status 更改后的状态
     * @return bool
     */
    public function changeStatus($status){
        $this->status = (int)$status;
        if(!$this->save()){
            return false;
        }
        return true;
    }

    /**
     * 付款单类型文字说明 
     *
     * @return string
     */
    public function getTypeValAttribute()
    {
        $result = '';
        /*类型：1.采购单，2.订单退换货；*/
        switch ($this->type){
            case 1:
                $result = '采购单';
                break;
            case 2:
                $result = '订单退款';
                break;
            case 3:
                $result = '订单退货';
                break;
            case 5:
                $result = '贷款';
                break;
            case 6:
                $result = '服务费';
                break;
            case 7:
                $result = '差旅费';
                break;
            case 8:
                $result = '日常报销';
                break;
            case 9:
                $result = '营销费';
                break;
            default:
                $result = '';
        }

        return $result;
    }

    /**
     * 关联单号
     */
    public function getTargetNumberAttribute()
    {
        switch ($this->type){
            case 1:
                if($this->purchase){
                    $target_number = $this->purchase->number;
                }else{
                    $target_number = '';
                }
                break;
            case 2:
                if($this->refundMoneyOrder){
                    $target_number = $this->refundMoneyOrder->number;
                }else{
                    $target_number = '';
                }
                break;
            case 3:
                if($this->refundMoneyOrder){
                    $target_number = $this->refundMoneyOrder->number;
                }else{
                    $target_number = '';
                }
                break;
            default:
                $target_number = '';
        }
        return $target_number;
    }

    /**
     * 退款、退货售后单生成付款单
     *
     * @param $refund_order_id
     * @return bool
     */
    public function refundOrderCreatePaymentOrder($refund_order_id){
        $refund_order = RefundMoneyOrderModel::find($refund_order_id);
        if(!$refund_order){
            return false;
        }

        $paymentOrder = new PaymentOrderModel();

        $paymentOrder->amount = $refund_order->amount;
        $paymentOrder->receive_user = $refund_order->out_buyer_name;
        switch ($refund_order->type){
            case 1:
                $paymentOrder->type = 2;
                break;
            case 2:
                $paymentOrder->type = 3;
                break;
            default:
                return false;
        }
        $paymentOrder->status = 1;
        $paymentOrder->target_id = $refund_order_id;
        $paymentOrder->user_id = Auth::user()?Auth::user()->id:0;
        $number = CountersModel::get_number('FK');
        if($number == false){
            return false;
        }
        $paymentOrder->number = $number;
        if(!$paymentOrder->save()){
            return false;
        }else{
            return true;
        }
    }
}
