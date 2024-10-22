<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Utils;

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
    protected $fillable = ['title' , 'content' , 'author' , 'article_time' , 'article_type' , 'product_number' , 'site_from' , 'site_type' , 'article_describe' , 'article_image' , 'cover_id' , 'status'];


    /**
     *  相对关联products表单
     */
    public function products()
    {
        return $this->belongsTo('App\Models\ProductsModel','product_number','number');
    }

    /**
     * 获取商品封面图
     */
    public function getFirstImgAttribute()
    {

        $result = $this->imageFile();
        if(is_object($result)){
            return $result->small;
        }
        return $result;
    }

    /**
     * 获取商品图片信息对象
     */
    public function getImageFileAttribute()
    {
        $materialLibrary = MaterialLibrariesModel
            ::where(['target_id' => $this->id, 'type' => 4])
            ->orderBy('id','desc')
            ->first();
        return $materialLibrary->file;
    }

    /**
     *  相对关联materialLibraries表单
     */
    public function materialLibraries()
    {
        return $this->belongsTo('App\Models\MaterialLibrariesModel','cover_id');
    }

    /**
     * 更改站点开放状态
     */
    static public function okStatus($id, $status=1)
    {
        $site = self::findOrFail($id);
        $site->status = $status;
        $ok = $site->save();
        // 创建文章下载任务
        if($ok && $status==1){
            // 素材压缩保存
            $result = Utils::genArticleZip($id);
        }
        return $ok;
    }
}
