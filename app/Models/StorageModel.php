<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageModel extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'storage';
    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','content','type','user_id','city_id','status'];
}
