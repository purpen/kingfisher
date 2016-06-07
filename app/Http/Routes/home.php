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
