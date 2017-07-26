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
    protected $fillable = ['title' , 'content' , 'author' , 'article_time' , 'article_type' , 'product_number' , 'site_from' , 'site_type' , 'article_describe' , 'article_image' , 'cover_id'];


    /**
     *  相对关联products表单
     */
    public function products()
    {
        return $this->belongsTo('App\Models\ProductsModel','product_number','number');
    }

    /**
     * 获取原文件及缩略图/头像
     */
    public function getFileAttribute()
    {
        return (object)[
            'srcfile' => config('qiniu.material_url') . $this->path,
            'small' => config('qiniu.material_url') . $this->path . config('qiniu.small'),
            // 头像文件
            'avatar' => config('qiniu.material_url') . $this->path . '-ava',
            'p500' => config('qiniu.material_url') . $this->path . '-p500',
            'p800' => config('qiniu.material_url') . $this->path . '-p800',
        ];
    }


    /**
     *  相对关联materialLibraries表单
     */
    public function materialLibraries()
    {
        return $this->belongsTo('App\Models\MaterialLibrariesModel','cover_id');
    }
}
