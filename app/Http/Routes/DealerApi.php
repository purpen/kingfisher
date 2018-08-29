<?php
/**
 * Api 路由
 */
$api = app('Dingo\Api\Routing\Router');

// V1版本，公有接口
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\DealerV1'], function ($api) {

//用户-------------------------------------------------------------------------------------------------------------------
    //图片验证码生成
    $api->get('/DealerApi/auth/createCapcha', [
        'as' => 'auth.createCapcha', 'uses' => 'AuthenticateController@createCapcha'
    ]);
    //图片验证码验证正确性
    $api->post('/DealerApi/auth/captcha', [
        'as' => 'auth.captcha', 'uses' => 'AuthenticateController@captcha'
    ]);
    //获取图片验证码路径
    $api->get('/DealerApi/auth/captchaUrl', [
        'as' => 'auth.captchaUrl', 'uses' => 'AuthenticateController@captchaUrl'
    ]);

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

    //验证手机号是否存在
    $api->get('/DealerApi/auth/phone', [
        'as' => 'auth.phone', 'uses' => 'AuthenticateController@phone'
    ]);
    //验证用户名及图片验证码
    $api->post('/DealerApi/auth/account', [
        'as' => 'auth.account', 'uses' => 'AuthenticateController@account'
    ]);
    // 忘记密码-获取手机验证码
    $api->post('/DealerApi/auth/getRetrieveCode', [
        'as' => 'Dealer.auth.getRetrieveCode', 'uses' => 'AuthenticateController@getRetrieveCode'
    ]);
    // 忘记密码-更改新密码
    $api->post('/DealerApi/auth/retrievePassword', [
        'as' => 'Dealer.auth.retrievePassword', 'uses' => 'AuthenticateController@retrievePassword'
    ]);

//上传-------------------------------------------------------------------------------------------------------------------
    // 获取图片上传token
    $api->get('/DealerApi/tools/getToken', [
        'as' => 'Dealer.tool.getToken', 'uses' => 'ToolsController@getToken'
    ]);
    // 删除上传附件
    $api->post('/DealerApi/tools/deleteAsset', [
        'as' => 'Dealer.tool.deleteAsset', 'uses' => 'ToolsController@deleteAsset'
    ]);


//经销商-----------------------------------------------------------------------------------------------------------------
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

    //获取省列表
    $api->get('/DealerApi/message/city', [
        'as' => 'Dealer.message.city', 'uses' => 'MessageController@city'
    ]);
    //查看下一级城市
    $api->get('/DealerApi/message/fetchCity', [
        'as' => 'Dealer.message.fetchCity', 'uses' => 'MessageController@fetchCity'
    ]);
    //查看下一级区县
    $api->get('/DealerApi/message/county', [
        'as' => 'Dealer.message.county', 'uses' => 'MessageController@county'
    ]);
    //查看下一级城镇
    $api->get('/DealerApi/message/town', [
        'as' => 'Dealer.message.town', 'uses' => 'MessageController@town'
    ]);
    //获取商品分类列表
    $api->get('/DealerApi/message/category', [
        'as' => 'Dealer.message.category', 'uses' => 'MessageController@category'
    ]);
    //获取授权条件
    $api->get('/DealerApi/message/authorization', [
        'as' => 'Dealer.message.authorization', 'uses' => 'MessageController@authorization'
    ]);


//收货地址---------------------------------------------------------------------------------------------------------------
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

//商品-------------------------------------------------------------------------------------------------------------------

    //收藏/关注商品
    $api->post('/DealerApi/product/follow', [
        'as' => 'Dealer.product.follow', 'uses' => 'ProductsController@follow'
    ]);
    //取消收藏/关注商品
    $api->post('/DealerApi/product/notFollow', [
        'as' => 'Dealer.product.notFollow', 'uses' => 'ProductsController@notFollow'
    ]);
    //收藏/关注商品列表
    $api->get('/DealerApi/product/followList', [
        'as' => 'Dealer.product.followList', 'uses' => 'ProductsController@followList'
    ]);
    // 商品详情
    $api->get('/DealerApi/product/info', [
        'as' => 'Dealer.product.info', 'uses' => 'ProductsController@info'
    ]);
    // 商品搜索
    $api->get('/DealerApi/product/search', [
        'as' => 'Dealer.product.search', 'uses' => 'ProductsController@search'
    ]);
    // 推荐的商品列表
    $api->get('/DealerApi/product/recommendList', [
        'as' => 'Dealer.product.recommendList', 'uses' => 'ProductsController@recommendList'
    ]);

//购物车-----------------------------------------------------------------------------------------------------------------
//    // 购物车列表
//    $api->get('/DealerApi/cart', [
//        'as' => 'Dealer.cart', 'uses' => 'CartController@lists'
//    ]);




//订单-------------------------------------------------------------------------------------------------------------------
    //订单列表
    $api->get('/DealerApi/orders', [
        'as' => 'Dealer.order.lists', 'uses' => 'OrderController@orders'
    ]);
    //订单详情
    $api->get('/DealerApi/order',[
        'as' => 'Dealer.Order.order' , 'uses' => 'OrderController@order'
    ]);
    //保存订单
    $api->post('/DealerApi/order/store',[
        'as' => 'Dealer.Order.store' , 'uses' => 'OrderController@store'
    ]);
    //删除订单
    $api->post('/DealerApi/order/destroy',[
        'as' => 'Dealer.Order.destroy' , 'uses' => 'OrderController@destroy'
    ]);




});