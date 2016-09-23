<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefundMoneyOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'refund_money_order';

    /**
     * 添加退款单
     *
     * @param array $refund 退款单详细信息
     * @return bool
     */
    public function store(array $refund)
    {
        DB::beginTransaction();
        if(!$refund_model = RefundMoneyOrderModel::create($refund)){
            DB::rollBack();
            return false;
        }

        $order_id = $refund_model->order_id;
        if(!$order_model = OrderModel::find($order_id)){
            DB::rollBack();
            return false;
        }
        //挂起对应的订单
        if(!$order_model->suspend()){
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }


    /**
     * 退款审核处理方法
     *
     * @param int $id 退款单ID
     * @param int $bool 退款审核状态,0:拒绝退款;1:同意退款;
     * @return bool
     */
    public function checkRefund($id,$bool)
    {
        DB::beginTransaction();
        if(!$refund_model = RefundMoneyOrderModel::find($id)){
            return false;
        }

        DB::beginTransaction();
        $refund_model->status = $bool;
        $refund_model->user_id = Auth::user()->id;
        $refund_model->check_time = date("Y-m-d H:i:s");
        if(!$refund_model->save()){
            DB::rollBack();
            return false;
        }
        $order_id = $refund_model->order_id;
        $order = OrderModel::find($order_id);

        if($bool == 2){  //退款审核通过,修改对应订单未取消状态,订单挂起取消
            if(!$order->changeStatus($order_id, 0)){
                DB::rollBack();
                return false;
            }
            if(!$order->cancelSuspend()){
                DB::rollBack();
                return false;
            }

        }else if($bool == 0){  //拒绝退款，订单挂起取消
            if(!$order->cancelSuspend()){
                DB::rollBack();
                return false;
            }

        }

        DB::commit();
        return true;
    }
}
