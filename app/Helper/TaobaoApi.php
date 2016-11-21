<?php
/**
 * 淘宝api接口类
 */
namespace App\Helper;

include(dirname(__FILE__) . '/../Libraries/TaoBaoSdk/TopSdk.php');

class TaobaoApi
{
    /**
     * 淘宝api初始
     * @return \TopClient
     */
    public function tbClient()
    {
        $c = new \TopClient;
        $c->appkey = config('taobao.app_key');
        $c->secretKey = config('taobao.secretKey');
        //请求地址
        $c->gatewayUrl = config('taobao.gatewayUrl');
        //数据格式
        $c->format = config('taobao.format');
        return $c;
    }


}