<?php
/**
 * Created by PhpStorm.
 * User: cailiguang
 * Date: 2017/6/19
 * Time: 下午4:53
 */
/**
 * Api 路由
 */
$api = app('Dingo\Api\Routing\Router');

// V1版本，公有接口
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {


    // 用户注册
    $api->post('api/auth/register', [
        'as' => 'auth.register', 'uses' => 'AuthenticateController@register'
    ]);
    // 用户登录验证并返回Token
    $api->post('api/auth/login', [
        'as' => 'auth.login', 'uses' => 'AuthenticateController@login'
    ]);
    $api->post('api/auth/authenticate', [
        'as' => 'auth.authenticate', 'uses' => 'AuthenticateController@authenticate'
    ]);
    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.auth']], function($api) {
        //采购订单详情
        $api->get('/api/purchases/{purchase_id}', [
            'as' => 'purchases.index', 'uses' => 'PurchaseController@index'
        ]);
        //采购订单列表
        $api->get('/api/purchases', [
            'as' => 'purchases.lists', 'uses' => 'PurchaseController@lists'
        ]);

        //采购发票详情
        $api->get('/api/pInvoice/{pInvoice_id}', [
            'as' => 'pInvoice.index', 'uses' => 'PurchaseInvoiceController@index'
        ]);
        //采购发票列表
        $api->get('/api/pInvoices', [
            'as' => 'pInvoice.lists', 'uses' => 'PurchaseInvoiceController@lists'
        ]);

        //销售订单详情
        $api->get('/api/salesOrder/{salesOrder_id}', [
            'as' => 'salesOrder.index', 'uses' => 'SalesOrderController@index'
        ]);
        //销售订单列表
        $api->get('/api/salesOrders', [
            'as' => 'salesOrder.lists', 'uses' => 'SalesOrderController@lists'
        ]);

        //销售发票详情
        $api->get('/api/salesInvoice/{salesInvoice_id}', [
            'as' => 'salesInvoice.index', 'uses' => 'SalesInvoiceController@index'
        ]);
        //销售发票列表
        $api->get('/api/salesInvoices', [
            'as' => 'salesInvoice.lists', 'uses' => 'SalesInvoiceController@lists'
        ]);

        //电商销售订单详情
        $api->get('/api/ESSalesOrder/{ESSalesOrder_id}', [
            'as' => 'ESSales.index', 'uses' => 'ElectricitySupplierSalesOrderController@index'
        ]);
        //电商销售订单列表
        $api->get('/api/ESSalesOrders', [
            'as' => 'ESSales.lists', 'uses' => 'ElectricitySupplierSalesOrderController@lists'
        ]);
        //配送详情
        $api->get('/api/delivery/{delivery_id}', [
            'as' => 'delivery.index', 'uses' => 'DeliveryController@index'
        ]);
        //配送列表
        $api->get('/api/deliveries', [
            'as' => 'delivery.lists', 'uses' => 'DeliveryController@lists'
        ]);

        //根据供应商全称获取编号
        $api->get('/api/sup_name', [
            'as' => 'sup_name.lists', 'uses' => 'DeliveryController@sup_name'
        ]);
        //根据客户名称手机号获取编号
        $api->get('/api/membership', [
            'as' => 'membership.lists', 'uses' => 'SalesOrderController@membership'
        ]);

        //采购退货订单详情
        $api->get('/api/returnedPurchases/{returned_purchases_id}', [
            'as' => 'returnedPurchases.index', 'uses' => 'ReturnedPurchasesController@index'
        ]);
        //采购退货订单列表
        $api->get('/api/returnedPurchases', [
            'as' => 'returnedPurchases.lists', 'uses' => 'ReturnedPurchasesController@lists'
        ]);
    });
});