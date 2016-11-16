<?php

namespace App\Models;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Jobs\SendOrderUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Bus\DispatchesJobs;
class OrderUserModel extends BaseModel
{
    use SoftDeletes,DispatchesJobs;

    protected $dates = ['deleted_at'];

    protected $table = 'order_users';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['account', 'username', 'email', 'phone', 'from_to', 'store_id','type', 'level', 'sex', 'qq', 'ww'];




    /**
     * 一对多关联收货地址表shipping_address
     */
    public function shippingAddress()
    {
        return $this->hasMany('App\Models\ShippingAddressModel', 'order_user_id');
    }

}
