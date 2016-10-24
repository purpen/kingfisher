<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissionModel extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'permission_role';

    /**
     * 允许批量赋值的字段
     */
    protected  $fillable = ['permission_id','role_id'];

    /*
     * 相对关联
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id');
    }

    /*
     * 相对关联
     */
    public function permission()
    {
        return $this->belongsTo('App\Models\Permission','permission_id');
    }

}
