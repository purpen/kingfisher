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
     * 出库单入库状态修改
     * @return bool
     */
    public function setStorageStatus(){
        $status = false;
        if($this->in_count !== 0){
            if($this->count === $this->out_count){
                $this->storage_status = 5;
                if($this->save()){
                    $status = true;
                }
            }else{
                $this->storage_status = 1;
                if($this->save()){
                    $status = true;
                }
            }
        }else{
            $status = true;
        }
        return $status;
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
