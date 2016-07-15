<?php

/*
|--------------------------------------------------------------------------
| 应用程序前台路由
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/home','Home\IndexController@index');

    // 用户路由
    Route::get('/user', 'Home\UserController@index');
    Route::post('/user/store', 'Home\UserController@store');

    // 角色路由
    Route::get('/role', 'Home\RoleController@index');
    Route::post('/role/store', 'Home\RoleController@store');

    // 权限路由
    Route::get('/permission', 'Home\PermissionController@index');
    Route::post('/permission/store', 'Home\PermissionController@store');

    // 仓库路由
    Route::get('/storage','Home\StorageController@index');
    Route::post('/storage/add','Home\StorageController@add');
    Route::get('/storage/storageList','Home\StorageController@lists');
    Route::post('/storage/destroy','Home\StorageController@destroy');
    Route::match(['get', 'post'],'/storage/edit','Home\StorageController@edit');

    //仓区路由
    Route::post('/storageRack/add','Home\StorageRackController@add');
    Route::get('/storageRack/list','Home\StorageRackController@lists');
    Route::post('/storageRack/destroy','Home\StorageRackController@destroy');
    Route::match(['get', 'post'],'/storageRack/edit','Home\StorageRackController@edit');

    //仓位路由
    Route::post('/storagePlace/add','Home\StoragePlaceController@add');
    Route::get('/storagePlace/list','Home\StoragePlaceController@lists');
    Route::post('/storagePlace/destroy','Home\StoragePlaceController@destroy');
    Route::match(['get', 'post'],'/storagePlace/edit','Home\StoragePlaceController@edit');

    //供货商
    Route::get('/supplier','Home\SupplierController@index');
    Route::post('/supplier/store','Home\SupplierController@store');
    Route::post('/supplier/destroy','Home\SupplierController@ajaxDestroy');
    Route::get('/supplier/edit','Home\SupplierController@ajaxEdit');
    Route::post('/supplier/update','Home\SupplierController@update');
    Route::post('/supplier/search','Home\SupplierController@search');

    //物流公司
    Route::get('/logistics/','Home\LogisticsController@index');
    Route::post('/logistics/store','Home\LogisticsController@ajaxStore');
    Route::get('/logistics/edit','Home\LogisticsController@ajaxEdit');
    Route::post('/logistics/update','Home\LogisticsController@ajaxUpdate');
    Route::post('/logistics/destroy','Home\LogisticsController@ajaxDestroy');
    Route::post('/logistics/status','Home\LogisticsController@ajaxStatus');

    //店铺
    Route::get('/store','Home\StoreController@index');
    Route::post('/store/store','Home\StoreController@ajaxStore');
    Route::get('/store/edit','Home\StoreController@ajaxEdit');
    Route::post('/store/update','Home\StoreController@ajaxUpdate');
    Route::post('/store/destroy','Home\StoreController@ajaxDestroy');

    //商品
    Route::get('/product','Home\ProductController@home');
    Route::get('/product/create','Home\ProductController@create');
    Route::post('/product/store','Home\ProductController@store');
    Route::get('/product/edit','Home\ProductController@edit');
    Route::post('/product/update','Home\ProductController@update');
    Route::post('/product/ajaxDestroy','Home\ProductController@ajaxDestroy');


    //商品sku
    Route::post('/productsSku/store','Home\ProductsSkuController@store');
    Route::get('/productsSku/ajaxEdit','Home\ProductsSkuController@ajaxEdit');
    Route::post('/productsSku/update','Home\ProductsSkuController@update');
    Route::post('/productsSku/ajaxDestroy','Home\ProductsSkuController@ajaxDestroy');
    Route::get('/productsSku/ajaxSkus','Home\ProductsSkuController@ajaxSkus');
    Route::get('/productsSku/ajaxSearch','Home\ProductsSkuController@ajaxSearch');

    //商品分类
    Route::post('/category/store','Home\CategoryController@store');

    //图片删除
    Route::post('/asset/ajaxDelete','Common\AssetController@ajaxDelete');

    //采购单
    Route::get('/purchase','Home\PurchaseController@home');
    Route::get('/purchase/create','Home\PurchaseController@create');
    Route::post('/purchase/store','Home\PurchaseController@store');
    Route::post('/purchase/ajaxDestroy','Home\PurchaseController@ajaxDestroy');
    Route::post('/purchase/search','Home\PurchaseController@search');
    Route::get('/purchase/edit','Home\PurchaseController@edit');
    Route::post('/purchase/update','Home\PurchaseController@update');
    Route::get('/purchase/purchaseStatus','Home\PurchaseController@purchaseStatus');

    //采购退货单
    Route::get('/returned','Home\ReturnedPurchaseController@home');
    Route::get('/returned/create','Home\ReturnedPurchaseController@create');
    Route::get('/returned/ajaxPurchase','Home\ReturnedPurchaseController@ajaxPurchase');
    Route::post('/returned/store','Home\ReturnedPurchaseController@store');
    Route::get('/returned/edit','Home\ReturnedPurchaseController@edit');
    Route::post('/returned/update','Home\ReturnedPurchaseController@update');
    Route::post('/returned/ajaxDestroy','Home\ReturnedPurchaseController@ajaxDestroy');


});

//图片上传
Route::post('/asset/callback','Common\AssetController@callback'); //七牛回调






















