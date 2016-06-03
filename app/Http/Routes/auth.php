<?php

/*
|--------------------------------------------------------------------------
| 应用程序权限路由
|--------------------------------------------------------------------------
*/

// 认证路由
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');

// 注册路由
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');

// 验证码
Route::get('/captcha', 'Auth\AuthController@getCaptcha');
Route::post('/captcha', 'Auth\AuthController@postCaptcha');

// 手机验证码
Route::post('/captcha/send', 'Auth\CaptchaController@postSendCaptcha');
