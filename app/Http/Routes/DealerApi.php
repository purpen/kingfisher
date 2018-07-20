<?php
/**
 * Api 路由
 */
$api = app('Dingo\Api\Routing\Router');

// V1版本，公有接口
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\DealerV1'], function ($api) {

    // 用户注册
    $api->post('DealerApi/auth/register', [
        'as' => 'auth.register', 'uses' => 'AuthenticateController@register'
    ]);
    // 用户登录验证并返回Token
    $api->post('DealerApi/auth/login', [
        'as' => 'auth.login', 'uses' => 'AuthenticateController@login'
    ]);
    $api->post('DealerApi/auth/authenticate', [
        'as' => 'auth.authenticate', 'uses' => 'AuthenticateController@authenticate'
    ]);
    $api->post('/DealerApi/auth/getRegisterCode', [
        'as' => 'auth.getRegisterCode', 'uses' => 'AuthenticateController@getRegisterCode'
    ]);
    //验证手机号是否存在
    $api->get('/DealerApi/auth/phone', [
        'as' => 'auth.phone', 'uses' => 'AuthenticateController@phone'
    ]);
    // 忘记密码-获取手机验证码
    $api->post('/DealerApi/auth/getRetrieveCode', [
        'as' => 'Dealer.auth.getRetrieveCode', 'uses' => 'AuthenticateController@getRetrieveCode'
    ]);
    // 忘记密码-更改新密码
    $api->post('/DealerApi/auth/retrievePassword', [
        'as' => 'Dealer.auth.retrievePassword', 'uses' => 'AuthenticateController@retrievePassword'
    ]);

    //退出登录
    $api->post('/DealerApi/auth/logout', [
        'as' => 'Dealer.logout', 'uses' => 'AuthenticateController@logout'
    ]);
    //刷新token
    $api->post('/DealerApi/auth/upToken', [
        'as' => 'Dealer.upToken', 'uses' => 'AuthenticateController@upToken'
    ]);

    // 经销商信息展示
    $api->get('/DealerApi/message/show', [
        'as' => 'Dealer.message.show', 'uses' => 'MessageController@show'
    ]);
    // 经销商填写信息
    $api->post('/DealerApi/message/addMessage', [
        'as' => 'Dealer.message.addMessage', 'uses' => 'MessageController@addMessage'
    ]);
    // 经销商修改信息
    $api->post('/DealerApi/message/updateMessage', [
        'as' => 'Dealer.message.updateMessage', 'uses' => 'MessageController@updateMessage'
    ]);
    // 收货地址列表
    $api->get('/DealerApi/address/list', [
        'as' => 'Dealer.address.list', 'uses' => 'AddressController@lists'
    ]);
    // 收货地址详情
    $api->get('/DealerApi/address/show', [
        'as' => 'Dealer.address/show', 'uses' => 'AddressController@show'
    ]);
    // 添加／编辑收货地址
    $api->post('/DealerApi/address/submit', [
        'as' => 'Dealer.address.submit', 'uses' => 'AddressController@submit'
    ]);
    // 删除收货地址
    $api->post('/DealerApi/address/deleted', [
        'as' => 'Dealer.address.deleted', 'uses' => 'AddressController@deleted'
    ]);
    // 设置默认地址
    $api->post('/DealerApi/address/defaulted', [
        'as' => 'Dealer.address.defaulted', 'uses' => 'AddressController@defaulted'
    ]);


});