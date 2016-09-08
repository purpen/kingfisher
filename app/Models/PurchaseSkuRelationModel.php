<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseSkuRelationModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'purchase_sku_relation';

    //相对关联sku表
    public function productsSku()
    {
        return $this->belongsTo('App\Models\ProductsSkuModel','sku_id');
    }

    //订单单项实际付款pay_money
    public function getPayMoneyAttribute()
    {
        return ($this->quantity * $this->price - $this->discount);
    }
}
