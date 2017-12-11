<?php

/**
 * 微信支付配置
 */
return [
    // 异步接收微信支付结果通知的回调地址，通知url必须为外网可访问的url，不能携带参数。
    'notify_url' => env('WXPAY_Notify_URL', 'http://fiu_m.taihuoniao.com/pay/wxPayNotify'),

    //前端微信codeUrl
    'redirect_code_url' => env('WXPAY_Code_URL' , 'http://fiu_m.taihuoniao.com/payment'),
];