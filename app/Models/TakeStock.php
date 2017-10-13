<?php

namespace App\Models;

/**
 * 库存盘点记录
 *
 * Class TakeStock
 * @package App\Models
 */
class TakeStock extends BaseModel
{
    protected $table = 'take_stock';

    /**
     * 相对关联Storage表
     */
    public function Storage()
    {
        return $this->belongsTo('App\Models\StorageModel', 'storage_id');
    }

    //相对关联user表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }


}