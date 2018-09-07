<?php
/**
 * 进货单表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'receipt';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['product_id','sku_id','user_id','price','status','number'];

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
