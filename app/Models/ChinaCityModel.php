<?php
/**
 * 城市少份表(收货地址－－京东)
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChinaCityModel extends BaseModel
{
    public $timestamps = false;
    
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'china_cities';

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

    /**
     * 设置父级城市访问字段
     */
    public function getParentNameAttribute()
    {
        $parentName = ChinaCityModel::where('oid',$this->pid)->first();
        if(!$parentName){
            return '';
        }
        return $parentName->name;
    }


}
