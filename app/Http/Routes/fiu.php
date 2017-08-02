<?php
/**
 * Created by PhpStorm.
 * User: cailiguang
 * Date: 2017/7/31
 * Time: 下午2:29
 */
Route::group(['middleware' => ['auth'], 'namespace' => 'Fiu'], function() {

    Route::get('/fiu/home',[
        'as' => 'admin.fiu.home', 'uses' => 'IndexController@index'
    ]);

    /**
     * 站点管理
     */
    Route::get('/fiu/site', [
        'as' => 'admin.fiu.site' , 'uses' => 'SiteController@siteIndex'
    ]);

    Route::get('/fiu/site/create', [
        'as' => 'admin.site.store' , 'uses' => 'SiteController@siteCreate'
    ]);
    Route::post('/fiu/site/store', [
        'as' => 'admin.site.store' , 'uses' => 'SiteController@siteStore'
    ]);
    Route::get('/fiu/site/edit/{site_id}', [
        'as' => 'admin.site.store' , 'uses' => 'SiteController@siteEdit'
    ]);
    Route::post('/fiu/site/update', [
        'as' => 'admin.site.store' , 'uses' => 'SiteController@siteUpdate'
    ]);
    //站点１开放　０关闭
    Route::get('/fiu/{id}/unStatus', [
        'as' => 'admin.site.status', 'uses' => 'SiteController@unStatus'
    ]);
    Route::get('/fiu/{id}/status', [
        'as' => 'admin.site.status', 'uses' => 'SiteController@status'
    ]);

    //删除
    Route::get('/fiu/site/delete/{site_id}', [
        'as' => 'admin.site.store', 'uses' => 'SiteController@delete'
    ]);



    /**
     * 分发SaaS
     */
    //商品列表
    Route::match(['get', 'post'], '/fiu/saasProduct/lists', [
        'as' => 'admin.fiu.saasProduct.lists', 'uses' => 'SaasProductController@lists'
    ]);
    // 商品详情页面
    Route::get('/fiu/saasProduct/info', [
        'as' => 'admin.fiu.saasProduct.info', 'uses' => 'SaasProductController@info'
    ]);
    // 添加关联分销商
    Route::post('/fiu/saasProduct/ajaxSetCheck', [
        'as' => 'admin.fiu.saasProduct.ajaxSetCheck', 'uses' => 'SaasProductController@ajaxSetCheck'
    ]);
    // 取消分销商和用户的关联 ajaxDelete
    Route::post('/fiu/saasProduct/ajaxDelete', [
        'as' => 'admin.fiu.saasProduct.ajaxDelete', 'uses' => 'SaasProductController@ajaxDelete'
    ]);
    // 编辑分销商看到的商品售价和库存
    Route::post('/fiu/saasProduct/setProduct', [
        'as' => 'admin.fiu.saasProduct.setProduct', 'uses' => 'SaasProductController@setProduct'
    ]);
    // 编辑分销商看到的SKU售价
    Route::post('/fiu/saasProduct/setSku', [
        'as' => 'admin.fiu.saasProduct.setSku', 'uses' => 'SaasProductController@setSku'
    ]);

    // 用户反馈
    Route::get('/fiu/saasFeedback', [
        'as' => 'admin.fiu.saasFeedback.lists', 'uses' => 'SaasFeedbackController@lists'
    ]);


    /**
     * 素材库图片
     */
    Route::get('/fiu/saas/image', [
        'as' => 'admin.fiu.materialLibraries', 'uses' => 'MaterialLibrariesController@imageIndex'
    ]);
    Route::get('/fiu/saas/image/create', [
        'as' => 'admin.fiu.materialLibraries.store' , 'uses' => 'MaterialLibrariesController@imageCreate'
    ]);
    Route::post('/fiu/saas/image/store', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@imageStore'
    ]);
    Route::get('/fiu/saas/image/edit/{materialLibrary_id}', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@imageEdit'
    ]);
    Route::post('/fiu/saas/image/update', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@imageUpdate'
    ]);
    /**
     * 素材库视频
     */
    Route::get('/fiu/saas/video', [
        'as' => 'admin.fiu.materialLibraries', 'uses' => 'MaterialLibrariesController@videoIndex'
    ]);
    Route::get('/fiu/saas/video/create', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@videoCreate'
    ]);
    Route::post('/fiu/saas/video/store', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@videoStore'
    ]);
    Route::get('/fiu/saas/video/edit/{materialLibrary_id}', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@videoEdit'
    ]);
    Route::post('/fiu/saas/video/update', [
        'as' => 'admin.fiu.materialLibraries.store' , 'uses' => 'MaterialLibrariesController@videoUpdate'
    ]);

    /**
     * 素材库文字段
     */
    Route::get('/fiu/saas/describe', [
        'as' => 'admin.fiu.materialLibraries' , 'uses' => 'MaterialLibrariesController@describeIndex'
    ]);
    Route::get('/fiu/saas/describe/create', [
        'as' => 'admin.fiu.materialLibraries.store' , 'uses' => 'MaterialLibrariesController@describeCreate'
    ]);
    Route::post('/fiu/saas/describe/store', [
        'as' => 'admin.fiu.materialLibraries.store' , 'uses' => 'MaterialLibrariesController@describeStore'
    ]);
    Route::get('/fiu/saas/describe/edit/{materialLibrary_id}', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@describeEdit'
    ]);
    Route::post('/fiu/saas/describe/update', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@describeUpdate'
    ]);
    //删除
    Route::get('/fiu/saas/material/delete/{material_id}', [
        'as' => 'admin.fiu.materialLibraries.store', 'uses' => 'MaterialLibrariesController@delete'
    ]);

    /**
     * 文章库
     */
    Route::get('/fiu/saas/article', [
        'as' => 'admin.fiu.article' , 'uses' => 'ArticleController@articleIndex'
    ]);
    Route::get('/fiu/saas/article/create', [
        'as' => 'admin.fiu.article.store', 'uses' => 'ArticleController@articleCreate'
    ]);
    Route::post('/fiu/saas/article/store', [
        'as' => 'admin.fiu.article.store' , 'uses' => 'ArticleController@articleStore'
    ]);
    Route::get('/fiu/saas/article/edit/{article_id}', [
        'as' => 'admin.fiu.article.store', 'uses' => 'ArticleController@articleEdit'
    ]);
    Route::post('/fiu/saas/article/update', [
        'as' => 'admin.fiu.article.store', 'uses' => 'ArticleController@articleUpdate'
    ]);
    Route::get('/fiu/saas/articles', [
        'as' => 'admin.fiu.articleList', 'uses' => 'ArticleController@articles'
    ]);
    Route::post('/fiu/saas/article/imageUpload', [
        'as' => 'admin.fiu.article.store', 'uses' => 'ArticleController@imageUpload'
    ]);
    //文章删除
    Route::get('/fiu/saas/article/delete/{article_id}', [
        'as' => 'admin.fiu.article.store', 'uses' => 'ArticleController@delete'
    ]);
    //全部文章
    Route::get('/fiu/saas/atricleAll', [
        'as' => 'admin.fiu.article.store' , 'uses' => 'ArticleController@articleAll'
    ]);
    //更新article状态　１已审核　０草稿箱
    Route::get('/fiu/article/{id}/unStatus', [
        'as' => 'admin.fiu.article.store', 'uses' => 'ArticleController@unStatus'
    ]);
    Route::get('/fiu/article/{id}/status', [
        'as' => 'admin.fiu.article.store', 'uses' => 'ArticleController@status'
    ]);


    /**
     * 分销商
     */
    Route::get('/fiu/saas/user', [
        'as' => 'admin.fiu.user.store', 'uses' => 'DistributorController@index'
    ]);
    Route::post('/fiu/saas/user/store', [
        'as' => 'admin.fiu.user.store', 'uses' => 'DistributorController@store'
    ]);
    Route::get('/fiu/saas/user/ajaxEdit', [
        'as' => 'admin.fiu.user.store', 'uses' => 'DistributorController@ajaxEdit'
    ]);
    Route::post('/fiu/saas/user/update', [
        'as' => 'admin.fiu.user.store', 'uses' => 'DistributorController@update'
    ]);
    Route::post('/fiu/saas/user/destroy', [
        'as' => 'admin.fiu.user.destroy', 'uses' => 'DistributorController@ajaxDestroy'
    ]);

});