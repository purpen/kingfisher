<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreLogisticModel extends Model
{
    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'store_logistic';

    /**
     * 相对关联关联store表
     */
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

    /**
     * 相对关联关联logistic表
     */
    public function logistic(){
        return $this->belongsTo('App\Models\LogisticsModel','logistic_id');
    }
}
