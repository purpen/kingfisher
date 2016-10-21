<?php
/**
 * 退货单
 */
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class RefundGoodsOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'refund_goods_order';
}
