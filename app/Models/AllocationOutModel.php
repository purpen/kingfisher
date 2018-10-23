<?php
/**
 * 调拨出/入库表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllocationOutModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'allocation_out';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['number','sku_id','storage_id','user_id','allocation_id','type','department','outorin_time'];

    /**
     * 相对关联到change_warehouse表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function changeWarehouse(){
        return $this->belongsTo('App\Models\ChangeWarehouseModel', 'allocation_id');
    }

//    /**
//     * 相对关联到sku表
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function sku(){
//        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
//    }


}
