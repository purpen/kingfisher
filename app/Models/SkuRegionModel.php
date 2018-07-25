<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class SkuRegionModel extends BaseModel{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'sku_region';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['sku_id','min','max','sell_price','user_id'];


    /**
     * 相对关联到product表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\ProductsModel', 'sku_id');//对应products_sku表的id
    }
}