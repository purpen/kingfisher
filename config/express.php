<?php
/**
 * 快递鸟-快递接口
 */
return [

    'parter_id' => 1266663,
    'api_key' => '878b185d-df1a-4e50-bc99-7f6dc1d1d0ac',

    // 电子面单请求地址
    'request_url' => env('KDN_REQUEST_URL', 'http://api.kdniao.cc/api/EOrderService'),

    // 物流信息订阅url
    'dist_url' => env('DIST_URL', 'http://api.kdniao.cc/api/dist'),

    //申通电子面单账号 密码
    'sto_key' => env('STO_KEY', '10002100013'),
    'sto_secret' => env('STO_SECRET', 'thn,0313'),
    'sto_SendSite' => env('STO_SENDSITE', '100021'),

    // 物流状态
    'state' => [
        '0' => '无轨迹',
        '1' => '已揽收',
        '2' => '在途中',
        '201' => '到达派件城市',
        '3' => '签收',
        '4' => '问题件',
    ],

    /**
     * 正式地址
     */
//    'request_url' => 'http://api.kdniao.cc/api/EOrderService',
    
    //申通电子面单账号 密码
//    'sto_key'  => '10002100013',
//    'sto_secret' => 'thn,0313',
//    'sto_SendSite' => '100021',


    /**
     * 测试地址
     */
//    'request_url' => 'http://testapi.kdniao.cc:8081/api/eorderservice',
    //申通测试账号
//    'sto_key' => 'teststo',
//    'sto_secret' => 'teststopwd',
//    'sto_SendSite' => 'teststosendsite',

];