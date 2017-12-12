<?php

namespace App\Http\Controllers\Api\MicroV1;

use App\Models\OrderModel;
use App\Models\Pay;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
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
     * @api {get} /pay/wxPay 微信方式支付
     * @apiVersion 1.0.0
     * @apiName Pay payOrder
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id  订单id
     * @apiParam {string} code  微信code值
     * @apiParam {string} token  token
     */
    public function wxPay(Request $request)
    {
        $code = $request->input('code');
        $order_id = $request->input('order_id');
        $pay_type = 1;
        $order = OrderModel::where('id', (int)$order_id)->first();
        if(!empty($order)){
            $total = $order->total_money;
        }else{
            return $this->response->array(ApiHelper::error('没有找到该订单', 404));
        }
        $pay_order = $this->createPayOrder('Micro商城订单', $total , $order_id , $pay_type);

        $WxPay = new WxPay();
        $jsApiParameter = $WxPay->wxPayApi($code , 'Micro商城订单' , $total*100 , $pay_order->uid);
        //获取签名
        $jsApiParameters = json_decode($jsApiParameter , true);
Log::info('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
        Log::info(Redis::get('wx_ticket'));
        Log::info($jsApiParameters['nonceStr']);
        Log::info($jsApiParameters['timeStamp']);
        $signature = sha1('jsapi_ticket='.Redis::get('wx_ticket').'&noncestr='.$jsApiParameters['nonceStr'].'&timestamp='.$jsApiParameters['timeStamp'].'&url='.config('wxpay.redirect_code_url').'?'.$_SERVER['QUERY_STRING']);

        $jsApiParameters['signature'] = $signature;
        Log::info($jsApiParameters);
        return $this->response->array(ApiHelper::success('Success', 200, compact('jsApiParameters')));

    }

    /**
     * @api {get} /pay/codeUrl 获取codeUrl
     * @apiVersion 1.0.0
     * @apiName Pay codeUrl
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id  订单id
     * @apiParam {string} token  token
     */
    public function codeUrl()
    {
        $redirectUrl = urlencode(config('wxpay.redirect_code_url').'?'.$_SERVER['QUERY_STRING']);
        $urlObj["appid"] = WxPayConfig::APPID;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        $url = "https://m.taihuoniao.com/promo/wx_proxy?".$bizString;
        return $this->response->array(ApiHelper::success('Success', 200, compact('url')));

    }

    /**
     * 创建需求 支付单
     * @param float $amount 支付金额
     * @param int $user_id 用户ID
     * @param string $summary 备注
     * @return mixed
     */
    protected function createPayOrder($summary = '', $amount, $order_id , $pay_type)
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
            'pay_type' => $pay_type,
        ]);
        return $pay_order;
    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}
