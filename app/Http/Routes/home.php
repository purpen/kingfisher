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
Route::get('/storage/destroy','Home\Storage\StorageController@destroyStorage');
Route::match(['get', 'post'],'/storage/edit','Home\Storage\StorageController@editStorage');

//仓区路由
Route::post('/storageRack/add','Home\Storage\StorageRackController@addStorageRack');
Route::get('/storageRack/list','Home\Storage\StorageRackController@storageRackList');
Route::get('/storageRack/destroy','Home\Storage\StorageRackController@destroyStorageRack');
Route::match(['get', 'post'],'/storageRack/edit','Home\Storage\StorageRackController@editStorageRack');





