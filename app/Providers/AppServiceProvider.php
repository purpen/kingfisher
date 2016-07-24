<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

use App\Models\CaptchaModel;

class AppServiceProvider extends ServiceProvider
{
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
