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

    //供应商列表
    public function lists(){
        $suppliers = self::select('id','name')->get();
        return $suppliers;
    }

    /**
     * 商品分类一对多远程关联sku
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     *
     */
    public function productsSku(){
        return $this->hasManyThrough('App\Models\ProductsSkuModel', 'App\Models\ProductsModel','supplier_id','product_id');
    }

    //一对多关联采购订单
    public function purchases(){
        return $this->hasMany('App\Models\PurchasesModel','supplier_id');
    }

    //一对多关联采购退货订单
    public function returned(){
        return $this->hasMany('App\Models\ReturnedPurchasesModel','supplier_id');
    }

}
