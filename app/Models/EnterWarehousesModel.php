<?php
/**
 * 入库单
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class EnterWarehousesModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['department_val'];

    /**
     * 关联模型到数据表
     *   id,number
     *   target_id  // 关联ID: 采购、订单退货、调拨
     *   type  // 类型：1. 采购；2.订单退货；3.调拔
     *   storage_id
     *   count
     *   in_count
     *   user_id
     *   storage_status // 入库状态：0：未入库；1：入库中；5：已入库
     *   status
     *   summary
     *   created_at,updated_at 
     * @var string
     */
    protected $table = 'enter_warehouses';
    
    // 相对关联用户表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    // 相对关联仓库表
    public function storage()
    {
        return $this->belongsTo('App\Models\StorageModel', 'storage_id');
    }
    
    // 相对关联采购订单表
    public function purchase() 
    {
        return $this->belongsTo('App\Models\PurchaseModel', 'target_id');
    }

    // 相对关联调拨表
    public function changeWarehouse()
    {
        return $this->belongsTo('App\Models\ChangeWarehouseModel', 'target_id');
    }
    
    /**
     * 入库单明细表
     */
    public function enterWarehouseSkus()
    {
        return $this->hasMany('App\Models\EnterWarehouseSkuRelationModel', 'enter_warehouse_id');
    }
    
    /**
     * 范围约束：获取不同状态下列表结果集
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
    
    /**
     * 获取相关采购单属性
     */
    public function getPurchaseNumberAttribute()
    {
        switch ($this->type) {
            case 1:
                $purchase_number = '采购单：'.$this->purchase->number;
                break;
            case 2:
                $purchase_number = '订单退货';
                break;
            case 3:
                $purchase_number = '调拨单：'.$this->changeWarehouse->number;;
                break;
        }
        return $purchase_number;
    }
    
    /**
     * 获取入库单状态标签
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->storage_status) {
            case 0:
                $status_label = '待入库';
                break;
            case 1:
                $status_label = '入库中';
                break;
            case 5:
                $status_label = '已完成';
                break;
        }
        return $status_label;
    }

    /**
     * 部门
     */
    public function getDepartmentValAttribute()
    {
        $val = '';
        switch ($this->department){
            case 0:
                break;
            case 1:
                $val = 'fiu';
                break;
            case 2:
                $val = 'D3IN';
                break;
            case 3:
                $val = '海外';
                break;
            case 4:
                $val = '电商';
                break;
            default:
        }
        return $val;
    }

    /**
     * 修改入库单入库状态、相关单据入库数量、入库状态、明细入库数量
     *
     * @param array $sku
     * @return bool
     */
    public function setStorageStatus(array $sku)
    {
        if ($this->in_count !== 0) {
            if ($this->count == $this->in_count) {
                // 完成入库
                $this->storage_status = 5;
                if (!$this->save()) {
                    return false;
                }
            } else {
                // 正在入库
                $this->storage_status = 1;
                if (!$this->save()) {
                    return false;
                }
            }

            switch ($this->type) {
                case 1:
                    if(!$this->changeRelationPurchase($sku)){
                        return false;
                    }
                    break;
                case 2:
                    $model = '';    //订单
                    break;
                case 3:
                   if(!$this->relationChangeWarehouse()){
                       return false;
                   }
                    break;
            }
        }
        
        return true;
    }

    /**
     * 变更采购单据入库数量、入库状态、明细入库数量
     *
     * @param array $sku
     * @return bool
     */
    public function changeRelationPurchase(array $sku)
    {
        $model = PurchaseModel::find($this->target_id);
        $model_sku_s = PurchaseSkuRelationModel::where('purchase_id', $this->target_id)->get();
        
        foreach ($model_sku_s as $model_sku) {
            $model_sku->in_count = (int)$model_sku->in_count + (int)$sku[$model_sku->sku_id];
            if (!$model_sku->save()) {
                return false;
            }
            $model->in_count = (int)$model->in_count + (int)$sku[$model_sku->sku_id];
        }

        $model->storage_status = $this->storage_status;
        if (!$model->save()) {
            return false;
        }
        
        return true;
    }

    /**
     * 变更关联的调拨单仓库状态
     *
     * @return bool
     */
    public function relationChangeWarehouse()
    {
        $model = ChangeWarehouseModel::find($this->target_id);
        if ($this->storage_status === 5) {
            $model->storage_status = 5;
            if (!$model->save()) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * 通过财务审核采购订单触发---生成采购入库单
     *
     * @param $purchase_id
     * @return bool
     */
    public function purchaseCreateEnterWarehouse($purchase_id)
    {
        $status = false;
        if (!$purchase = PurchaseModel::find($purchase_id)) {
            return $status;
        }
        
        $number = CountersModel::get_number('RKCG');
        $this->number = $number;
        $this->target_id = $purchase_id;
        $this->type = 1;
        $this->storage_id = $purchase->storage_id;
        $this->department = $purchase->department;
        $this->count = $purchase->count;
        $this->user_id = $purchase->user_id;
        if ($this->save()) {
            $purchase_sku_s = PurchaseSkuRelationModel::where('purchase_id',$purchase_id)->get();
            foreach ($purchase_sku_s as $purchase_sku) {
                $enter_warehouse_sku = new EnterWarehouseSkuRelationModel();
                $enter_warehouse_sku->enter_warehouse_id = $this->id;
                $enter_warehouse_sku->sku_id = $purchase_sku->sku_id;
                $enter_warehouse_sku->count = $purchase_sku->count;
                if(!$enter_warehouse_sku->save()){
                    return $status;
                }
            }
            $status = true;
        }
        
        return $status;
    }

    /**
     * 通过上级主管审核调拨单---生成调拨入库单
     *
     * @param $change_warehouse_id
     * @return bool
     */
    public function changeCreateEnterWarehouse($change_warehouse_id)
    {
        $status = false;
        if (!$change_warehouse = ChangeWarehouseModel::find($change_warehouse_id)) {
            return $status;
        }
        
        $number = CountersModel::get_number('RKDB');
        $this->number = $number;
        $this->target_id = $change_warehouse_id;
        $this->type = 3;
        $this->storage_id = $change_warehouse->in_storage_id;
        $this->department = $change_warehouse->in_department;
        $this->count = $change_warehouse->count;
        $this->user_id = Auth::user()->id;
        if($this->save()){
            $change_warehouse_sku_s = ChangeWarehouseSkuRelationModel::where('change_warehouse_id',$change_warehouse_id)->get();
            foreach ($change_warehouse_sku_s as $change_warehouse_sku){
                $enter_warehouse_sku = new EnterWarehouseSkuRelationModel();
                $enter_warehouse_sku->enter_warehouse_id = $this->id;
                $enter_warehouse_sku->sku_id = $change_warehouse_sku->sku_id;
                $enter_warehouse_sku->count = $change_warehouse_sku->count;
                if(!$enter_warehouse_sku->save()){
                    return $status;
                }
            }
            $status = true;
        }
        
        return $status;
    }

    /**
     * 待入库单数量
     */
    public static function enterWarehouseCount()
    {
        return self::where('storage_status','!=',5)->count();
    }

    public static function boot()
    {
        parent::boot();
        
        // 添加操作日志
        self::updated(function($obj) {
            $remark = $obj->getDirty();
            RecordsModel::addRecord($obj, 2, 9, $remark);
        });
    }
    
}
