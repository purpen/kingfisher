<?php

/*
|--------------------------------------------------------------------------
| 前端收银路由
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/pos', 'Pos\CheckoutController@index');
});