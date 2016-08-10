<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ProvinceModel extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'province';

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','type','status'];


}
