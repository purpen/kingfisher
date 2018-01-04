<?php
/**
 * 购物车表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'cart';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['product_id','product_number','sku_id','sku_number','user_id','channel_id','type','price','code','status','n'];

    /**
     * 相对关联到product表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){
        return $this->belongsTo('App\Models\ProductsModel', 'product_id');
    }

    /**
     * 相对关联到sku表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku(){
        return $this->belongsTo('App\Models\ProductsSkuModel', 'sku_id');
    }

}
