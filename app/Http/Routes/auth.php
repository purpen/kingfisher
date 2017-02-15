<?php

/*
|--------------------------------------------------------------------------
| 应用程序权限路由
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Auth'], function() {
    // 认证路由
    Route::get('/login', 'AuthController@getLogin');
    Route::post('/login', 'AuthController@postLogin');
    Route::get('/logout', 'AuthController@logout');

    // 注册路由
    Route::get('/register', 'AuthController@getRegister');
    Route::post('/register', 'AuthController@postRegister');

    // 验证码
    Route::get('/captcha', 'AuthController@getCaptcha');
    Route::post('/captcha', 'AuthController@postCaptcha');
    Route::post('/captcha/phone','AuthController@phoneCaptcha');

    // 手机验证码
    Route::post('/captcha/send', 'CaptchaController@postSendCaptcha');
    Route::post('/captcha/is_exist', 'CaptchaController@isExistCode');

    // 忘记密码
    Route::get('/forget','PasswordController@getForget');
    Route::post('/forget','PasswordController@postForget');

    //用户名
    Route::post('/account','AuthController@postAccount');

});


