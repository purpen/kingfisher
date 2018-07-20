<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorsModel extends Model
{
//    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'distributors';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = ['number', 'store_name', 'store_address', 'operation_situation', 'bank_number', 'cover_id', 'bank_name','business_license_number','taxpayer','area_id','authorization_id'];


    /**
     * 一对多关联附件表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','cover_id');
    }


    /**
     * 一对多关联分类表
     */

    public function CategoriesModel()
    {
        return $this->belongsTo('App\Models\CategoriesModel', 'category_id');
    }







}
