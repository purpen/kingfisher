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
        \App\Console\Commands\SelfShop::class,
        \App\Console\Commands\JoinProductAndSku::class,
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
        
        /*//京东平台订单定时同步任务
        $schedule->call(function(){
            $jdStore = StoreModel::where('platform',2)->get();
            foreach($jdStore as $store){
                $order = new OrderModel();
                $order->saveOrderList($store->access_token,$store->id);
            }
        })->everyFiveMinutes();

        //京东平台退款单定时同步任务
        $schedule->call(function(){
            $jdStore = StoreModel::where('platform',2)->get();
            foreach($jdStore as $store){
                $refund = new RefundMoneyOrderModel();
                $refund->saveRefundList($store->access_token,$store->id);
            }
        })->everyFiveMinutes();*/

        /**
         * 自营平台退款 退货 返修 同步任务
         */
        $schedule->call(function(){
                $refund = new RefundMoneyOrderModel();
                $refund->selfShopSaveRefundList();
        })->everyMinute();

        /**
         * 自营平台退款 退货 返修 尚未处理的单状态同步
         */
        $schedule->call(function(){
            $refund = new RefundMoneyOrderModel();
            $refund->autoChangeStatus();
        })->everyMinute();

        //自营商城平台订单同步任务
        $schedule->call(function(){
            $orderModel = new OrderModel();
            $orderModel->saveShopOrderList();
        })->everyMinute();

        //自动与各平台同步未处理订单状态
        $schedule->call(function(){
            $orderModel = new OrderModel();
            $orderModel->autoChangeStatus();
        })->everyFiveMinutes();
    }
}
