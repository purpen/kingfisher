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
require app_path('Http/Routes/apiV1.php');
require app_path('Http/Routes/saasApi.php');
require app_path('Http/Routes/fiu.php');
require app_path('Http/Routes/MicroApi.php');
require app_path('Http/Routes/DealerApi.php');

// 七牛图片上传回调地址
Route::post('/asset/callback',[
    'as' => 'upload.callback', 'uses' => 'Common\AssetController@callback'
]);

// 七牛图片上传资源库回调地址
Route::post('/material/callback',[
    'as' => 'materialUpload.callback', 'uses' => 'Home\MaterialLibrariesController@callback'
]);
// 七牛图片上传资源库视频截取封面图
Route::post('/material/qiniuNotify',[
    'as' => 'materialUpload.qiniuNotify', 'uses' => 'Home\MaterialLibrariesController@qiniuNotify'
]);
//京东授权回调
Route::get('/jdCallUrl','Home\StoreController@jdCallUrl');

//淘宝授权回调
Route::get('/TBCallUrl','Home\StoreController@TBCallUrl');

//有赞授权回调
Route::get('/yzCallUrl','Home\StoreController@yzCallUrl');

// 快递鸟物流回调
Route::post('/KDNCallUrl','Common\KdnCallbackController@callback');

Route::group(['middleware' => ['auth']], function () {
    // 图片删除
    Route::post('/asset/ajaxDelete', [
        'as' => 'upload.delete', 'uses' => 'Common\AssetController@ajaxDelete'
    ]);
    
    //timingTask
    Route::get('/timingTask','TestController@timingTask');
    // 图片删除
    Route::post('/material/ajaxDelete', [
        'as' => 'materialUpload.delete', 'uses' => 'Home\MaterialLibrariesController@ajaxDelete'
    ]);
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
Route::get('/test/memberships_random','Home\TestController@memberships'); //客户添加编号
Route::get('/test/testUpload','Home\TestController@testUpload'); //客户添加编号
Route::get('/test/excel','Home\TestController@orderExcel'); //客户添加编号
Route::post('/dis/test/excel','Home\TestController@excel'); //客户添加编号
Route::get('/saasSku','Home\TestController@saasSku');          //分发saas 用户关联sku user_id 修复
Route::get('/user_id_sales','Home\TestController@user_id_sales');          //order导入关联的fiu部门id补充
//Route::post('/excel','Home\TestController@excel'); //客户添加编号