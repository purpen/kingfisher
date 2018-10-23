<?php
/**
 * 采购入库表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasingWarehousingModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'purchasing_warehousing';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['number','sku_id','storage_id','user_id','purchases_id','department','storage_time'];

    /**
     * 相对关联到purchase表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase(){
        return $this->belongsTo('App\Models\PurchaseModel', 'purchases_id');
    }

//    /**
//     * 相对关联到sku表
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function sku(){
//        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
//    }


}
