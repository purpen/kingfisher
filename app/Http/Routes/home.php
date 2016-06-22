<?php

/*
|--------------------------------------------------------------------------
| 应用程序前台路由
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/home','Home\IndexController@index');

    // 用户路由
    Route::get('/user', 'Home\User\UserController@index');
    Route::post('/user/store', 'Home\User\UserController@store');

    // 角色路由
    Route::get('/role', 'Home\User\RoleController@index');
    Route::post('/role/store', 'Home\User\RoleController@store');

    // 权限路由
    Route::get('/permission', 'Home\User\PermissionController@index');
    Route::post('/permission/store', 'Home\User\PermissionController@store');

    // 仓库路由
    Route::get('/storage','Home\Storage\StorageController@index');
    Route::post('/storage/add','Home\Storage\StorageController@add');
    Route::get('/storage/storageList','Home\Storage\StorageController@lists');
    Route::post('/storage/destroy','Home\Storage\StorageController@destroy');
    Route::match(['get', 'post'],'/storage/edit','Home\Storage\StorageController@edit');

    //仓区路由
    Route::post('/storageRack/add','Home\Storage\StorageRackController@add');
    Route::get('/storageRack/list','Home\Storage\StorageRackController@lists');
    Route::post('/storageRack/destroy','Home\Storage\StorageRackController@destroy');
    Route::match(['get', 'post'],'/storageRack/edit','Home\Storage\StorageRackController@edit');

    //仓位路由
    Route::post('/storagePlace/add','Home\Storage\StoragePlaceController@add');
    Route::get('/storagePlace/list','Home\Storage\StoragePlaceController@lists');
    Route::post('/storagePlace/destroy','Home\Storage\StoragePlaceController@destroy');
    Route::match(['get', 'post'],'/storagePlace/edit','Home\Storage\StoragePlaceController@edit');

    //供货商
    Route::get('/supplier','Home\Purchase\SupplierController@index');
    Route::post('/supplier/store','Home\Purchase\SupplierController@store');
    Route::post('/supplier/destroy','Home\Purchase\SupplierController@ajaxDestroy');
    Route::get('/supplier/edit','Home\Purchase\SupplierController@ajaxEdit');
    Route::post('/supplier/update','Home\Purchase\SupplierController@update');
    Route::post('/supplier/search','Home\Purchase\SupplierController@search');

    //物流公司
    Route::get('/logistics/','Home\Storage\LogisticsController@index');
    Route::post('/logistics/store','Home\Storage\LogisticsController@ajaxStore');
    Route::get('/logistics/edit','Home\Storage\LogisticsController@ajaxEdit');
    Route::post('/logistics/update','Home\Storage\LogisticsController@ajaxUpdate');
    Route::post('/logistics/destroy','Home\Storage\LogisticsController@ajaxDestroy');
    Route::post('/logistics/status','Home\Storage\LogisticsController@ajaxStatus');

    //店铺
    Route::get('/store','Home\Store\StoreController@index');
    Route::post('/store/store','Home\Store\StoreController@ajaxStore');
    Route::get('/store/edit','Home\Store\StoreController@ajaxEdit');
    Route::post('/store/update','Home\Store\StoreController@ajaxUpdate');
    Route::post('/store/destroy','Home\Store\StoreController@ajaxDestroy');

    //商品
    Route::get('/product','Home\Product\ProductController@home');
});
























