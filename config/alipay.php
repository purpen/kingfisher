<?php
//$config = array (
    return [
		//应用ID,您的APPID。
		'app_id' => "2018091761417220",

		//商户私钥
        'merchant_private_key' =>env('ALIPAY_Merchant_Private_Key'),

		//异步通知地址
        'notify_url' => env('ALIPAY_Notify_URL','https://erp.taihuoniao.com/DealerApi/pay/make_sure'),
		//同步跳转
        'return_url' => env('ALIPAY_Return_URL' , 'http://d3in.taihuoniao.com/center/order/monthorderlist/1/0/1'),

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.Alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' =>env('ALIPAY_Alipay_Public_Key'),
//);
];