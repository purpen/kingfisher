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
    protected $fillable = ['product_number' , 'name','describe','size','width','height','mime','domain','path','type' ,'random' , 'image_type' , 'video_length' , 'status'];


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
        $mime = $this->mime ? $this->mime : '/';
        $newMime = explode('/' , $mime);

        return (object)[
            'srcfile' => config('qiniu.material_url') . $this->path.'?ext='.$newMime[1],
            'name' => $this->name,
            'small' => config('qiniu.material_url') . $this->path . config('qiniu.small').'?ext='.$newMime[1],
            // 头像文件
            'avatar' => config('qiniu.material_url') . $this->path . '-ava'.'?ext='.$newMime[1],
            'p500' => config('qiniu.material_url') . $this->path . '-p500'.'?ext='.$newMime[1],
            'p800' => config('qiniu.material_url') . $this->path . '-p800'.'?ext='.$newMime[1],
            'p280_210' => config('qiniu.material_url') . $this->path . '-p280.210'.'?ext='.$newMime[1],
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
        $key = 'article/'.date("Ymd").'/'.uniqid();
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

    /**
     * 更改站点开放状态
     */
    static public function okStatus($id, $status=1)
    {
        $site = self::findOrFail($id);
        $site->status = $status;
        return $site->save();
    }
}
