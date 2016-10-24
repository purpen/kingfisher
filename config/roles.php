<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 用户角色设置
    |--------------------------------------------------------------------------
    |
    | 设置系统用户角色身份
    |
    */

    'admin' => [
        'name' => 'admin',
        'display_name' => '管理员',
        'description' => '管理员角色，负责进行系统管理及安装配置等'
    ],
    
    'director' => [
        'name' => 'director',
        'display_name' => '运营总监',
        'description' => '运营角色，进行商品、订单、发货、物流等操作'
    ],
    
    'shopkeeper' => [
        'name' => 'shopkeeper',
        'display_name' => '运营店长',
        'description' => '店长角色，进行商品、订单等运营操作'
    ],
    
    'servicer' => [
        'name' => 'servicer',
        'display_name' => '客服专员',
        'description' => '客服角色，进行订单、发货、物流等操作'
    ],
    
    'buyer' => [
        'name' => 'buyer',
        'display_name' => '采购专员',
        'description' => '采购角色，进行商品、采购、物流等操作'
    ],
    
    'storekeeper' => [
        'name' => 'storekeeper',
        'display_name' => '库管员',
        'description' => '库管角色，进行仓库管理、收货、入库、盘点等操作'
    ],
    
    'financer' => [
        'name' => 'financer',
        'display_name' => '财务专员',
        'description' => '财务角色，进行收款、付款、对账、结算、报表等操作'
    ],
    
    'supplier' => [
        'name' => 'supplier',
        'display_name' => '供应商',
        'description' => '供应商角色，进行选品、下单、物流查看等操作'
    ],
    
    
];
