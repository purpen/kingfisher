<?php
namespace App\Models;

class ProductUserRelation extends BaseModel
{
    protected $table = 'product_user_relation';

    protected $fillable = ['product_id', 'user_id'];

    /**
     * 一对多关联ProductSkuRelation表单
     */
    public function ProductSkuRelation()
    {
        return $this->hasMany('App\Models\ProductSkuRelation', 'product_user_relation_id');
    }

    /**
     * 相对一对多关联user单
     */
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    public function ProductsModel(){
        return $this->belongsTo('App\Models\ProductsModel', 'product_id');
    }


}