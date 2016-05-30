<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class PermissionModel extends EntrustPermission
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'permissions';
}
