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
