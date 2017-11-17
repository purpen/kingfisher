<?php

namespace App\Jobs;

use App\Helper\YouzanApi;
use App\Jobs\Job;
use App\Models\OrderModel;
use App\Models\ProductsSkuModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendYouZanOrder extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $yzOrder;
    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($yzOrder ,OrderModel $order)
    {
        $this->yzOrder = $yzOrder;
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
        $YouZanApi = new YouzanApi();

        //有赞平台
        foreach ($this->yzOrder as $yzOrder)
        {
            $item_id = $yzOrder['item_id'];
            $youZan_sku_id = $yzOrder['sku_id'];

            //erp平台
            foreach ($order_sku as $v){
                $sku_id = $v->sku_id;
                //获取sku可卖库存
                $productSkuModel = new ProductsSkuModel();
                $quantity = $productSkuModel->sellCount($sku_id);

                //自营商店同步订单中的sku库存
                $YouZanApi->SkuQuantity($item_id , $youZan_sku_id , $quantity);

            }

        }


    }
}
