<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchasesInterimModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'purchases_interim';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = [
        'purchase_sku_relation_id',
        'department_name',
        'product_title',
        'supplier_name',
        'order_start_time',
        'quantity',
        'purchases_price',
        'total_money',
        'payment_price',
        'purchases_time',
        'invoice_start_time',
        'payment_time',
        'summary'
    ];

}
