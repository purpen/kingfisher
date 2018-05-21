<?php
//代发供货商收款单表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentReceiptOrderDetailModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'payment_receipt_order_detail';
}
