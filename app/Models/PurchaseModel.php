<?php
/**
 * 采购单
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'purchases';



    //相对关联供应商表
    public function supplier()
    {
        return $this->belongsTo('App\Models\SupplierModel','supplier_id');
    }

    //相对关联仓库表
    public function storage()
    {
        return $this->belongsTo('App\Models\StorageModel','storage_id');
    }

    //相对关联用户表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //一对一关联入库表
    public function enterWarehouses()
    {
        return $this->hasOne('App\Models\EnterWarehousesModel','target_id');
    }

    //一对一关联付款单
    public function paymentOrder(){
        return $this->hasOne('App\Models\PaymentOrderModel','target_id');
    }

    /**
     * 审核状态访问设置
     * 0.未审核；1.业管主管；2.财务；9.通过
     */
    public function getVerifiedValAttribute()
    {
        switch ($this->verified){
            case 0:
                $value = '未审核';
                break;
            case 1:
                $value = '待主管审核';
                break;
            case 2:
                $value = '待财务审核';
                break;
            case 9:
                $value = '通过审核';
                break;
        }

        return $value;
    }

    /**
     * 入库状态： 0.未入库；1.入库中；5.已入库
     */
    public function getStorageStatusValAttribute()
    {
        switch ($this->storage_status){
            case 0:
                $value = '未入库';
                break;
            case 1:
                $value = '入库中';
                break;
            case 5:
                $value = '已入库';
                break;
        }

        return $value;
    }

    /**
     * 1.老款补货 2.新品到货
     * @param $key
     * @return mixed
     */
    public function getTypeValAttribute($key)
    {
        switch ($this->type){
            case 1:
                $value = '老款补货';
                break;
            case 2:
                $value = '新品到货';
                break;
        }
        return $value;
    }

    /**
     * 根据数组对象中的相关id,为对象添加 仓库/供货商/用户名;
     * @param $lists
     * @return mixed
     */
    public function lists($lists)
    {
        foreach ($lists as $list){
            $list->supplier = $list->supplier->name;
            $list->storage = $list->storage->name;
            $list->user = $list->user->realname;
        }
        return $lists;
    }

    /**
     * 采购订单审核通过状态修改
     * @param int $id  '采购订单id'
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
                    $verified = 2;
                    break;
                case 2:
                    $verified = 9;
                    break;
                default:
                    return $respond;
            }
            $purchase = PurchaseModel::find($id);
            $purchase->verified = $verified;
            if($purchase->save()){
                $respond = 1;
            }
        }
        return $respond;
    }

    /**
     * 采购订单驳回状态修改
     * @param $id
     * @return int
     */
    public function returnedChangeStatus($id)
    {
        $id = (int)$id;
        if(empty($id)){
            return false;
        }

        $purchase = PurchaseModel::find($id);
        $purchase->verified = 0;
        if(!$purchase->save()){
            return false;
        }

        return true;
    }

    /**
     * 更改采购单 采购明细 的入库数量；
     * @param $purchase_id (采购单ID)
     * @param array $sku   (sku_id =>入库数量 键值对)
     * @return bool
     */
    public function changeInCount($purchase_id,array $sku)
    {
        $purchase_model = $this::find($purchase_id);
        $purchase_sku_s = PurchaseSkuRelationModel::where('purchase_id',$purchase_id)->get();
        foreach ($purchase_sku_s as $purchase_sku){
            $purchase_sku->in_count = (int)$purchase_sku->in_count + (int)$sku[$purchase_sku->sku_id];
            $purchase_model->in_count = (int)$purchase_model->in_count + (int)$sku[$purchase_sku->sku_id];
            if(!$purchase_sku->save() || !$purchase_model->save()){
                return false;
            }
        }
        return true;
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            $remark = $obj->number;
            RecordsModel::addRecord($obj, 1, 7,$remark);
        });

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            if (array_key_exists('verified', $remark)){
                $verified = $remark['verified'];
                switch ($verified){
                    case 0:
                        RecordsModel::addRecord($obj, 5, 7);
                        break;
                    default:
                        RecordsModel::addRecord($obj, 4, 7);
                }
            } else{
                RecordsModel::addRecord($obj, 2, 7,$remark);
            }

        });

        self::deleted(function ($obj)
        {
            $remark = $obj->number;
            RecordsModel::addRecord($obj, 3, 7,$remark);
        });
    }
}
