<?php
/**
 * Created by PhpStorm.
 * User: cailiguang
 * Date: 2017/11/16
 * Time: 上午9:31
 */
$api = app('Dingo\Api\Routing\Router');

// V1版本，公有接口
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\MicroV1'], function ($api) {
    // 用户注册
    $api->post('/MicroApi/auth/register', [
        'as' => 'auth.register', 'uses' => 'AuthenticateController@register'
    ]);
    // 用户登录验证并返回Token
    $api->post('/MicroApi/auth/login', [
        'as' => 'auth.login', 'uses' => 'AuthenticateController@login'
    ]);
    $api->post('/MicroApi/auth/authenticate', [
        'as' => 'auth.authenticate', 'uses' => 'AuthenticateController@authenticate'
    ]);
    $api->post('/MicroApi/auth/getRegisterCode', [
        'as' => 'auth.getRegisterCode', 'uses' => 'AuthenticateController@getRegisterCode'
    ]);
    //验证手机号是否存在
    $api->get('/MicroApi/auth/phone', [
        'as' => 'auth.phone', 'uses' => 'AuthenticateController@phone'
    ]);
    // 忘记密码-获取手机验证码
    $api->post('/MicroApi/auth/getRetrieveCode', [
        'as' => 'Micro.auth.getRetrieveCode', 'uses' => 'AuthenticateController@getRetrieveCode'
    ]);
    // 忘记密码-更改新密码
    $api->post('/MicroApi/auth/retrievePassword', [
        'as' => 'Micro.auth.retrievePassword', 'uses' => 'AuthenticateController@retrievePassword'
    ]);

    //微信获取code接口
    $api->get('/pay/code', ['as' => 'pay.code', 'uses' => 'PayController@code']);

    /**
     *  商品列表
     */
    $api->get('/MicroApi/product/lists', [
        'as' => 'Micro.product.list', 'uses' => 'ProductsController@lists'
    ]);

    // 商品详情
    $api->get('/MicroApi/product', [
        'as' => 'MicroApi.product', 'uses' => 'ProductsController@product'
    ]);

    //选择支付页面
    $api->get('/pay/payOrder' , ['as' => 'pay.pays' , 'uses' => 'PayController@pays']);

    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.api.auth']], function($api) {

        // 修改密码
        $api->post('/MicroApi/auth/changePassword', [
            'as' => 'Micro.auth.changePassword', 'uses' => 'AuthenticateController@changePassword'
        ]);

        //退出登录
        $api->post('/MicroApi/auth/logout', [
            'as' => 'Micro.logout', 'uses' => 'AuthenticateController@logout'
        ]);
        //刷新token
        $api->post('/MicroApi/auth/upToken', [
            'as' => 'Micro.upToken', 'uses' => 'AuthenticateController@upToken'
        ]);



        // 购物车列表
        $api->get('/MicroApi/cart', [
            'as' => 'MicroApi.cart', 'uses' => 'CartController@lists'
        ]);
        // 获取购物车数量
        $api->get('/MicroApi/cart/fetch_count', [
            'as' => 'MicroApi.cart.fetch_count', 'uses' => 'CartController@fetch_count'
        ]);
        // 添加购物车
        $api->post('/MicroApi/cart/add', [
            'as' => 'MicroApi.cart.add', 'uses' => 'CartController@add'
        ]);
        // 删除购物车
        $api->post('/MicroApi/cart/deleted', [
            'as' => 'MicroApi.cart.deleted', 'uses' => 'CartController@deleted'
        ]);
        // 编辑购物车
        $api->post('/MicroApi/cart/edit', [
            'as' => 'MicroApi.cart.edit', 'uses' => 'CartController@edit'
        ]);


        //分销商详情
        $api->get('/MicroApi/distributor', [
            'as' => 'MicroApi.distributor', 'uses' => 'DistributorController@distributor'
        ]);


        //订单列表
        $api->get('/MicroApi/order/lists', [
            'as' => 'MicroApi.order.lists', 'uses' => 'OrderController@lists'
        ]);
        //订单详情
        $api->get('/MicroApi/order', [
            'as' => 'MicroApi.order', 'uses' => 'OrderController@order'
        ]);
        //删除订单
        $api->get('/MicroApi/order/delete', [
            'as' => 'MicroApi.order.delete', 'uses' => 'OrderController@delete'
        ]);
        //直接下单
        $api->post('/MicroApi/order/store', [
            'as' => 'MicroApi.order.store', 'uses' => 'OrderController@store'
        ]);
        //购物车下单
        $api->post('/MicroApi/order/microStore', [
            'as' => 'MicroApi.order.microStore', 'uses' => 'OrderController@microStore'
        ]);

        // 收货地址列表
        $api->get('/MicroApi/delivery_address/list', [
            'as' => 'MicroApi.delivery_address/list', 'uses' => 'DeliveryAddressController@lists'
        ]);
        // 收货地址详情
        $api->get('/MicroApi/delivery_address/show', [
            'as' => 'MicroApi.delivery_address/show', 'uses' => 'DeliveryAddressController@show'
        ]);
        // 添加／编辑收货地址
        $api->post('/MicroApi/delivery_address/submit', [
            'as' => 'MicroApi.delivery_address.submit', 'uses' => 'DeliveryAddressController@submit'
        ]);
        // 删除收货地址
        $api->post('/MicroApi/delivery_address/deleted', [
            'as' => 'MicroApi.delivery_address.deleted', 'uses' => 'DeliveryAddressController@deleted'
        ]);
        // 设置默认地址
        $api->post('/MicroApi/delivery_address/defaulted', [
            'as' => 'MicroApi.delivery_address.defaulted', 'uses' => 'DeliveryAddressController@defaulted'
        ]);



        //支付宝异步回调接口
        $api->post('/pay/aliPayNotify', ['as' => 'pay.aliPayNotify', 'uses' => 'PayController@aliPayNotify']);

        // 微信异步回调接口
        $api->post('/pay/wxPayNotify', ['as' => 'pay.wxPayNotify', 'uses' => 'PayController@wxPayNotify']);


    });

});
