<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class receiveOrderInterimModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'receive_order_interim';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = [
        'order_sku_relation_id',
        'store_name',
        'product_title',
        'supplier_name',
        'order_type',
        'buyer_name',
        'order_start_time',
        'quantity',
        'price',
        'cost_price',
        'invoice_start_time',
        'total_money',
        'receive_time',
        'amount',
        'summary'
    ];
}
