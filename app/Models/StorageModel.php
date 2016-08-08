<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StorageModel extends Model
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
    protected  $fillable = ['name','number','content','type','user_id','city_id','status'];

    /**
     * 设置status字段访问修改器
     */

    /**
     * 一对多关联采购表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases(){
        return $this->hasMany('App\Models\PurchasesModel','storage_id');
    }

    /**
     * 一对多关联采购退货表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function returned(){
        return $this->hasMany('App\Models\ReturnedPurchasesModel','storage_id');
    }

    //一对多关联入库表
    public function enterWarehouses(){
        return $this->hasMany('App\Models\EnterWarehousesModel','storage_id');
    }

    //一对多关联入库表
    public function outWarehouses(){
        return $this->hasMany('App\Models\OutWarehousesModel','storage_id');
    }

    //一对多关联调拨表
    public function changeWarehouse(){
        return $this->hasMany('App\Models\changeWarehouseModel','storage_id');
    }
    /**
     *
     * 一对多关联库存表
     *
     */
    public function StoragePlaces(){
        return $this->hasMany('App\Models\StoragePlaceModel','storage_id');
    }
    //status字段 访问修改器
    public function getStatusAttribute($key)
    {
        return $key?'正常':'禁用';
    }

    /**
     * 获取仓库列表
     * @param int $status
     * @return
     */
    static public function storageList($status)
    {
        if (isset($status)) {
            $list = self::where('status',$status)->select('id','name','status')->get();
        }
        else {
            $list = self::select('id','name','status')->get();
        }
        return $list;
    }

}
