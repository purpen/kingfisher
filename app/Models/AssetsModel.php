<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AssetsModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'assets';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = [];
    
    //存储七牛回调的图片信息
    public function saveImage(array $date){
        /*'name=$(fname)&size=$(fsize)&mime=$(mimeType)&width=$(imageInfo.width)&height=$(imageInfo.height)&random=$(x:random)'*/
        
    }
}
