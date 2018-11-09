<?php
/**
 * 出库单
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class OutWarehousesModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['department_val'];
    
    //需要审核操作的金额下限
    protected $moneyCount = 50000;

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'out_warehouses';

    //相对关联用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //相对关联仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联采购退货表
    public function returnedPurchase(){
        return $this->belongsTo('App\Models\ReturnedPurchasesModel','target_id');
    }

    //相对关联调拨表
    public function changeWarehouse(){
        return $this->belongsTo('App\Models\ChangeWarehouseModel','target_id');
    }

    //相对关联订单表
    public function order(){
        return $this->belongsTo('App\Models\OrderModel','target_id');
    }

    //关联出库明细表
    public function outWarehouseSkuRelation()
    {
        return $this->hasMany('App\Models\OutWarehouseSkuRelationModel', 'out_warehouse_id');
    }

    /**
     * 状态说明字段
     * @return int|string
     */
    public function getStatusValAttribute()
    {
        $result = 1;
        switch ($this->status){
            case 0:
                $result = '待审核';
                break;
            case 1:
                $result = '可出库';
                break;
        }
        return $result;
    }

    /**
     * 出库状态说明字段  出库状态：0.未出库；1.出库中；5.已出库
     * @return int|string
     */
    public function getStorageStatusValAttribute()
    {
        $result = 1;
        switch ($this->storage_status){
            case 0:
                $result = '未出库';
                break;
            case 1:
                $result = '出库中';
                break;
            case 5:
                $result = '已出库';
        }
        return $result;
    }

    /**
     * 部门名称
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
     * 修改出库单出库状态;相关单据出库数量,出库状态,明细出库数量
     * @param array $sku
     * @return bool
     */
    public function setStorageStatus(array $sku){
        if($this->out_count !== 0){
            if($this->count == $this->out_count){
                $this->storage_status = 5;
                if(!$this->save()){
                    return false;
                }
            }else{
                $this->storage_status = 1;
                if(!$this->save()){
                    return false;
                }
            }
            switch ($this->type){
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
            return true;
        }else{
            return true;
        }
    }

    /**
     * 变更关联的采购退货单据出库数量,出库状态,明出库数量
     * @param array $sku
     * @return bool
     */
    public function changeRelationPurchase(array $sku){
        $model = ReturnedPurchasesModel::find($this->target_id);
        $model_sku_s = ReturnedSkuRelationModel::where('returned_id',$this->target_id)->get();

        foreach ($model_sku_s as $model_sku){
            $model_sku->out_count = (int)$model_sku->out_count + (int)$sku[$model_sku->sku_id];
            if(!$model_sku->save()){
                return false;
            }
            $model->out_count = (int)$model->out_count + (int)$sku[$model_sku->sku_id];
        }

        $model->storage_status = $this->storage_status;
        if(!$model->save()){
            return false;
        }
        return true;
    }


    /**
     * 变更关联的调拨单仓库状态
     * @return bool
     */
    public function relationChangeWarehouse(){
        $model = ChangeWarehouseModel::find($this->target_id);
        if($this->storage_status === 1){
            $model->storage_status = 1;
            if(!$model->save()){
                return false;
            }
        }
        return true;
    }

    
    /**
     * 主管审核采购退货订单触发---生成出库单
     * @param $purchase_id
     * @return bool
     */
    public function returnedCreateOutWarehouse($returned_id){
        $status = false;
        if(!$purchase = ReturnedPurchasesModel::find($returned_id)){
            return $status;
        }

        $number = CountersModel::get_number('CKCT');
        $this->number = $number;

        $this->target_id = $returned_id;
        $this->type = 1;
        $this->storage_id = $purchase->storage_id;
        $this->department = $purchase->department;
        $this->count = $purchase->count;
        $this->user_id = $purchase->user_id;

        //判断出库金额是否需要审核
        $totalMoney = $purchase->totalMoney($returned_id);
        $this->status = ($totalMoney >= $this->moneyCount)?0:1;

        if($this->save()){
            $returned_id_sku_s = ReturnedSkuRelationModel::where('returned_id',$returned_id)->get();
            foreach ($returned_id_sku_s as $returned_id_sku){
                $out_warehouse_sku = new OutWarehouseSkuRelationModel();

                $out_warehouse_sku->out_warehouse_id = $this->id;
                $out_warehouse_sku->sku_id = $returned_id_sku->sku_id;
                $out_warehouse_sku->count = $returned_id_sku->count;

                if(!$out_warehouse_sku->save()){
                    return $status;
                }
            }
            $status = true;
        }
        return $status;
    }


    /**
     * 主管审核调拨单---生成调拨出库单
     * @param $change_warehouse_id
     * @return bool
     */
    public function changeCreateOutWarehouse($change_warehouse_id){
        $status = false;
        if(!$change_warehouse = ChangeWarehouseModel::find($change_warehouse_id)){
            return $status;
        }

        $number = CountersModel::get_number('CKDB');
        $this->number = $number;

        $this->target_id = $change_warehouse_id;
        $this->type = 3;
        $this->storage_id = $change_warehouse->out_storage_id;
        $this->department = $change_warehouse->out_department;
        $this->count = $change_warehouse->count;
        $this->user_id = Auth::user()->id;

        //判断出库金额是否需要审核
        $totalMoney = $change_warehouse->totalMoney($change_warehouse_id);

        $this->status = ($totalMoney >= $this->moneyCount)?0:1;

        if($this->save()){
            $change_warehouse_sku_s = ChangeWarehouseSkuRelationModel::where('change_warehouse_id',$change_warehouse_id)->get();
            foreach ($change_warehouse_sku_s as $change_warehouse_sku){
                $out_warehouse_sku = new OutWarehouseSkuRelationModel();

                $out_warehouse_sku->out_warehouse_id = $this->id;
                $out_warehouse_sku->sku_id = $change_warehouse_sku->sku_id;
                $out_warehouse_sku->count = $change_warehouse_sku->count;

                if(!$out_warehouse_sku->save()){
                    return $status;
                }
            }
            $status = true;
        }
        return $status;
    }

    /**
     * 打印发货单---生成订单出库单
     * @param $order_id
     * @return bool
     */
    public function orderCreateOutWarehouse($order_id){
        $status = false;
        if(!$order = OrderModel::find($order_id)){
            return $status;
        }

        $number = CountersModel::get_number('CKDD');
        $this->number = $number;

        $this->target_id = $order_id;
        $this->type = 2;
        $this->storage_id = $order->storage_id;
        $this->department = UserModel::find($order->user_id_sales)->department;
        $this->count = $order->count;
        if (Auth::user()){
            $this->user_id = Auth::user()->id;
        }
        $this->user_id = 0;
        
        //判断金额是否需要审核
        $this->status = ($order->pay_money >= $this->moneyCount)?0:1; 
        
        if($this->save()){
            $order_sku_s = OrderSkuRelationModel::where('order_id',$order_id)->get();
            foreach ($order_sku_s as $order_sku){
                $out_warehouse_sku = new OutWarehouseSkuRelationModel();

                $out_warehouse_sku->out_warehouse_id = $this->id;
                $out_warehouse_sku->sku_id = $order_sku->sku_id;
                $out_warehouse_sku->count = $order_sku->quantity;

                if(!$out_warehouse_sku->save()){
                    return $status;
                }
            }
            $status = true;
        }
        return $status;
    }

    /**
     * 待出库单
     */
    public static function outWarehouseCount(){
        return self::where('storage_status','!=',5)->count();
    }
    
    public static function boot()
    {
        parent::boot();

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            RecordsModel::addRecord($obj, 2, 10,$remark);

        });
    }
    
    /**
     * 出库单审核
     */
    public function verify($id='')
    {
        if(!empty($id)){
            $model = self::find($id);
        }else{
            $model = $this;
        }
        $model->status = 1;
        if(!$model->save()){
            return false;
        }
        
        return true;
    }

    /**
     * 完全删除出库单及明细
     */
    public function deleteOutWarehouse()
    {
        $outWarehouseSkuRelation = $this->outWarehouseSkuRelation;
        if(!$outWarehouseSkuRelation->isEmpty()){
            foreach ($outWarehouseSkuRelation as $v){
                $v->forceDelete();
            }
        }
        $this->forceDelete();

        return true;
    }

    /**
     * @return string 删除追加字段
     */
    public function OutEmpty()
    {
//        unset($this->appends);
          $this->appends = null;
    }

}
