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

    protected $appends = ['refund_status_val'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'order_sku_relation';
    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = [
        'quantity',
        'sku_id',
        'sku_number',
        'sku_name',
        'price',
        'discount',
        'status',
        'refund_status',
        'order_id',
        'channel_id',
        ];

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

    //订单明细商品售后信息
    //0:默认,1:已退款2:已退货3:已返修
    public function getRefundStatusValAttribute()
    {
        switch($this->refund_status){
            case 0:
                $value = '正常';
                break;
            case 1:
                $value = '已退款';
                break;
            case 2:
                $value = '已退货';
                break;
            case 3:
                $value = '已返修';
                break;
        }
        return $value;
    }
}
