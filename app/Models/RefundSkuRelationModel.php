<?php
/**
 * 退货订单--商品明细表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class RefundSkuRelationModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'refund_sku_relation';
}
