<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
| 注意：路由缓存不会作用于基于闭包的路由。要使用路由缓存，必须将闭包路由转化为控制器路由。
| php artisan route:cache --> 添加路由缓存命令
| php artisan route:clear --> 清除路由缓存命令
|
*/

require app_path('Http/Routes/default.php');
require app_path('Http/Routes/auth.php');
require app_path('Http/Routes/home.php');
require app_path('Http/Routes/pos.php');

// 七牛图片上传回调地址
Route::post('/asset/callback',[
    'as' => 'upload.callback', 'uses' => 'Common\AssetController@callback'
]);

//京东授权回调
Route::get('/jdCallUrl','Home\StoreController@jdCallUrl');

//淘宝授权回调
Route::get('/TBCallUrl','Home\StoreController@TBCallUrl');

Route::group(['middleware' => ['auth']], function () {
    // 图片删除
    Route::post('/asset/ajaxDelete', [
        'as' => 'upload.delete', 'uses' => 'Common\AssetController@ajaxDelete'
    ]);
    
    //timingTask
    Route::get('/timingTask','TestController@timingTask');
});

//测试地址
Route::get('/test/jd_callback','TestController@jdCalllback'); //七牛回调
Route::get('/test/ceShi','TestController@ceShi'); //七牛回调

//
Route::get('/productAndSku','TestController@productAndSku');

Route::get('/productAndSupplier','TestController@productAndSupplier');

//测试
//Route::get('/shopOrderTest','TestController@shopOrderTest');
Route::get('/express', 'KdniaoController@index');
Route::get('/scanner', 'KdniaoController@scanner');
Route::get('/buildcode', 'BuildcodeController@index');
Route::get('/test', 'Home\IndexController@test');
Route::get('/test_next', 'Home\IndexController@test_next');
Route::get('/cainiao', 'KdniaoController@cainiao');
Route::get('/test/random','Home\TestController@suppliers'); //供应商添加编号


/**
 * Api 路由
 */
$api = app('Dingo\Api\Routing\Router');

// V1版本，公有接口
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {


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
    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.api.auth']], function($api) {
        //采购订单详情
        $api->get('/api/purchases/{purchase_id}', [
            'as' => 'purchases.index', 'uses' => 'PurchaseController@index'
        ]);
        //采购订单列表
        $api->get('/api/purchases', [
            'as' => 'purchases.lists', 'uses' => 'PurchaseController@lists'
        ]);

        //采购发票详情
        $api->get('/api/pInvoice/{pInvoice_id}', [
            'as' => 'pInvoice.index', 'uses' => 'PurchaseInvoiceController@index'
        ]);
        //采购发票列表
        $api->get('/api/pInvoices', [
            'as' => 'pInvoice.lists', 'uses' => 'PurchaseInvoiceController@lists'
        ]);

        //销售订单详情
        $api->get('/api/salesOrder/{salesOrder_id}', [
            'as' => 'salesOrder.index', 'uses' => 'SalesOrderController@index'
        ]);
        //销售订单列表
        $api->get('/api/salesOrders', [
            'as' => 'salesOrder.lists', 'uses' => 'SalesOrderController@lists'
        ]);

        //销售发票详情
        $api->get('/api/salesInvoice/{salesInvoice_id}', [
            'as' => 'salesInvoice.index', 'uses' => 'SalesInvoiceController@index'
        ]);
        //销售发票列表
        $api->get('/api/salesInvoices', [
            'as' => 'salesInvoice.lists', 'uses' => 'SalesInvoiceController@lists'
        ]);

        //电商销售订单详情
        $api->get('/api/ESSalesOrder/{ESSalesOrder_id}', [
            'as' => 'ESSales.index', 'uses' => 'ElectricitySupplierSalesOrderController@index'
        ]);
        //电商销售订单列表
        $api->get('/api/ESSalesOrders', [
            'as' => 'ESSales.lists', 'uses' => 'ElectricitySupplierSalesOrderController@lists'
        ]);
        //配送详情
        $api->get('/api/delivery/{delivery_id}', [
            'as' => 'delivery.index', 'uses' => 'DeliveryController@index'
        ]);
        //配送列表
        $api->get('/api/deliveries', [
            'as' => 'delivery.lists', 'uses' => 'DeliveryController@lists'
        ]);
    });
});