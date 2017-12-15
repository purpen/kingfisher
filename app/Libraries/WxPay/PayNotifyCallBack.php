<?php
namespace Libraries\WxPay;

use App\Models\OrderModel;
use App\Models\Pay;
use App\Models\ReceiveOrderModel;
use Illuminate\Support\Facades\Log;
use Libraries\WxPay\lib\WxPayApi;
use Libraries\WxPay\lib\WxPayNotify;
use Libraries\WxPay\lib\WxPayOrderQuery;

/**
 * 微信回调类
 *
 * Class PayNotifyCallBack
 * @package Lib\WxPay
 */
class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        //网站业务处理
        if($data['result_code'] === 'SUCCESS'){
            try{
                $pay_order = Pay::where('uid', $data['out_trade_no'])->first();
                $status = $pay_order->status;
                //判断是否业务已处理
                if($status == 0){
                    $pay_order->pay_type = 1; //微信
                    $pay_order->pay_no = $data['transaction_id'];
                    $pay_order->status = 1; //支付成功

                    if ($pay_order->save()){
                        $order = OrderModel::where('id' , $pay_order->order_id)->first();
                        $order->status = 5;
                        $order->save();

                        // 创建订单收款单
                        $model = new ReceiveOrderModel();
                        if (!$model->orderCreateReceiveOrder($order->id)) {
                            Log::error('ID:'. $order->id .'订单发货创建订单收款单错误');
                        }
                    }

                }
            }
            catch (\Exception $e){
                Log::error($e);
                $msg = "业务处理失败";
                return false;
            }
        }

        return true;
    }
}