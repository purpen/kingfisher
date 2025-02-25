<?php
/**
 * Api 路由
 */
$api = app('Dingo\Api\Routing\Router');

// V1版本，公有接口
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\DealerV1'], function ($api) {

//用户-------------------------------------------------------------------------------------------------------------------
    //图片验证码生成
    $api->get('/DealerApi/auth/createCapcha/{str}', [
        'as' => 'auth.createCapcha', 'uses' => 'AuthenticateController@createCapcha'
    ]);
    //图片验证码验证正确性
    $api->post('/DealerApi/auth/checkCaptcha', [
        'as' => 'auth.checkCaptcha', 'uses' => 'AuthenticateController@checkCaptcha'
    ]);
    //获取图片验证码路径
    $api->get('/DealerApi/auth/captchaUrl', [
        'as' => 'auth.captchaUrl', 'uses' => 'AuthenticateController@captchaUrl'
    ]);
    // 发票管理列表
    $api->get('/DealerApi/invoice', [
        'as' => 'invoice.invoice', 'uses' => 'InvoiceController@lists'
    ]);
    //普通发票和专票添加
    $api->post('/DealerApi/invoice/ordinaryAdd', [
        'as' => 'invoice.ordinaryAdd', 'uses' => 'InvoiceController@ordinaryAdd'
    ]);
    // 普通和专票发票删除
    $api->post('/DealerApi/invoice/deleted', [
        'as' => 'invoice.deleted', 'uses' => 'InvoiceController@deleted'
    ]);
    //普通发票和专票编辑展示与详情
    $api->post('/DealerApi/invoice/ordinaryList',[
        'as' => 'invoice.ordinaryList','uses' => 'InvoiceController@ordinaryList'
    ]);
     //普通发票和专票编辑
    $api->post('/DealerApi/invoice/ordinaryEdit',[
        'as' => 'invoice.ordinaryEdit','uses' => 'InvoiceController@ordinaryEdit'
    ]);

    //订单历史发票列表
    $api->get('/DealerApi/history/lists', [
        'as' => 'history.lists', 'uses' => 'HistoryInvoiceController@lists'
    ]);

    //发票记录申请
    $api->post('/DealerApi/history/application', [
        'as' => 'history.application', 'uses' => 'HistoryInvoiceController@application'
    ]);

    //查看普通增值税发票详情-弹框页面
    $api->get('/DealerApi/history/historyTo', [
        'as' => 'history.historyTo', 'uses' => 'HistoryInvoiceController@historyTo'
    ]);

    // 购物车列表
    $api->get('/DealerApi/cart', [
        'as' => 'cart.cart', 'uses' => 'CartController@lists'
    ]);
    // 获取购物车数量
    $api->get('/DealerApi/cart/fetch_count', [
        'as' => 'cart.fetch_count', 'uses' => 'CartController@fetch_count'
    ]);
    // 清空个人购物车
    $api->get('/DealerApi/cart/emptyShopping', [
        'as' => 'cart.emptyShopping', 'uses' => 'CartController@emptyShopping'
    ]);

    // 点击结算
    $api->post('/DealerApi/cart/settlement', [
        'as' => 'cart.settlement', 'uses' => 'CartController@settlement'
    ]);

    // 购物车增减单个产品数量
    $api->post('/DealerApi/cart/reduce', [
        'as' => 'cart.reduce', 'uses' => 'CartController@reduce'
    ]);

    // 添加购物车
    $api->post('/DealerApi/cart/add', [
        'as' => 'cart.add', 'uses' => 'CartController@add'
    ]);
    // 添加购物车
    $api->post('/DealerApi/cart/buy', [
        'as' => 'cart.buy', 'uses' => 'CartController@buy'
    ]);
    // 删除购物车
    $api->post('/DealerApi/cart/deleted', [
        'as' => 'cart.deleted', 'uses' => 'CartController@deleted'
    ]);



    // 用户注册
    $api->post('DealerApi/auth/register', [
        'as' => 'auth.register', 'uses' => 'AuthenticateController@register'
    ]);
    // 用户登录验证并返回Token
    $api->post('DealerApi/auth/login', [
        'as' => 'auth.login', 'uses' => 'AuthenticateController@login'
    ]);
    //刷新token
    $api->post('/DealerApi/auth/upToken', [
        'as' => 'Dealer.upToken', 'uses' => 'AuthenticateController@upToken'
    ]);
    $api->post('DealerApi/auth/authenticate', [
        'as' => 'auth.authenticate', 'uses' => 'AuthenticateController@authenticate'
    ]);
    $api->post('/DealerApi/auth/getRegisterCode', [
        'as' => 'auth.getRegisterCode', 'uses' => 'AuthenticateController@getRegisterCode'
    ]);


    // 删除上传附件
    $api->post('/DealerApi/tools/deleteAsset', [
        'as' => 'Dealer.tool.deleteAsset', 'uses' => 'ToolsController@deleteAsset'
    ]);
    // 获取图片上传token----------------------------------------------------------------------------------------------
    $api->get('/DealerApi/tools/getToken', [
        'as' => 'Dealer.tool.getToken', 'uses' => 'ToolsController@getToken'
    ]);

    //验证手机号是否存在
    $api->get('/DealerApi/auth/phone', [
        'as' => 'auth.phone', 'uses' => 'AuthenticateController@phone'
    ]);
    //验证用户名及图片验证码
    $api->post('/DealerApi/auth/account', [
        'as' => 'auth.account', 'uses' => 'AuthenticateController@account'
    ]);
    //验证注册短信验证码
    $api->post('/DealerApi/auth/verify', [
        'as' => 'auth.verify', 'uses' => 'AuthenticateController@verify'
    ]);
    // 忘记密码-获取手机验证码
    $api->post('/DealerApi/auth/getRetrieveCode', [
        'as' => 'Dealer.auth.getRetrieveCode', 'uses' => 'AuthenticateController@getRetrieveCode'
    ]);
    // 忘记密码-更改新密码
    $api->post('/DealerApi/auth/retrievePassword', [
        'as' => 'Dealer.auth.retrievePassword', 'uses' => 'AuthenticateController@retrievePassword'
    ]);



