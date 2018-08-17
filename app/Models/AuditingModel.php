<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditingModel extends BaseModel
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

}
