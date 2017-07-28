<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteRecordModel extends BaseModel
{
    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'site_record';

    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['mark', 'url', 'site_type', 'status', 'count'];

}
