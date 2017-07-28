<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteModel extends BaseModel
{
    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'site';

    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['name', 'mark', 'url', 'grap_url', 'site_type', 'status', 'remark', 'user_id', 'items'];


    /**
     * 应该被转化为原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array',
    ];

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
