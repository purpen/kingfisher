<?php
/**
 * 采货单内退货
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnedPurchasesModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'returned_purchases';

    //相对关联仓库表
    public function storage(){
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联供应商表
    public function supplier(){
        return $this->belongsTo('App\Models\SupplierModel','supplier_id');
    }

    //相对关联用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }
    //一对一关联出库表
    public function outWarehouses(){
        return $this->hasOne('App\Models\OutWarehousesModel','target_id');
    }

    //一对一关联收款单
    public function receiveOrder(){
        return $this->hasOne('App\Models\ReceiveOrderModel','target_id');
    }

    /**
     * 采购退货订单审核
     * @param int $id  '采购退货订单id'
     * @param int $verified  ‘审核状态’
     * @return null|string
     */
    public function changeStatus($id,$verified)
    {
        $id = (int) $id;
        $respond = 0;
        if (empty($id)){
            return $respond;
        }else{
            switch ($verified){
                case 0:
                    $verified = 1;
                    break;
                case 1:
                    $verified = 9;
                    break;
                default:
                    return $respond;
            }
            $returned = self::find($id);
            $returned->verified = $verified;
            if($returned->save()){
                $respond = 1;
            }
        }
        return $respond;
    }

    /**
     * 采购退货订单驳回状态修改
     * @param $id
     * @return int
     */
    public function returnedChangeStatus($id)
    {
        $id = (int) $id;
        $respond = 0;
        if (empty($id)){
            return $respond;
        }else{
            $purchase = self::find($id);
            $purchase->verified = 0;
            if($purchase->save()){
                $respond = 1;
            }
        }
        return $respond;
    }

    /**
     * 采购退货单总价
     * @param $id
     * @return int
     */
    public function totalMoney($id)
    {
        $models = ReturnedSkuRelationModel::where('out_warehouse_id',$id)->get();
        $totalMoney = 0;
        foreach ($models as $model){
            $totalMoney += $model->count * $model->price;
        }
        return $totalMoney;
    }
    
    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            RecordsModel::addRecord($obj, 1, 8);
        });

        self::deleted(function ($obj)
        {
            RecordsModel::addRecord($obj, 3, 8);
        });
        
        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            if(array_key_exists('verified', $remark)){
                $verified = $remark['verified'];
                switch ($verified){
                    case 0:
                        RecordsModel::addRecord($obj, 5, 8);
                        break;
                    default:
                        RecordsModel::addRecord($obj, 4, 8);
                }
            }else{
                RecordsModel::addRecord($obj, 2, 8,$remark);
            }

        });
    }
}
