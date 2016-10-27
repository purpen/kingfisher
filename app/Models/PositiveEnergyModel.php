<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositiveEnergyModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'positive_energys';



    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['content','type','sex'];

}
