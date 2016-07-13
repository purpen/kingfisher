<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SupplierModel extends Model
{
    use SoftDeletes;

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'suppliers';

    //软删除属性
    protected $dates = ['deleted_at'];
    
    /**
     * 允许批量赋值的字段
     */
    protected  $fillable = ['name','address','legal_person','tel','contact_user','contact_number','contact_email','contact_qq','contact_wx','summary'];

    public function lists(){
        $suppliers = self::select('id','name')->get();
        return $suppliers;
    }

    /**
     * 查询商品分类下的sku
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     *
     */
    public function productsSku(){
        return $this->hasManyThrough('App\Models\ProductsSkuModel', 'App\Models\ProductsModel','supplier_id','product_id');
    }

}
