<?php
/**
 * 用户角色
 */
namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * 关联到模型的数据表
     *     name // 角色的唯一名称，如“admin”，“owner”，“employee”
     *     display_name // 人类可读的角色名，例如“后台管理员”、“作者”、“雇主”等
     *     description // 该角色的详细描述
     *
     * @var string
     */
    protected $table = 'roles';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];
    
}
