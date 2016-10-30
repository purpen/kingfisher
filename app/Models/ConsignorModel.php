<?php
/**
 * 仓房发货人信息
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignorModel extends Model
{
    /**
     * 关联模型到数据表
     *   id,
     *   storage_id,
     *   name,
     *   origin_city,
     *   tel,phone,zip,address,
     *   province_id,district_id,
     *   created_at,updated_at
     * @var string
     */
    protected $table = 'consignor';
    
    /**
     * 添加软删除
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected $fillable = ['storage_id','name','origin_city','tel','phone','zip','province_id','district_id','address'];

    /**
     * 相对关联storage表
     */
    public function storage()
    {
        return $this->belongsTo('App\Models\StorageModel', 'storage_id');
    }
    
    /**
     * 获取所属的省市
     *
     * Defines an inverse one-to-many relationship.
     */
    public function province()
    {
        return $this->belongsTo('App\Models\ChinaCityModel', 'province_id');
    }
    
    /**
     * 获取所属的区域
     *
     * Defines an inverse one-to-many relationship.
     */
    public function district()
    {
        return $this->belongsTo('App\Models\ChinaCityModel', 'district_id');
    }
    
}
