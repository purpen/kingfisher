<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        return $this->belongsTo('App\Models\ProductsModel','product_number');
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
        if(empty($materialLibrary->path)){
            return url('images/default/erp_product.png');
        }
        return $materialLibrary->file->small;
    }
}
