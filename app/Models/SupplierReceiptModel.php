<?php
//代发供货商收款单表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierReceiptModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'supplier_receipt';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = ['number', 'supplier_user_id', 'start_time', 'end_time', 'total_price', 'user_id', 'status'];

    /**
     * 一对一关联收款单
     */
    public function receiveOrderModel()
    {
        return $this->hasOne('App\Models\ReceiveOrderModel', 'user_id');
    }

    /**
     * 相对关联供应商
     */
    public function SupplierModel()
    {
        return $this->belongsTo('App\Models\SupplierModel', 'supplier_user_id');
    }




    /**
     * 审核状态访问设置
     * 0.关联人；1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
     */
    public function getReceiptStatusValAttribute()
    {
        switch ($this->status){
//            case 0:
//                $status = '默认';
//                break;
            case 1:
                $status = '待采购确认';
                break;
            case 2:
                $status = '待供应商确认';
                break;
            case 3:
                $status = '待确认付款';
                break;
            case 4:
                $status = '完成';
                break;
            default:
                $status = '默认';
        }

        return $status;
    }

    /**
     * 代发供货商收款单审核通过状态修改
     * @param int $id  '代发供货商收款单id'
     * @param int $verified  ‘审核状态’
     * @return null|string
     */
    public function changeStatus($id,$status)
    {
        $id = (int) $id;
        switch ($status){
//                case 0:
//                    $status = 1;
//                    break;
            case 1:
                $status = 2;
                break;
            case 2:
                $status = 3;
                break;
            case 3:
                $status = 4;
                break;
        }
        $supplierReceipt = SupplierReceiptModel::find($id);
        $supplierReceipt->status = $status;
        $res = $supplierReceipt->save();
        return $res;
    }


    /**
     * 获取仓库列表
     * @param int $status
     * @return
     */
    static public function storageList($status = null)
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
