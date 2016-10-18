<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignorModel extends Model
{
    /**
     * 添加软删除
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['storage_id','name','origin_city','tel','phone','zip','province_id','district_id','address'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'consignor';

    /**
     * 相对关联storage表
     */
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    /**
     * 相对关联province表
     */
    public function province(){
        return $this->belongsTo('App\Models\ProvinceModel','province_id');
    }

    /**
     * 相对关联city表
     */
    public function city(){
        return $this->belongsTo('App\Models\CityModel','district_id');
    }
}
