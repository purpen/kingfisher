<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    protected $fillable = ['product_number' , 'name','describe','size','width','height','mime','domain','path','type' ,'random'];


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
        ];
    }
}
