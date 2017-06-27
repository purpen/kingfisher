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
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\SaasV1'], function ($api) {

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
    $api->post('/api/auth/getRegisterCode', [
        'as' => 'auth.getRegisterCode', 'uses' => 'AuthenticateController@getRegisterCode'
    ]);
    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.api.auth']], function($api) {

        // 推荐的商品列表
        $api->get('/saasApi/product/recommendList', [
            'as' => 'saas.product.list', 'uses' => 'ProductsController@recommendList'
        ]);

        // 商品详情
        $api->get('/saasApi/product/info', [
            'as' => 'saas.product.info', 'uses' => 'ProductsController@info'
        ]);
        // 确认合作商品
        $api->post('/saasApi/product/trueCooperate', [
            'as' => 'saas.product.trueCooperate', 'uses' => 'ProductsController@trueCooperate'
        ]);
        // 合作的商品列表
        $api->get('/saasApi/product/cooperateProductLists', [
            'as' => 'saas.product.cooperateProductLists', 'uses' => 'ProductsController@cooperateProductLists'
        ]);

    });
});