<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnterWarehousesModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'enter_warehouses';
    
    //相对关联用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //相对关联仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联采购订单表
    public function purchase(){
        return $this->belongsTo('App\Models\PurchaseModel','target_id');
    }
    /**
     * 由通过财务审核记账的采购订单生成入库单
     * @param $purchase_id
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    static public function purchaseAdd($purchase_id){
        $status = false;
        if(!$purchase = PurchaseModel::find($purchase_id)){
            return $status;
        }
        $enter = new EnterWarehousesModel();
        if(!$number = CountersModel::get_number('RKCG')){
            return view('errors.503');
        }
        $enter->number = $number;
        $enter->target_id = $purchase_id;
        $enter->type = 1;
        $enter->storage_id = $purchase->storage_id;
        $enter->count = $purchase->count;
        $enter->user_id = $purchase->user_id;
        if($enter->save()){
            $purchase_sku_s = PurchaseSkuRelationModel::where('purchase_id',$purchase_id)->get();
            foreach ($purchase_sku_s as $purchase_sku){
                $enter_warehouse_sku = new EnterWarehouseSkuRelationModel();
                $enter_warehouse_sku->enter_warehouse_id = $enter->id;
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

}
