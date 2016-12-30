<?php
/**
 * 付款单
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
                $result = '订单退换货';
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
                $target_number = '订单退换货';
                break;
            default:
                $target_number = '';
        }
        return $target_number;
    }

}
