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
    // 忘记密码-获取手机验证码
    $api->post('/saasApi/auth/getRetrieveCode', [
        'as' => 'saas.auth.getRetrieveCode', 'uses' => 'AuthenticateController@getRetrieveCode'
    ]);
    // 忘记密码-更改新密码
    $api->post('/saasApi/auth/retrievePassword', [
        'as' => 'saas.auth.retrievePassword', 'uses' => 'AuthenticateController@retrievePassword'
    ]);

    //商品素材库文章添加
    $api->post('/saasApi/product/articleStore', [
        'as' => 'saas.MaterialLibrary.articleStore', 'uses' => 'MaterialLibrariesController@articleStore'
    ]);

    // 站点列表
    $api->get('/saasApi/site/getList', [
        'as' => 'saas.site.list', 'uses' => 'SiteController@getList'
    ]);
    // 站点详情
    $api->get('/saasApi/site/show', [
        'as' => 'saas.site.show', 'uses' => 'SiteController@show'
    ]);
    // 站点爬取记录列表
    $api->get('/saasApi/site_record/getList', [
        'as' => 'saas.site_record.list', 'uses' => 'SiteRecordController@getList'
    ]);
    // 站点爬取记录详情
    $api->get('/saasApi/site_record/show', [
        'as' => 'saas.site_record.show', 'uses' => 'SiteRecordController@show'
    ]);
    // 站点记录创建
    $api->post('/saasApi/site_record/store', [
        'as' => 'saas.site_record.store', 'uses' => 'SiteRecordController@store'
    ]);
    // 站点记录删除
    $api->post('/saasApi/site_record/remove', [
        'as' => 'saas.site_record.remove', 'uses' => 'SiteRecordController@remove'
    ]);
    //商品素材库文章详情
    $api->get('/saasApi/product/article', [
        'as' => 'saas.MaterialLibrary.article', 'uses' => 'MaterialLibrariesController@article'
    ]);
    //商品素材库文章下载
    $api->get('/saasApi/product/article/download', [
        'as' => 'saas.MaterialLibrary.article', 'uses' => 'MaterialLibrariesController@downloadZip'
    ]);
    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.api.auth']], function($api) {
        //获取用户信息
        $api->get('/saasApi/auth/user', [
            'as' => 'auth.user', 'uses' => 'AuthenticateController@AuthUser'
        ]);
        // 更新用户信息
        $api->put('/saasApi/auth/updateUser', [
            'as' => 'auth.updateUser', 'uses' => 'AuthenticateController@updateUser'
        ]);
        // 添加用户头像
        $api->put('/saasApi/auth/addUserImage', [
            'as' => 'auth.addUserImage', 'uses' => 'AuthenticateController@addUserImage'
        ]);
        // 获取图片上传token
        $api->get('/saasApi/tools/getToken', [
            'as' => 'saas.tool.getToken', 'uses' => 'ToolsController@getToken'
        ]);
        // 修改密码
        $api->post('/saasApi/auth/changePassword', [
            'as' => 'saas.auth.changePassword', 'uses' => 'AuthenticateController@changePassword'
        ]);
        // 意见反馈提交
        $api->post('/saasApi/feedback/store', [
            'as' => 'saas.feedback.store', 'uses' => 'FeedbackController@store'
        ]);

        //退出登录
        $api->post('/saasApi/auth/logout', [
            'as' => 'saas.logout', 'uses' => 'AuthenticateController@logout'
        ]);
        //刷新token
        $api->post('/saasApi/auth/upToken', [
            'as' => 'saas.upToken', 'uses' => 'AuthenticateController@upToken'
        ]);


        // 商品库列表
        $api->get('/saasApi/product/lists', [
            'as' => 'saas.product.list', 'uses' => 'ProductsController@lists'
        ]);
        // 推荐的商品列表
        $api->get('/saasApi/product/recommendList', [
            'as' => 'saas.product.recommendList', 'uses' => 'ProductsController@recommendList'
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

        // 销售渠道
        $api->get('/saasApi/survey/sourceSales', [
            'as' => 'saas.survey.sourceSales', 'uses' => 'SurveyController@sourceSales'
        ]);

        //海报列表
        $api->get('/saasApi/posters', [
            'as' => 'saas.posters.lists', 'uses' => 'PosterController@lists'
        ]);
        //海报详情
        $api->get('/saasApi/poster', [
            'as' => 'saas.poster.poster', 'uses' => 'PosterController@poster'
        ]);
    });
});
