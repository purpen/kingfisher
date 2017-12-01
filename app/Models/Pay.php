<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Pay extends BaseModel
{
    protected $table = 'pays';

    protected $fillable = ['uid', 'user_id', 'pay_type' , 'summary', 'amount', 'bank_id' , 'order_id' , 'status' , 'pay_no'];

    //一对一相对关联用户表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }
}
