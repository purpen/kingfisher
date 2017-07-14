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
    $api->post('/saasApi/auth/register', [
        'as' => 'auth.register', 'uses' => 'AuthenticateController@register'
    ]);
    // 用户登录验证并返回Token
    $api->post('/saasApi/auth/login', [
        'as' => 'auth.login', 'uses' => 'AuthenticateController@login'
    ]);
    $api->post('/saasApi/auth/authenticate', [
        'as' => 'auth.authenticate', 'uses' => 'AuthenticateController@authenticate'
    ]);
    $api->post('/saasApi/auth/getRegisterCode', [
        'as' => 'auth.getRegisterCode', 'uses' => 'AuthenticateController@getRegisterCode'
    ]);
    //验证手机号是否存在
    $api->get('/saasApi/auth/phone', [
        'as' => 'auth.phone', 'uses' => 'AuthenticateController@phone'
    ]);
    //获取用户信息
    $api->get('/saasApi/auth/user', [
        'as' => 'auth.user', 'uses' => 'AuthenticateController@AuthUser'
    ]);
    //商品素材库文章添加
    $api->post('/saasApi/product/articleStore', [
        'as' => 'saas.MaterialLibrary.articleStore', 'uses' => 'MaterialLibrariesController@articleStore'
    ]);
    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.api.auth']], function($api) {
        //退出登录
        $api->post('/saasApi/auth/logout', [
            'as' => 'auth.logout', 'uses' => 'AuthenticateController@logout'
        ]);
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


        //商品素材库文字列表
        $api->get('/saasApi/product/describeLists', [
            'as' => 'saas.MaterialLibrary.describeLists', 'uses' => 'MaterialLibrariesController@describeLists'
        ]);
        //商品素材库文字详情
        $api->get('/saasApi/product/describe', [
            'as' => 'saas.MaterialLibrary.describe', 'uses' => 'MaterialLibrariesController@describe'
        ]);
        //商品素材库图片列表
        $api->get('/saasApi/product/imageLists', [
            'as' => 'saas.MaterialLibrary.imageLists', 'uses' => 'MaterialLibrariesController@imageLists'
        ]);
        //商品素材库图片详情
        $api->get('/saasApi/product/image', [
            'as' => 'saas.MaterialLibrary.image', 'uses' => 'MaterialLibrariesController@image'
        ]);
        //商品素材库视频列表
        $api->get('/saasApi/product/videoLists', [
            'as' => 'saas.MaterialLibrary.videoLists', 'uses' => 'MaterialLibrariesController@videoLists'
        ]);
        //商品素材库视频详情
        $api->get('/saasApi/product/video', [
            'as' => 'saas.MaterialLibrary.video', 'uses' => 'MaterialLibrariesController@video'
        ]);
        // 账户概况
        $api->get('/saasApi/survey/index', [
            'as' => 'saas.survey.index', 'uses' => 'SurveyController@index'
        ]);
        // 销售趋势
        $api->get('/saasApi/survey/salesTrends', [
            'as' => 'saas.survey.salesTrends', 'uses' => 'SurveyController@salesTrends'
        ]);
        // 订单地域分布
        $api->get('/saasApi/survey/orderDistribution', [
            'as' => 'saas.survey.orderDistribution', 'uses' => 'SurveyController@orderDistribution'
        ]);
        // 24小时时间段销售统计
        $api->get('/saasApi/survey/hourOrder', [
            'as' => 'saas.survey.hourOrder', 'uses' => 'SurveyController@hourOrder'
        ]);
        //商品销售排行
        $api->get('/saasApi/survey/salesRanking', [
            'as' => 'saas.survey.salesRanking', 'uses' => 'SurveyController@salesRanking'
        ]);
        // 重复购买率
        $api->get('/saasApi/survey/repeatPurchase', [
            'as' => 'saas.survey.repeatPurchase', 'uses' => 'SurveyController@repeatPurchase'
        ]);
        // 客单价分布
        $api->get('/saasApi/survey/customerPriceDistribution', [
            'as' => 'saas.survey.customerPriceDistribution', 'uses' => 'SurveyController@customerPriceDistribution'
        ]);
        // TOP20标签
        $api->get('/saasApi/survey/topFlag', [
            'as' => 'saas.survey.topFlag', 'uses' => 'SurveyController@topFlag'
        ]);

        //商品素材库文章列表
        $api->get('/saasApi/product/articleLists', [
            'as' => 'saas.MaterialLibrary.articleLists', 'uses' => 'MaterialLibrariesController@articleLists'
        ]);
        //商品素材库文章详情
        $api->get('/saasApi/product/article', [
            'as' => 'saas.MaterialLibrary.article', 'uses' => 'MaterialLibrariesController@article'
        ]);
        // 销售渠道
        $api->get('/saasApi/survey/sourceSales', [
            'as' => 'saas.survey.sourceSales', 'uses' => 'SurveyController@sourceSales'
        ]);


    });
});