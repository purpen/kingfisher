<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    protected $table = 'order_users';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['account', 'username', 'email', 'phone', 'from_to', 'store_id','type', 'level', 'sex', 'qq', 'ww' , 'random_id'];
    
    
    public function getTypeValAttribute($key)
    {
        $result = '';
        switch ($this->type){
            case 1:
                $result = '电商';
                break;
            case 2:
                $result = '渠道';
                break;
        }
        return $result;
    }
    
}
