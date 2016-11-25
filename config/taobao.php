<?php

/**
 * 淘宝平台sdk配置
 */
return [
//    'appKey' => '1023538050',
    'appKey' => '23538050',
    
//    'secretKey' => 'sandbox2309248aabbcdd0e97b4bca90',
    'secretKey' => '9c073ac2309248aabbcdd0e97b4bca90',
    /**
     * api请求地址
     */
//    'gatewayUrl' => 'http://gw.api.tbsandbox.com/router/rest',
    'gatewayUrl' => 'https://eco.taobao.com/router/rest',

    /**
     * 数据格式
     */
    'format' => 'json',

    /**
     * 授权页面地址
     */
//    'authorize_url' => 'https://oauth.tbsandbox.com/authorize',
    'authorize_url' => 'https://oauth.taobao.com/authorize',

    /**
     * 授权token请求地址
     */
//    'token_url' => 'https://oauth.tbsandbox.com/token',
    'token_url' => 'https://oauth.taobao.com/token',
    /**
     * 授权回调地址
     */
    'redirect_uri' => 'http://erp.com/TBCallUrl',
];