<?php
/**
 * 财务收款单
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ReceiveOrderModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'receive_order';
    
    //相对关联订单表
    public function order(){
        return $this->belongsTo('App\Models\OrderModel','target_id');
    }

    //相对关联用户表
    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    //相对关联采购退货表
    public function returnedPurchase(){
        return $this->belongsTo('App\Models\ReturnedPurchasesModel','target_id');
    }

    /**
     * 更改付款单状态
     * @param int $status 更改后的状态
     * @return bool
     */
    public function changeStatus($status){
        $this->status = (int)$status;
        if(!$this->save()){
            return false;
        }
        return true;
    }

    /**
     * 根据订单创建收款单
     * @param int $order_id 订单ID
     * @return bool
     */
    public function orderCreateReceiveOrder($order_id){
        $order = OrderModel::find($order_id);
        if(!$order){
            return false;
        }

        $receiveOrder = new ReceiveOrderModel();

        $receiveOrder->amount = $order->pay_money;
        $receiveOrder->payment_user = $order->buyer_name;
        $receiveOrder->type = 3;
        switch ($order->type){
            case 1:    //订单
                $receiveOrder->status = 1;  //已付款
                break;
            case 2:    //渠道
                $receiveOrder->status = 0;  //未付款
                break;
            default:
                return false;
        }
        $receiveOrder->target_id = $order_id;
        $receiveOrder->user_id = Auth::user()->id;
        $number = CountersModel::get_number('SK');
        if($number == false){
            return false;
        }
        $receiveOrder->number = $number;
        if(!$receiveOrder->save()){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 根据采退单创建收款单
     * @param int $order_id 订单ID
     * @return bool
     */
    public function returnedCreateReceiveOrder($returnedOrder_id){
        $order = ReturnedPurchasesModel::find($returnedOrder_id);
        if(!$order){
            return false;
        }

        $receiveOrder = new ReceiveOrderModel();

        $receiveOrder->amount = $order->price;
        $receiveOrder->payment_user = $order->supplier->name;
        $receiveOrder->type = 4;
        $receiveOrder->status = 0;  //未付款
        $receiveOrder->target_id = $returnedOrder_id;
        $receiveOrder->user_id = Auth::user()->id;
        $number = CountersModel::get_number('SK');
        if($number == false){
            return false;
        }
        $receiveOrder->number = $number;
        if(!$receiveOrder->save()){
            return false;
        }else{
            return true;
        }
    }
}
