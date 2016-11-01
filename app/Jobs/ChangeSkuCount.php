<?php

namespace App\Jobs;

/**
 *同步库存，队列任务 
 */

use App\Helper\ShopApi;
use App\Jobs\Job;
use App\Models\OrderModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeSkuCount extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OrderModel $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order_sku = $this->order->orderSkuRelation;
        if(!$order_sku){
            return;
        }


        foreach ($order_sku as $v){
            $sku_id = $v->sku_id;
            $storage_sku = StorageSkuCountModel::where('sku_id',$sku_id)->get();
            $quantity = $storage_sku->sum(function ($e){
                return $e->count - $e->reserve_count - $e->pay_count;
            });

            $this->selfShop($v,$quantity);
        }
    }

    /**
     * 自营商店同步订单中的sku库存
     */
    protected function selfShop($v,$quantity)
    {
        $shopApi = new ShopApi();
        $shopApi->changSkuCount($v->sku_number, $quantity);
    }
}
