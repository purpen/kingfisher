<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SupplierModel extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'suppliers';

    //使用软删除
    use SoftDeletes;
    //软删除属性
    protected $dates = ['deleted_at'];
    
    /**
     * 允许批量赋值的字段
     */
    protected  $fillable = ['name','address','legal_person','tel','contact_user','contact_number','contact_email','contact_qq','contact_wx','summary'];

}
