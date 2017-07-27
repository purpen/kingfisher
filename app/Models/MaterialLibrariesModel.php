<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class MaterialLibrariesModel extends BaseModel
{
    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'material_libraries';

    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['product_number' , 'name','describe','size','width','height','mime','domain','path','type' ,'random' , 'image_type'];


    /**
     *  相对关联products表单
     */
    public function products()
    {
        return $this->belongsTo('App\Models\ProductsModel','product_number' , 'number');
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
            'video' => config('qiniu.material_url') . $this->path . '?vframe/jpg/offset/1/w/200/h/200' ? config('qiniu.material_url') . $this->path . '?vframe/jpg/offset/1/w/200/h/200' : '',
        ];
    }

    /**
     * 获取商品封面图
     */
    public function getFirstImgAttribute()
    {
        $materialLibrary = MaterialLibrariesModel
            ::where(['id' => $this->id, 'type' => 1])
            ->orderBy('id','desc')
            ->first();
        if(empty($materialLibrary)){
            return url('images/default/erp_product.png');
        }
        return $materialLibrary->file->small;
    }


    /**
     * 抓取的文章图片上传至七牛
     */
    public function grabUpload($url)
    {
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');
        $auth = new Auth($accessKey, $secretKey);

        $bucket = config('qiniu.material_bucket_name');

        $token = $auth->uploadToken($bucket);
        $filePath = file_get_contents($url);
        $date = time();
        $key = 'article/'.$date.'/'.uniqid();
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 put 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->put($token, $key, $filePath);
        $data = config('qiniu.material_url').$key;
        return $data;
    }

    /**
     * 一对一关联products表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function article()
    {
        return $this->hasOne('App\Models\ArticleModel', 'cover_id');
    }
}
