<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;  
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;  
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class UserModel extends Model implements AuthenticatableContract, CanResetPasswordContract {  
    
    use Authenticatable, CanResetPassword, EntrustUserTrait;
    
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account', 'phone', 'email', 'realname', 'position',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * 设置用户头像地址
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusValAttribute()
    {
        return $this->attributes['status'] ? '已审核' : '未审核';
    }
}