//经销商-----------------------------------------------------------------------------------------------------------------

    // 经销商填写信息
    $api->post('/DealerApi/message/addMessage', [
        'as' => 'Dealer.message.addMessage', 'uses' => 'MessageController@addMessage'
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


//个人中心---------------------------------------------------------------------------------------------------------------

    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.api.auth']], function($api) {


        //获取用户信息----------------------------------------------------------------------------------------------------
        $api->get('/DealerApi/auth/user', [
            'as' => 'auth.user', 'uses' => 'AuthenticateController@AuthUser'
        ]);
        //更新用户信息
        $api->post('/DealerApi/auth/updateUser', [
            'as' => 'auth.updateUser', 'uses' => 'AuthenticateController@updateUser'
        ]);
        //退出登录
        $api->post('/DealerApi/auth/logout', [
            'as' => 'Dealer.logout', 'uses' => 'AuthenticateController@logout'
        ]);



        //收藏/关注商品---------------------------------------------------------------------------------------------------
        $api->post('/DealerApi/product/follow', [
            'as' => 'Dealer.product.follow', 'uses' => 'ProductsController@follow'
        ]);
//        取消收藏/关注商品
        $api->post('/DealerApi/product/notFollow', [
            'as' => 'Dealer.product.notFollow', 'uses' => 'ProductsController@notFollow'
        ]);
//        收藏/关注商品列表
        $api->get('/DealerApi/product/followList', [
            'as' => 'Dealer.product.followList', 'uses' => 'ProductsController@followList'
        ]);
////      商品详情
        $api->get('/DealerApi/product/info', [
            'as' => 'Dealer.product.info', 'uses' => 'ProductsController@info'
        ]);
//        商品搜索
        $api->get('/DealerApi/product/search', [
            'as' => 'Dealer.product.search', 'uses' => 'ProductsController@search'
        ]);

        //获取经销商的商品分类
        $api->get('/DealerApi/product/categories', [
            'as' => 'Dealer.product.categories', 'uses' => 'ProductsController@categories'
        ]);

//        // 推荐的商品列表
        $api->get('/DealerApi/product/recommendList', [
            'as' => 'Dealer.product.recommendList', 'uses' => 'ProductsController@recommendList'
        ]);


        //订单列表-------------------------------------------------------------------------------------------------------
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
        //取消订单
        $api->post('/DealerApi/order/cancel',[
            'as' => 'Dealer.Order.cancel' , 'uses' => 'OrderController@cancel'
        ]);
        //确认收货
        $api->post('/DealerApi/order/confirm',[
            'as' => 'Dealer.Order.confirm' , 'uses' => 'OrderController@confirm'
        ]);
        //收银台
        $api->post('/DealerApi/order/pay_money',[
            'as' => 'Dealer.Order.pay_money' , 'uses' => 'OrderController@pay_money'
        ]);
        //上传凭证
        $api->post('/DealerApi/order/upload_img',[
            'as' => 'Dealer.Order.upload_img' , 'uses' => 'OrderController@upload_img'
        ]);
        //订单搜索
        $api->get('/DealerApi/order/search',[
            'as' => 'Dealer.Order.search' , 'uses' => 'OrderController@search'
        ]);

        // 经销商修改信息-------------------------------------------------------------------------------------------------
        $api->post('/DealerApi/message/updateMessage', [
            'as' => 'Dealer.message.updateMessage', 'uses' => 'MessageController@updateMessage'
        ]);

        // 经销商信息展示
        $api->get('/DealerApi/message/show', [
            'as' => 'Dealer.message.show', 'uses' => 'MessageController@show'
        ]);

        //获取全部商品分类列表
        $api->get('/DealerApi/message/category', [
            'as' => 'Dealer.message.category', 'uses' => 'MessageController@category'
        ]);

        //获取授权条件
        $api->get('/DealerApi/message/authorization', [
            'as' => 'Dealer.message.authorization', 'uses' => 'MessageController@authorization'
        ]);

        // 收货地址列表---------------------------------------------------------------------------------------------------
        $api->get('/DealerApi/address/list', [
            'as' => 'Dealer.address.list', 'uses' => 'AddressController@lists'
        ]);

        // 添加／编辑收货地址
        $api->post('/DealerApi/address/submit', [
            'as' => 'Dealer.address.submit', 'uses' => 'AddressController@submit'
        ]);
        // 收货地址详情
        $api->get('/DealerApi/address/show', [
            'as' => 'Dealer.address/show', 'uses' => 'AddressController@show'
        ]);
        // 删除收货地址
        $api->post('/DealerApi/address/deleted', [
            'as' => 'Dealer.address.deleted', 'uses' => 'AddressController@deleted'
        ]);
        // 设置默认地址
        $api->post('/DealerApi/address/defaulted', [
            'as' => 'Dealer.address.defaulted', 'uses' => 'AddressController@defaulted'
        ]);

        //返回支付页面
        $api->get('/DealerApi/pay' , ['as' => 'Dealer.pay' , 'uses' => 'PayController@pay']);
        //查询账单
        $api->get('/DealerApi/search' , ['as' => 'Dealer.search' , 'uses' => 'PayController@search']);
        //退款
        $api->get('/DealerApi/refund' , ['as' => 'Dealer.refund' , 'uses' => 'PayController@refund']);

    });
    //支付宝异步回调接口
    $api->post('/DealerApi/pay/make_sure', ['as' => 'pay.make_sure', 'uses' => 'PayController@make_sure']);
    //支付宝同步回调接口
    $api->post('/DealerApi/pay/alipayReturn', ['as' => 'pay.alipayReturn', 'uses' => 'PayController@alipayReturn']);

});