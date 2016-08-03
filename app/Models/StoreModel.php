<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreModel extends Model
{
    use SoftDeletes;
    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'stores';

    /*软删除设置*/
    protected  $datas = ['deleted_at'];

    /**
     * 可被批量赋值字段
     * @var array
     */
    protected $fillable = ['name','number','target_id','outside_info','type','status','user_id','summary','contact_user','contact_number'];
}
