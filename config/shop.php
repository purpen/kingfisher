<?php

/**
 * 自营商城相关配置
 */
    return [
        //自营商城url
        'url' => 'http://t.taihuoniao.com',

        //商品列表接口url
        'product_list' => '/app/api/erp/product_list',

        //订单接口url
        'order_list' => '/app/api/erp/order_list',

        //发货接口url
        'send_goods' => '/app/api/erp/send_goods',

        //Sku 库存数量 同步接口
        'sku_quantity' => '/app/api/erp/update_inventory',

        //sku列表接口url
        'product_sku_list' => '/app/api/erp/sku_list',

        //拆单同步url
        'split_order_info' => '/app/api/erp/split_order',
    ];
