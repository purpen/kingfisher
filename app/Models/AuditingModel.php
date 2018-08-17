<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AddressModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到收货地址表
     * @var string
     */
    protected $table = 'auditing';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['type','user_id','status'];



    /**
     * 相对关联user表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }
}
