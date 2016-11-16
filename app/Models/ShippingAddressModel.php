<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ShippingAddressModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'shipping_address';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [ 'buyer_address','buyer_province','buyer_city','buyer_county','order_user_id'];


    /**
     * 相对关联到商铺表
     */
    public function orderUser()
    {
        return $this->belongsTo('App\Models\OrderUserModel', 'order_user_id');
    }
}
