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
});