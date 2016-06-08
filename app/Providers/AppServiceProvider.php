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
