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
        $platform = $this->order->store->platform;
        switch ($platform){
            case 1:
                //淘宝平台
                break;
            case 2:
                //京东平台
                break;
            case 3:
                //自营平台
                $order_sku = $this->order->orderSkuRelation;
                if(!$order_sku){
                    return;
                }
                $shopApi = new ShopApi();
                foreach ($order_sku as $v){
                    $sku_id = $v->sku_id;
                    $storage_sku = StorageSkuCountModel::where('sku_id',$sku_id)->get();
                    $quantity = $storage_sku->sum('count') - $storage_sku->sum('reserve_count') - $storage_sku->sum('pay_count');

                    $shopApi->changSkuCount($v->sku_number, $quantity);
                }
                break;
        }
    }
}
