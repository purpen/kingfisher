<?php

/*
|--------------------------------------------------------------------------
| 应用程序前台路由
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/home','Home\IndexController@index');
    
});

// 仓库路由
Route::get('/storage','Home\Storage\StorageController@index');
Route::post('/storage/add','Home\Storage\StorageController@addStorage');
Route::get('/storage/storageList','Home\Storage\StorageController@storageList');
Route::post('/storage/destroy','Home\Storage\StorageController@destroyStorage');
Route::match(['get', 'post'],'/storage/edit','Home\Storage\StorageController@editStorage');

//仓区路由
Route::post('/storageRack/add','Home\Storage\StorageRackController@addStorageRack');
Route::get('/storageRack/list','Home\Storage\StorageRackController@storageRackList');
Route::post('/storageRack/destroy','Home\Storage\StorageRackController@destroyStorageRack');
Route::match(['get', 'post'],'/storageRack/edit','Home\Storage\StorageRackController@editStorageRack');

//仓位路由
Route::post('/storagePlace/add','Home\Storage\StoragePlaceController@addStoragePlace');
Route::get('/storagePlace/list','Home\Storage\StoragePlaceController@StoragePlaceList');
Route::post('/storagePlace/destroy','Home\Storage\StoragePlaceController@destroyStoragePlace');
Route::match(['get', 'post'],'/storagePlace/edit','Home\Storage\StoragePlaceController@editStoragePlace');

//供货商
Route::get('/supplier','Home\Purchase\SupplierController@index');
Route::post('/supplier/store','Home\Purchase\SupplierController@store');
Route::post('/supplier/destroy','Home\Purchase\SupplierController@destroy');
Route::get('/supplier/edit','Home\Purchase\SupplierController@edit');
Route::post('/supplier/update','Home\Purchase\SupplierController@update');
Route::post('/supplier/search','Home\Purchase\SupplierController@search');












