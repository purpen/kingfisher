<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class UserRoleModel extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'role_user';

    /**
     * 允许批量赋值的字段
     */
    protected  $fillable = ['user_id','role_id'];

    /*
     * 相对关联
     */
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    /*
     * 相对关联
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id');
    }

}
