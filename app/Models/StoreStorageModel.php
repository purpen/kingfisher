<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreStorageModel extends Model
{
    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'store_storage';


    /**
     * 相对关联关联store表
     */
    public function store(){
        return $this->belongsTo('App\Models\StoreModel','store_id');
    }

    /**
     * 相对关联关联storage表
     */
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }
}
