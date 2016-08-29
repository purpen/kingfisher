<?php

/*
|--------------------------------------------------------------------------
| 应用程序前台路由
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth','power']], function () {
    
    Route::get('/home','Home\IndexController@index');

    // 用户路由
    Route::get('/user', 'Home\UserController@index');
    Route::post('/user/store', 'Home\UserController@store');
    Route::get('/user/ajaxEdit', 'Home\UserController@ajaxEdit');
    Route::post('/user/update', 'Home\UserController@update');
    Route::post('/user/destroy', 'Home\UserController@ajaxDestroy');

    // 角色路由
    Route::get('/role', 'Home\RoleController@index');
    Route::post('/role/store', 'Home\RoleController@store');
    Route::get('/role/ajaxEdit', 'Home\RoleController@ajaxEdit');
    Route::post('/role/update', 'Home\RoleController@update');
    Route::post('/role/destroy', 'Home\RoleController@ajaxDestroy');

    //用户角色
    Route::get('/roleUser', 'Home\RoleController@show');
    Route::post('/roleUser/store', 'Home\RoleController@roleUserStore');
    Route::post('/roleUser/destroy', 'Home\RoleController@roleUserDestroy');

    // 权限路由
    Route::get('/permission', 'Home\PermissionController@index');
    Route::post('/permission/store', 'Home\PermissionController@store');
    Route::get('/permission/ajaxEdit', 'Home\PermissionController@ajaxEdit');
    Route::post('/permission/update', 'Home\PermissionController@update');
    Route::post('/permission/destroy', 'Home\PermissionController@ajaxDestroy');

    //角色权限
    Route::get('/rolePermission', 'Home\PermissionController@show');
    Route::post('/rolePermission/store', 'Home\PermissionController@rolePermissionStore');

    //库存监控管理
    Route::get('/storageSkuCount/list','Home\StorageSkuCountController@index');
    Route::post('/storageSkuCount/search','Home\StorageSkuCountController@search');
    Route::post('/storageSkuCount/updateMax','Home\StorageSkuCountController@ajaxUpdateMax');
    Route::post('/storageSkuCount/updateMin','Home\StorageSkuCountController@ajaxUpdateMin');
    Route::get('/storageSkuCount/productCount','Home\StorageSkuCountController@productCount');
    Route::post('/storageSkuCount/productSearch','Home\StorageSkuCountController@productSearch');
    Route::post('/storageSkuCount/productCountList','Home\StorageSkuCountController@productCountList');
    Route::post('/storageSkuCount/storagePlace','Home\StorageSkuCountController@storagePlace');
    Route::post('/storageSkuCount/RackPlace','Home\StorageSkuCountController@rackPlace');
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


    //分类
    Route::get('/category','Home\CategoryController@index');

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
    Route::get('/purchase/show','Home\PurchaseController@show');
    Route::post('/purchase/ajaxVerified','Home\PurchaseController@ajaxVerified');
    Route::post('/purchase/ajaxDirectorVerified','Home\PurchaseController@ajaxDirectorVerified');
    Route::post('/purchase/ajaxDirectorReject','Home\PurchaseController@ajaxDirectorReject');

    //采购退货单
    Route::get('/returned','Home\ReturnedPurchaseController@home');
    Route::get('/returned/create','Home\ReturnedPurchaseController@create');
    Route::get('/returned/ajaxPurchase','Home\ReturnedPurchaseController@ajaxPurchase');
    Route::post('/returned/store','Home\ReturnedPurchaseController@store');
    Route::get('/returned/edit','Home\ReturnedPurchaseController@edit');
    Route::post('/returned/update','Home\ReturnedPurchaseController@update');
    Route::post('/returned/ajaxDestroy','Home\ReturnedPurchaseController@ajaxDestroy');
    Route::get('/returned/show','Home\ReturnedPurchaseController@show');
    Route::get('/returned/returnedStatus','Home\ReturnedPurchaseController@returnedStatus');
    Route::post('/returned/ajaxVerified','Home\ReturnedPurchaseController@ajaxVerified');
    Route::post('/returned/ajaxDirectorVerified','Home\ReturnedPurchaseController@ajaxDirectorVerified');
    Route::post('/returned/ajaxDirectorReject','Home\ReturnedPurchaseController@ajaxDirectorReject');

    //采购入库
    Route::get('/enterWarehouse','Home\EnterWarehouseController@home');
    Route::get('/enterWarehouse/changeEnter','Home\EnterWarehouseController@changeEnter');
    Route::get('/enterWarehouse/complete','Home\EnterWarehouseController@complete');
    Route::get('/enterWarehouse/ajaxEdit','Home\EnterWarehouseController@ajaxEdit');
    Route::post('/enterWarehouse/update','Home\EnterWarehouseController@update');

    //采购退货出库
    Route::get('/outWarehouse','Home\OutWarehouseController@home');
    Route::get('/outWarehouse/changeOut','Home\OutWarehouseController@changeOut');
    Route::get('/outWarehouse/ajaxEdit','Home\OutWarehouseController@ajaxEdit');
    Route::post('/outWarehouse/update','Home\OutWarehouseController@update');
    Route::get('/outWarehouse/complete','Home\OutWarehouseController@complete');
    Route::get('/outWarehouse/sendOut','Home\OutWarehouseController@sendOut');
    
    //调拨单
    Route::get('/changeWarehouse','Home\ChangeWarehouseController@home');
    Route::get('/changeWarehouse/verify','Home\ChangeWarehouseController@verify');
    Route::get('/changeWarehouse/completeVerify','Home\ChangeWarehouseController@completeVerify');
    Route::get('/changeWarehouse/create','Home\ChangeWarehouseController@create');
    Route::post('/changeWarehouse/store','Home\ChangeWarehouseController@store');
    Route::get('/changeWarehouse/edit','Home\ChangeWarehouseController@edit');
    Route::post('/changeWarehouse/update','Home\ChangeWarehouseController@update');
    Route::get('/changeWarehouse/show','Home\ChangeWarehouseController@show');
    Route::get('/changeWarehouse/ajaxSkuList','Home\ChangeWarehouseController@ajaxSkuList'); //指定仓库sku列表
    Route::get('/changeWarehouse/ajaxSearch','Home\ChangeWarehouseController@ajaxSearch');
    Route::post('/changeWarehouse/ajaxDestroy','Home\ChangeWarehouseController@ajaxDestroy');
    Route::post('/changeWarehouse/ajaxVerified','Home\ChangeWarehouseController@ajaxVerified');
    Route::post('/changeWarehouse/ajaxDirectorVerified','Home\ChangeWarehouseController@ajaxDirectorVerified');

    //订单
    Route::get('/order','Home\OrderController@index');
    Route::get('/order/create','Home\OrderController@create');
    Route::post('/order/store','Home\OrderController@store');
    Route::get('/order/ajaxSkuList','Home\OrderController@ajaxSkuList');
    Route::get('/order/ajaxEdit','Home\OrderController@ajaxEdit');
    Route::post('/order/ajaxUpdate','Home\OrderController@ajaxUpdate');
    Route::post('/order/ajaxDestroy','Home\OrderController@ajaxDestroy');
    Route::get('/order/verifyOrderList','Home\OrderController@verifyOrderList');
    Route::get('/order/reversedOrderList','Home\OrderController@reversedOrderList');
    Route::post('/order/ajaxVerifyOrder','Home\OrderController@ajaxVerifyOrder');
    Route::post('/order/ajaxReversedOrder','Home\OrderController@ajaxReversedOrder');
    Route::get('/order/sendOrderList','Home\OrderController@sendOrderList');
    Route::post('/order/ajaxSendOrder','Home\OrderController@ajaxSendOrder');

    //财务
    Route::get('/payment','Home\PaymentController@home');
    Route::post('/payment/ajaxCharge','Home\PaymentController@ajaxCharge'); //财务记账
    Route::post('/payment/ajaxReject','Home\PaymentController@ajaxReject'); //财务驳回

    //省份
    Route::get('/province','Home\ProvinceController@index');
    Route::post('/province/store','Home\ProvinceController@store');
    Route::post('/province/update','Home\ProvinceController@update');
    Route::post('/province/edit','Home\ProvinceController@ajaxEdit');
    Route::post('/province/destroy','Home\ProvinceController@destroy');

    //城市
    Route::get('/city','Home\CityController@index');
    Route::post('/city/store','Home\CityController@store');
    Route::post('/city/update','Home\CityController@update');
    Route::post('/city/edit','Home\CityController@ajaxEdit');
    Route::post('/city/destroy','Home\CityController@destroy');

    //付款账户基础资料
    Route::get('/paymentAccount','Home\PaymentAccountController@index');
    Route::post('/paymentAccount/store','Home\PaymentAccountController@store');
    Route::get('/paymentAccount/edit','Home\PaymentAccountController@ajaxEdit');
    Route::post('/paymentAccount/update','Home\PaymentAccountController@update');
    Route::post('/paymentAccount/destroy','Home\PaymentAccountController@ajaxDestroy');
});

//图片上传
Route::post('/asset/callback','Common\AssetController@callback'); //七牛回调


//测试地址
Route::get('/test/jd_callback','Home\TestController@jdCalllback'); //七牛回调






















