<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use App\Models\OrderModel;
use App\Models\CaptchaModel;
use App\Jobs\SendOrderUser;
use Illuminate\Foundation\Bus\DispatchesJobs;
class AppServiceProvider extends ServiceProvider
{
    use DispatchesJobs;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \DB::listen(function($sql, $bindings, $time) {
            //\Log::info($sql);
            //\Log::info($bindings);
        });
        //创建订单的时候执行此队列
        OrderModel::created(function($order){
            $this->dispatch(new SendOrderUser($order));
            \Log::info($order);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
