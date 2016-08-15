<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class OutWarehousesModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
    
    /**
     * 修改出库单出库状态;相关单据出库数量,出库状态,明细出库数量
     * @param array $sku
     * @return bool
     */
    public function setStorageStatus(array $sku){
        if($this->out_count !== 0){
            if($this->count === $this->out_count){
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
        $this->count = $purchase->count;
        $this->user_id = $purchase->user_id;

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
        $this->count = $change_warehouse->count;
        $this->user_id = Auth::user()->id;

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
        $this->count = $order->count;
        $this->user_id = Auth::user()->id;

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
}
