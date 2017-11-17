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
    });

});
