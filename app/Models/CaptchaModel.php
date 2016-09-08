<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaptchaModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'captcha';
    
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['phone', 'code'];

}
