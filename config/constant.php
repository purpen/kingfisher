<?php

/**
 * 常量配置
 */

return [
    'web_url' => env('WEB_URL'),
    'h5_url' => env('H5_URL'),
    'user_id_sales' => env('USER_ID_SALES'),
//    'user_id_sales' => 34,
    'store_id' => env('STORE_ID'),
    'storage_id' => env('STORAGE_ID'),

//    为经销商订单接口加的：
    'D3IN_user_id_sales' => env('D3IN_USER_ID_SALES'),
    'D3IN_store_id' => env('D3IN_STORE_ID'),
    'D3IN_storage_id' => env('D3IN_STORAGE_ID'),
    'D3IN_over_time' => env('D3IN_OVER_TIME'),

    'sku_count' => 10000,
    // 城市列表
    'city' => [
        1 => "北京",
        2 => "新疆",
        3 => "重庆",
        4 => "广东",
        5 => "天津",
        6 => "浙江",
        7 => "港澳",
        8 => "广西",
        9 => "内蒙古",
        10 => "宁夏",
        11 => "江西",
        12 => "台湾",
        13 => "安徽",
        14 => "贵州",
        15 => "陕西",
        16 => "辽宁",
        17 => "山西",
        18 => "青海",
        19 => "四川",
        20 => "江苏",
        21 => "河北",
        22 => "西藏",
        23 => "钓鱼岛",
        24 => "福建",
        25 => "吉林",
        26 => "上海",
        27 => "湖北",
        28 => "海南",
        29 => "云南",
        30 => "甘肃",
        31 => "湖南",
        32 => "山东",
        33 => "河南",
        34 => "黑龙江",
    ],


    //证件类型
    'document_type' => [
        1 => '身份证',
        2 => '港澳通行证',
        3 => '台胞证',
        4 => '护照',
    ],

];