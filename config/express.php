<?php
/**
 * 快递鸟-快递接口
 */
return [
    
    'parter_id'   => 1266663,
    'api_key'     => '878b185d-df1a-4e50-bc99-7f6dc1d1d0ac',

    /**
     * 正式地址
     */
//    'request_url' => 'http://api.kdniao.cc/api/EOrderService',

    /**
     * 测试地址
     */
    'request_url' => 'http://testapi.kdniao.cc:8081/api/eorderservice',
    
    //申通电子面单账号 密码
//    'sto_key'  => '10002100013',
//    'sto_secret' => 'thn,0313',
//    'sto_SendSite' => '100021',
    //申通测试账号
    'sto_key' => 'teststo',
    'sto_secret' => 'teststopwd',
    'sto_SendSite' => 'teststosendsite',

];