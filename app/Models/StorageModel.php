<?php
/**
 * 仓库表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorageModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'storages';
    /**
     * 可被批量赋值的属性
     * @var array
     */
    protected  $fillable = ['name','number','content','type','user_id','city_id','status','address'];

    /**
     * 设置status字段访问修改器
     */

    /**
     * 一对多关联采购表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases()
    {
        return $this->hasMany('App\Models\PurchasesModel','storage_id');
    }

    /**
     * 一对多关联采购退货表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returned()
    {
        return $this->hasMany('App\Models\ReturnedPurchasesModel','storage_id');
    }

    //一对多关联入库表
    public function enterWarehouses()
    {
        return $this->hasMany('App\Models\EnterWarehousesModel','storage_id');
    }

    //一对多关联入库表
    public function outWarehouses()
    {
        return $this->hasMany('App\Models\OutWarehousesModel','storage_id');
    }

    //一对多关联调拨表
    public function changeWarehouse()
    {
        return $this->hasMany('App\Models\changeWarehouseModel','storage_id');
    }
    /**
     * 一对多关联库区表
     */
    public function StorageRack()
    {
        return $this->hasMany('App\Models\StorageRackModel','storage_id');
    }

    /**
     * 一对多关联StorageSkuCount表
     */
    public function StorageSkuCount()
    {
        return $this->hasMany('App\Models\StorageSkuCountModel','storage_id');
    }

    //一对多关联订单表
    public function order()
    {
        return $this->hasMany('App\Models\OrderModel','storage_id');
    }

    /**
     * 一对多关联storeStorageLogistic表
     */
    public function storeStorageLogistic()
    {
        return $this->hasMany('App\Models\StoreStorageLogisticModel','storage_id');
    }

    /**
     * 一对一关联consignor表
     * 默认发货人
     */
    public function consignor()
    {
        return $this->hasOne('App\Models\ConsignorModel', 'storage_id');
    }
    
    //status字段 访问修改器
    public function getStatusAttribute($key)
    {
        return $key ? '正常' : '禁用';
    }
    
    /**
     * 范围约束：获取不同状态下列表结果集
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', (int)$status);
    }
    
    /**
     * 获取仓库列表
     * @param int $status
     * @return
     */
    static public function storageList($status)
    {
        if (isset($status)) {
            $list = self::where('status',$status)->select('id','name','status')->take(20)->get();
        }
        else {
            $list = self::select('id','name','status')->get();
        }
        return $list;
    }
    
    public static function boot(){
        parent::boot();
        
        self::created(function ($storage){
            $remark = $storage->name;
            RecordsModel::addRecord($storage, 1, 2,$remark);
        });
        
        self::updated(function ($storage){
            $remark = $storage->getDirty();
            
            RecordsModel::addRecord($storage, 2, 2,$remark);
        });

        self::deleted(function ($storage){
            $remark = $storage->name;
            RecordsModel::addRecord($storage, 3, 2,$remark);
        });
    }
}
