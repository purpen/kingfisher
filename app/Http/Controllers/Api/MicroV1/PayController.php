<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Models\Pay;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
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
     * @apiParam {string} token token
     */
    public function pays(Request $request)
    {
        $pay_type = $request->input('pay_type');
        $order_id = $request->input('order_id');
        if(!in_array($pay_type,[1,2])){
            return $this->response->array(ApiHelper::error('请选择支付类型', 412));
        }
        if($pay_type == 1){
            $WxPay = new WxPay();
            $WxPay->wxPayApi($order_id);
        }else if($pay_type == 2){

        }
    }

}
