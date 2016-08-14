<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProvinceModel;
class CityModel extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'city';

    public $timestamps = false;

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','p_number','city_py','status'];


    /**
     * 所属省份
     * @return Province 对象
     */
    public function province($p_number){
        $province = ProvinceModel::where('number', (int)$p_number)->first();
        return $province;
    }


}
