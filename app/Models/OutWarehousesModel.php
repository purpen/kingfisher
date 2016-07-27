<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
                    $model_id = 'returned_id';
                    $model = ReturnedPurchasesModel::find($this->target_id);
                    $model_sku_s = ReturnedSkuRelationModel::where($model_id,$this->target_id)->get();
                    break;
                case 2:
                    $model = '';    //订单
                    break;
                case 3:
                    $model = '';    //调拨
                    break;
            }
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
        }else{
            return true;
        }
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
}
