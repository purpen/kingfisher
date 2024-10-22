<?php
/**
 * 物流快递信息
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LogisticsModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'logistics';

    /**
     * 允许批量赋值字段
     */
    protected $fillable = ['name','logistics_id','area','contact_user','contact_number','summary'];

    /**
     * status读取修改器
     */
    public function getStatusValAttribute()
    {
        return $this->status?'停用':'启用';
    }
    
    /**
     * 范围约束：获取不同状态下列表结果集
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', (int)$status);
    }

    /**
     * 一对多关联order 订单表
     */
    public function order(){
        return $this->hasMany('App\Models\OrderModel','express_id');
    }

    /**
     * 一对多关联storeStorageLogistic表
     */
    public function storeStorageLogistic(){
        return $this->hasMany('App\Models\StoreStorageLogisticModel','logistics_id');
    }

    public static function boot(){
        parent::boot();
        self::created(function ($obj){
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 1, 6,$remark);
        });

        self::updated(function ($obj){
            $remark = $obj->getDirty();

            RecordsModel::addRecord($obj, 2, 6,$remark);
        });

        self::deleted(function ($obj){
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 3, 6,$remark);
        });
    }


    /**
     * 物流公司匹配
     *
     * @param $str string 物流公司名称
     * @return int|null 返回匹配的物流公司ID或null
     */
    public static function matching($str)
    {
        $logistics = config('logistics.matching');

        $str = trim($str);

        foreach ($logistics as $k => $v){
            if(strpos($str, $v[0]) !== false || strpos($str, $v[1]) !== false){
                if($logistics_model = LogisticsModel::where('kdn_logistics_id', $k)->first())
                {
                    return (int)$logistics_model->id;
                }else{
                    return null;
                }
            }
        }
        return null;
    }
}
