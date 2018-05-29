<?php
//代发供货商收款单表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentReceiptOrderDetailModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'payment_receipt_order_detail';

    /**
     * 相对关联收款单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public  function receiveOrder(){
        return $this->belongsTo('App\Models\ReceiveOrderModel','target_id');
    }

    /**
     * 一对一关联收款单
     */
    public function receiveOrderModel()
    {
        return $this->hasOne('App\Models\ReceiveOrderModel', 'target_id');
    }


    /**
     * 一对一关联sku
     */
    public function orderSkuRelationModel()
    {
        return $this->hasOne('App\Models\OrderSkuRelationModel', 'sku_id');
    }

    /**
     * 相对关联收款单
     */
    public function paymentOrderModel()
    {
        return $this->belongsTo('App\Models\PaymentOrderModel', 'target_id');
    }

}
