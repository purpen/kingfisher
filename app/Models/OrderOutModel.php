<?php
/**
 * 订单出库表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderOutModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'order_out';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['number','sku_id','storage_id','user_id','order_id','department','outage_time','odd_numbers','unique_id'];

    /**
     * 相对关联到订单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(){
        return $this->belongsTo('App\Models\OrderModel', 'order_id');
    }
    /**
     * 相对关联到物流明细记录表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outgoingLogistics(){
        return $this->belongsTo('App\Models\OutgoingLogisticsModel', 'odd_numbers');
    }

//    /**
//     * 相对关联到sku表
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function sku(){
//        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
//    }


}
