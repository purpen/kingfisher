<?php
/**
 * 附件列表（图片）
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetsModel extends BaseModel
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
    protected $fillable = ['user_id','name','random','size','width','height','mime','domain','path','target_id'];

    /**
     * 一对一关联products表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product(){
        return $this->hasOne('App\Models\ProductsModel','cover_id');
    }

    /**
     * 一对一关联productSku表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsSku(){
        return $this->hasOne('App\Models\ProductsSkuModel','cover_id');
    }

    /**
     * 一对一关联user表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(){
        return $this->hasOne('App\Models\UserModel','cover_id');
    }

    /**
     * 一对一关联供应商
     */
    public function supplier(){
        return $this->hasOne('App\Models\SupplierModel','cover_id');
    }

    /**
     * 获取原文件及缩略图/头像
     */
    public function getFileAttribute()
    {
        return (object)[
            'srcfile' => config('qiniu.url') . $this->path,
            'small' => config('qiniu.url') . $this->path . config('qiniu.small'),
            // 头像文件
            'avatar' => config('qiniu.url') . $this->path . '-ava',
        ];
    }


}
