<?php
/**
 * 订单明细
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderSkuRelationModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'order_sku_relation';

    //属性转换
    protected $casts = [
        'status' => 'integer'
    ];

    //相对关联订单表Order
    public function order()
    {
        return $this->belongsTo('App\Models\OrderModel','order_id');
    }

    /**
     * 相对关联到product表
     */
    public function product()
    {
        return $this->belongsTo('App\Models\ProductsModel', 'product_id');
    }
    
    /**
     * 相对关联到productSku表
     */
    public function productsSku()
    {
        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
    }
}
