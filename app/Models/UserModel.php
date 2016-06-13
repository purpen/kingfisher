<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class UserModel extends Model
{
    use EntrustUserTrait; // add this trait to your user model
    
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'users';
}
