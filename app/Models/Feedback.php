<?php

namespace App\Models;

class Feedback extends BaseModel
{
    protected $table = 'feedback';

    // 一对多相对关联用户表
    public function User()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

}
