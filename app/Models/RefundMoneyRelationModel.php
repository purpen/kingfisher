<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundMoneyRelationModel extends Model
{
    protected $table = 'refund_money_relation';

    //相对关联售后单
    public function RefundMoneyOrder(){
        $this->belongsTo('App\Models\RefundMoneyOrderModel','refund_money_order_id');
    }
}
