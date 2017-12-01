<?php
namespace Libraries\WxPay;

use Illuminate\Support\Facades\Log;
use Libraries\WxPay\lib\WxPayApi;
use Libraries\WxPay\lib\WxPayConfig;
use Libraries\WxPay\lib\WxPayUnifiedOrder;
include_once __DIR__ . "/lib/WxPayData.php";

/**
 *
 * 微信扫码支付实现类
 * @author widyhu
 *
 */
class WxPay
{
    /**
     * 微信支付扫码支付
     *
     * @param int $order_id  订单ID
     */
    public function wxPayApi($order_id)
    {
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();
        Log::ingo($openId);
//        $openId = $tools->GetOpenidFromMp($_GET['code']);

        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");   //商品描述
        $input->SetAttach("test"); //附加信息
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));  //商品订单号
        $input->SetTotal_fee("1"); //商品费用  注意：以’分‘为单位
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test"); //商品标记
        $input->SetNotify_url(config('wxpay.notify_url')); //通知地址，官方文档中的notify.php，作用：处理支付成功后的订单状态及相关信息。
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
    }


}