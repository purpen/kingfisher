<?php
/**
 * 权限
 */
namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * 关联到模型的数据表
     *     name // 权限的唯一名称，如“create-post”，“edit-post”等
     *     display_name // 人类可读的权限名称，如“发布文章”，“编辑文章”等
     *     description // 该权限的详细描述
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    /*
 * 一对多rolePermission
 */
    public function permissionPermission()
    {
        return $this->hasMany('App\Models\RolePermissionModel','Permission_id');
    }
    
}
