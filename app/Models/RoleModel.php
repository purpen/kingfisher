<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class RoleModel extends EntrustRole
{
    /**
     * 关联到模型的数据表
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
