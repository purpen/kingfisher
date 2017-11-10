<?php

namespace App\Console;

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
        \App\Console\Commands\SyncFiuOrder::class,
        \App\Console\Commands\SyncOrderStatus::class,
        \App\Console\Commands\StatisticsOfCommoditySalesVolume::class,
        \App\Console\Commands\receiveOrder::class,
        \App\Console\Commands\SyncPurchases::class,
        \App\Console\Commands\SyncYouZanToken::class,
        \App\Console\Commands\SyncYouZanOrder::class,
        \App\Console\Commands\SyncSupplierMonth::class,
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
                 ->everyMinute();
        
        /**
         * 自营商城平台订单同步任务, 每5分钟
         */
        $schedule->command('sync:fiuOrder')
                 ->everyFiveMinutes();
        
        /**
         * ERP未处理订单，自动与各平台同步最新状态
         */
        $schedule->command('sync:orderStatus')
                 ->everyFiveMinutes();

        /**
         * 同步订单明细到收款单临时表
         */
        $schedule->command('sync:receive')
            ->daily();

        /**
         * 同步采购详情单
         */
        $schedule->command('sync:purchases')
            ->daily();

        /**
         * 更新有赞token
         */
        $schedule->command('sync:yzToken')
            ->daily();

        /**
         * 同步有赞订单信息
         */
        $schedule->command('sync:yzOrder')
            ->everyFiveMinutes();

        /**
         * 同步供应商月统计
         */
        $schedule->command('sync:supplierMonth')
            ->daily();

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
         * 自营平台退款 退货 返修 同步
         */
        /*
        $schedule->call(function(){
                $refund = new RefundMoneyOrderModel();
                $refund->selfShopSaveRefundList();
        })->everyFiveMinutes();*/

        /**
         * 自营平台退款 退货 返修 尚未处理的单状态同步
         */
        /*
        $schedule->call(function(){
            $refund = new RefundMoneyOrderModel();
            $refund->autoChangeStatus();
        })->everyFiveMinutes();*/

        /**
         * 同步收入命令
         */

        
    }
}
