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

    protected $appends = ['type_val'];

    protected $dates = ['deleted_at'];

    protected $table = 'membership';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['account', 'username', 'email', 'phone', 'from_to', 'store_id','type', 'level', 'sex', 'qq', 'ww'];
    
    
    public function getTypeValAttribute()
    {
        $result = '';
        switch ($this->type){
            case 1:
                $result = '普通订单';
                break;
            case 2:
                $result = '渠道订单';
                break;
            case 3:
                $result = '电商订单';
                break;
            case 4:
                $result = '海外订单';
                break;
        }
        return $result;
    }

}

;