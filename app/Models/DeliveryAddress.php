<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryAddress extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到收货地址表
     * @var string
     */
    protected $table = 'receiving_address';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name','phone','zip','user_id','province_id','city_id','county_id','town_id','address','is_default','status'];

    /**
     * 更新其它地址默认值
     */
    static public function updateDefault($id, $user_id)
    {
        $addresses = self::where(['user_id' => $user_id, 'is_default' => 1])->get();
        foreach ($addresses as $k=>$v) {
            if ($v->id != $id) {
                $v->is_default = 0;
                $v->update();
            }
        }
        return true;
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(){
        return $this->belongsTo('App\Models\ChinaCityModel', 'province_id', 'oid');
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(){
        return $this->belongsTo('App\Models\ChinaCityModel', 'city_id', 'oid');
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function county(){
        return $this->belongsTo('App\Models\ChinaCityModel', 'county_id', 'oid');
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function town(){
        return $this->belongsTo('App\Models\ChinaCityModel', 'town_id', 'oid');
    }

}
