<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class CityModel extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'city';

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','p_number','city_py','status'];


}
