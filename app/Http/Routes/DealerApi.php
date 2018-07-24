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

    //获取用户信息
    $api->get('/DealerApi/auth/user', [
        'as' => 'auth.user', 'uses' => 'AuthenticateController@AuthUser'
    ]);
    //退出登录
    $api->post('/DealerApi/auth/logout', [
        'as' => 'Dealer.logout', 'uses' => 'AuthenticateController@logout'
    ]);
    //刷新token
    $api->post('/DealerApi/auth/upToken', [
        'as' => 'Dealer.upToken', 'uses' => 'AuthenticateController@upToken'
    ]);

    // 获取图片上传token
    $api->get('/DealerApi/tools/getToken', [
        'as' => 'Dealer.tool.getToken', 'uses' => 'ToolsController@getToken'
    ]);
    // 删除上传附件
    $api->post('/DealerApi/tools/deleteAsset', [
        'as' => 'Dealer.tool.deleteAsset', 'uses' => 'ToolsController@deleteAsset'
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

    //获取城市列表
    $api->get('/DealerApi/message/city', [
        'as' => 'Dealer.message.city', 'uses' => 'MessageController@city'
    ]);
    //查看下一级城市
    $api->get('/DealerApi/message/fetchCity', [
        'as' => 'Dealer.message.fetchCity', 'uses' => 'MessageController@fetchCity'
    ]);
    //获取商品分类列表
    $api->get('/DealerApi/message/category', [
        'as' => 'Dealer.message.category', 'uses' => 'MessageController@category'
    ]);
    //获取授权条件
    $api->get('/DealerApi/message/authorization', [
        'as' => 'Dealer.message.authorization', 'uses' => 'MessageController@authorization'
    ]);




//    // 获取经销商门店正面照片
//    $api->get('/DealerApi/tools/front', [
//        'as' => 'Dealer.tool.front', 'uses' => 'ToolsController@front'
//    ]);
//    // 获取经销商门店内部照片
//    $api->get('/DealerApi/tools/Inside', [
//        'as' => 'Dealer.tool.Inside', 'uses' => 'ToolsController@Inside'
//    ]);
//    // 获取身份证人像面照片
//    $api->get('/DealerApi/tools/portrait', [
//        'as' => 'Dealer.tool.portrait', 'uses' => 'ToolsController@portrait'
//    ]);
//    // 获取身份证国徽面照片
//    $api->get('/DealerApi/tools/national_emblem', [
//        'as' => 'Dealer.tool.national_emblem', 'uses' => 'ToolsController@national_emblem'
//    ]);
//    // 获取经销商营业执照照片
//    $api->get('/DealerApi/tools/license', [
//        'as' => 'Dealer.tool.license', 'uses' => 'ToolsController@license'
//    ]);


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


    //商品列表
    $api->get('/DealerApi/product/list', [
        'as' => 'Dealer.product.list', 'uses' => 'ProductsController@lists'
    ]);
    // 商品详情
    $api->get('/DealerApi/product/info', [
        'as' => 'Dealer.product.info', 'uses' => 'ProductsController@info'
    ]);


});