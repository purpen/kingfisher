<?php

namespace App\Jobs;

/**
 * 同步库存，队列任务 
 */
use App\Helper\JdApi;
use App\Helper\ShopApi;

use App\Jobs\Job;

use App\Models\OrderModel;
use App\Models\ProductsSkuModel;
use App\Models\StorageSkuCountModel;
use App\Models\StoreModel;

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

        $shopApi = new ShopApi();
        $jdApi = new JdApi();

        foreach ($order_sku as $v){
            $sku_id = $v->sku_id;
            //sku编码
            $number = $v->sku_number;
            
            /*$storage_sku = StorageSkuCountModel::where('sku_id',$sku_id)->get();
            
            //计算sku可卖库存
            $quantity = $storage_sku->sum(function ($e){
                return $e->count - $e->reserve_count - $e->pay_count;
            });*/
            
            //获取sku可卖库存
            $productSkuModel = new ProductsSkuModel();
            $quantity = $productSkuModel->sellCount($sku_id);

            //自营商店同步订单中的sku库存
            $shopApi->changSkuCount($number, $quantity);

            /*京东平台商品SKU库存同步*/
            /*$jdApi->shopSkuStockUpdate($number, $quantity);*/
        }
        
    }

}
