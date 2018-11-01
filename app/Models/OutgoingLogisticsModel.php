<?php
/**
 * 订单出库物流信息记录表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingLogisticsModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'outgoing_logistics';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['logistics_company','odd_numbers','order_id'];

    /**
     * 相对关联到订单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(){
        return $this->belongsTo('App\Models\OrderModel', 'order_id');
    }
    /**
     * 相对关联到物流表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function logistics(){
        return $this->belongsTo('App\Models\LogisticsModel', 'logistics_company');
    }

    /**
     * 一对多到订单出库明细表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderOut(){
        return $this->hasMany('App\Models\OrderOutModel', 'odd_numbers');
    }

//    /**
//     * 相对关联到sku表
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function sku(){
//        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
//    }


}
