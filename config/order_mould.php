<?php

/**
 * 订单模版配置
 * field: 字段名称；name: 字段说明；isNull: 是否可为空；isUnique: 是否唯一；default: 默认值；
 */

return [
    // 站外订单编号
    'OUT_ORDER_ID' => array(
        'field' => 'outside_target_id',
        'name' => '站外订单号',
        'isNull' => false,
        'isUnique' => true,
        'default' => '',
    ),
    // 商品sku编号
    'P_SKU_NUMBER' => array(
        'field' => 'sku_number',
        'name' => '商品SKU编号',
        'isNull' => false,
        'isUnique' => false,
        'default' => '',
    ),
    // 商品数量
    'COUNT' => array(
        'field' => 'count',
        'name' => '商品数量',
        'isNull' => true,
        'isUnique' => false,
        'default' => 1,
    ),
    // 收货人姓名
    'BUYER_NAME' => array(
        'field' => 'buyer_name',
        'name' => '收货人姓名',
        'isNull' => false,
        'isUnique' => false,
        'default' => '',
    ),
    // 收货人电话
    'BUYER_TEL' => array(
        'field' => 'buyer_tel',
        'name' => '收货人电话',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),
    // 收货人手机
    'BUYER_PHONE' => array(
        'field' => 'buyer_phone',
        'name' => '收货人手机',
        'isNull' => false,
        'isUnique' => false,
        'default' => '',
    ),
    // 邮编
    'ZIP' => array(
        'field' => 'buyer_zip',
        'name' => '邮编',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),
    // 省份/自治区
    'PROVINCE' => array(
        'field' => 'buyer_province',
        'name' => '省/自治区',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),
    // 城市
    'CITY' => array(
        'field' => 'buyer_city',
        'name' => '市',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),
    // 县
    'COUNTY' => array(
        'field' => 'buyer_county',
        'name' => '县',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),
    // 镇/乡
    'TOWN' => array(
        'field' => 'buyer_township',
        'name' => '镇/乡',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),
    // 详细地址
    'ADDRESS' => array(
        'field' => 'buyer_address',
        'name' => '详细地址',
        'isNull' => false,
        'isUnique' => false,
        'default' => '',
    ),
    // 买家备注
    'BUYER_SUMMARY' => array(
        'field' => 'buyer_summary',
        'name' => '镇/乡',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),
    // 卖家备注
    'SELLER_SUMMARY' => array(
        'field' => 'seller_summary',
        'name' => '详细地址',
        'isNull' => false,
        'isUnique' => false,
        'default' => '',
    ),
    // 订单创建时间
    'CREATE_TIME' => array(
        'field' => 'created_time',
        'name' => '订单创建时间',
        'isNull' => true,
        'isUnique' => false,
        'default' => '',
    ),

];
