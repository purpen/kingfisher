<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordModel extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'records';


    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['type', 'user_id', 'evt', 'target_id', 'type', 'remark', 'status'];



}
