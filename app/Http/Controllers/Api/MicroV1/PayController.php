<?php

namespace App\Http\Controllers\Api\MicroV1;

use Illuminate\Http\Request;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;
use Libraries\WxPay\JsApiPay;
use Libraries\WxPay\lib\WxPayApi;
use Libraries\WxPay\lib\WxPayConfig;
use Libraries\WxPay\lib\WxPayJsApiPay;
use Libraries\WxPay\lib\WxPayUnifiedOrder;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class PayController extends BaseController
{

    /**
     * @api {get} /pay/demandWxPay 微信支付
     * @apiVersion 1.0.0
     * @apiName Pay WxPay
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id  订单ID
     * @apiParam {string} token token
     */
    public function demandWxPay(Request $request)
    {
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();
//        $openId = $tools->GetOpenidFromMp($_GET['code']);

        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");   //商品描述
        $input->SetAttach("test"); //附加信息
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));  //商品订单号
        $input->SetTotal_fee("1"); //商品费用  注意：以’分‘为单位
        $input->SetTime_start(date("YmdHis"));
        //$input->SetTime_expire(date("YmdHis", time() + 600));  直接去掉吧
        $input->SetGoods_tag("test"); //商品标记
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php"); //通知地址，官方文档中的notify.php，作用：处理支付成功后的订单状态及相关信息。
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        dd($order);
    }

}
