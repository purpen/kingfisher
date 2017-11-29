<?php
/**
 * 购物车表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ChinaCityModel;

class DeliveryAddressModel extends BaseModel
{

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'delivery_address';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['name','phone','email','zip','user_id','province_id','city_id','county_id','town_id','address','is_default','type','status'];

    /**
     * 更新其它地址默认值
     */
    static public function updateDefault($id, $user_id, $type=1)
    {
        $addresses = self::where(['user_id' => $user_id, 'type' => $type, 'is_default' => 1])->get();
        foreach ($addresses as $k=>$v) {
            if ($v->id === $id) continue;
            $v->is_default = 0;
            $v->save();
        }
        return true;
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(){
        return ChinaCityModel::where('oid', $this->province_id)->first();
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(){
        return ChinaCityModel::where('oid', $this->city_id)->first();
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function county(){
        return ChinaCityModel::where('oid', $this->county_id)->first();
    }

    /**
     * 相对关联到ChinaCityModel表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function town(){
        return ChinaCityModel::where('oid', $this->town_id)->first();
    }

}
