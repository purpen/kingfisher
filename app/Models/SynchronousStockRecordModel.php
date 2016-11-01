<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SynchronousStockRecordModel extends Model
{
    protected $table = 'synchronous_stock_record';

    /**
     * 相对关联到User用户表
     */
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    
    public function getStatusValAttribute()
    {
        $val = '';
        switch ($this->status){
            case 1:
                $val = '正在同步';
                break;
            case 2:
                $val = '同步完成';
                break;
        }
        return $val;
    }
}
