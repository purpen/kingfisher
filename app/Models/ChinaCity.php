<?php
/**
 * 城市少份表(收货地址－－京东)
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChinaCityModel extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'china_cities';

    public $timestamps = false;

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','oid','pid','layer','sort','status'];


    /**
     * 获取关联信息
     */
    public function fetchCity($pid=0, $layer=1, $options=array())
    {
        $query['pid'] = (int)$pid;
        $query['layer'] = (int)$layer;
        $query['status'] = 1;

        $cities = self::where($query)->orderBy('sort', 'desc')->get();
        return $cities;
    }


}
