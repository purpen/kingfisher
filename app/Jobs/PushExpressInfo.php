<?php

namespace App\Jobs;

use App\Models\OrderModel;

use App\Helper\JdApi;
use App\Helper\ShopApi;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * 自动定时推送物流信息至平台
 * @author purpen
 */
class PushExpressInfo extends Job implements SelfHandling
{
    /**
     * 目标订单编号
     */
    protected $order_id;
    
    /**
     * 物流ID
     */
    protected $logistics_id;
    
    /**
     * 快递单号
     */
    protected $waybill;
        
        
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_id, $logistics_id, $waybill)
    {
        $this->order_id = $order_id;
        $this->logistics_id = $logistics_id;
        $this->waybill = $waybill;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 获取目标订单
        if (!$orderModel = OrderModel::find($this->order_id)) {
            return false;
        }
        
        $platform = $orderModel->store->platform;
        switch ($platform) {
            case 3:
                // 自营平台
                $shopApi = new ShopApi();
                $shopApi->send_goods($this->order_id, $this->logistics_id, $this->waybill);
                break;
            case 2:
                $api = new JdApi();
                $api->outStorage($this->order_id, $this->logistics_id, $this->waybill);
                break;
            case 1:
                //淘宝平台
                break;
        }
        
        return true;
    }
    
}
