<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends BaseModel
{
    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'article_models';

    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['title' , 'content' , 'author' , 'article_time' , 'article_type' , 'product_number' , 'site_from' , 'site_type'];


    /**
     *  相对关联products表单
     */
    public function products()
    {
        return $this->belongsTo('App\Models\ProductsModel','product_number');
    }
}
