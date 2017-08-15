<?php

namespace App\Models;

class Distribution extends BaseModel
{
    protected $table = 'distribution';

    protected $fillable = [
        'user_id',
        'name',
        'company',
        'introduction',
        'main',
        'create_time',
        'contact_name',
        'contact_phone',
        'contact_qq',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

}
