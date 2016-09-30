<?php

namespace App\Console;

use App\Models\OrderModel;
use App\Models\RefundMoneyOrderModel;
use App\Models\StoreModel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        
        //京东平台订单 退款单定时同步任务
        $schedule->call(function(){
            $jdStore = StoreModel::where('platform',2)->get();
            foreach($jdStore as $store){
                $order = new OrderModel();
                $order->saveOrderList($store->access_token,$store->id);

                $refund = new RefundMoneyOrderModel();
                $refund->saveRefundList($store->access_token,$store->id);
            }
        })->everyFiveMinutes();
    }
}
