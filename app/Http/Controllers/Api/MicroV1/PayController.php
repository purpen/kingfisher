<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Models\OrderModel;
use App\Models\Pay;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Illuminate\Support\Facades\Log;
use Libraries\WxPay\JsApiPay;
use Libraries\WxPay\lib\WxPayApi;
use Libraries\WxPay\lib\WxPayConfig;
use Libraries\WxPay\lib\WxPayJsApiPay;
use Libraries\WxPay\lib\WxPayUnifiedOrder;
use Libraries\WxPay\WxPay;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class PayController extends BaseController
{
    /**
     * @api {get} /pay/payOrder 选择支付方式
     * @apiVersion 1.0.0
     * @apiName Pay payOrder
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id  订单id
     * @apiParam {integer} pay_type  1.微信 2.支付宝
     * @apiParam {string} token  token
     */
    public function pays(Request $request)
    {
        $pay_type = $request->input('pay_type');
        $order_id = $request->input('order_id');
        if(!in_array($pay_type,[1,2])){
            return $this->response->array(ApiHelper::error('请选择支付类型', 412));
        }

        $order = OrderModel::where('id', $order_id)->first();
        if($order){
            $total = $order->total_money;
        }else{
            return $this->response->array(ApiHelper::error('没有找到该订单', 404));
        }
        $pay_order = $this->createPayOrder('Micro商城订单', $total , $order_id);
        if($pay_type == 1){
            $WxPay = new WxPay();
            $WxPay->wxPayApi('Micro商城订单' , $total*100 , $pay_order->uid);
        }else if($pay_type == 2){

        }
    }


    /**
     * 创建需求 支付单
     * @param int $type 支付类型：1.预付押金;2.项目款
     * @param float $amount 支付金额
     * @param int $user_id 用户ID
     * @param string $summary 备注
     * @return mixed
     */
    protected function createPayOrder($summary = '', $amount, $order_id)
    {
        $pay_order = Pay::where(['user_id' => $this->auth_user_id, 'status' => 0])
            ->first();
        if($pay_order){
            return $pay_order;
        }

        $uid = 'micro'.date("mdHis") . sprintf("%06d", $this->auth_user_id) . mt_rand(00, 99);

        $pay_order = Pay::create([
            'uid' => $uid,
            'user_id' => $this->auth_user_id,
            'summary' => $summary,
            'order_id' => $order_id,
            'amount' => $amount,
        ]);
        return $pay_order;
    }

}
