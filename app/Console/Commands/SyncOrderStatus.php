<?php

namespace App\Console\Commands;

use App\Models\OrderModel;

use App\Helper\JdApi;
use App\Helper\ShopApi;

use Illuminate\Console\Command;

/**
 * 自动与各平台同步未处理订单的状态
 */
class SyncOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:orderStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync order status.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('This is sync order task!');
        
        $orderList = OrderModel::where(['type' => 3,'status' => 5])->orWhere(['type' => 3, 'status' => 10])->get();
        foreach ($orderList as $order) {
            $platform = $order->store->platform;

            switch ($platform) {
                case 3:
                    $this->changeShopOrderStatus($order->id);
                    break;
                case 2:
                    $this->changeJdOrderStatus($order->id);
                    break;
                case 1:
                    //淘宝平台
                    break;
            }
        }
        
        $this->info('Sync order status ok!');
        
        return true;
    }
    
    /**
     * 更新京东未处理订单的状态
     */
    protected function changeJdOrderStatus($order_id)
    {
        $api = new JdApi();
        $resp = $api->pullOrderStatus($order_id);

        if ($resp->code != 0) {
            return false;
        }
        if (!$status = $resp->order->orderInfo->order_state) {
            return false;
        }

        switch ($status) {
            case 'WAIT_GOODS_RECEIVE_CONFIRM':
                $status = 10;  //已发货
                break;
            case 'FINISHED_L':
                $status = 20;  //完成
                break;
            case 'TRADE_CANCELED':
                $status = 0;  //取消
                break;
            default:
                return false;
        }
        
        $orderModel = new OrderModel();
        return $orderModel->changeStatus($order_id, $status);
    }
    
    /**
     * 更新自营平台未处理订单状态
     */
    protected function changeShopOrderStatus($order_id)
    {
        $orderModel = OrderModel::find($order_id);
        if (!$orderModel) {
            return false;
        }
        
        $shopApi = new ShopApi();
        $result = $shopApi->getOrderInfo($orderModel->outside_target_id);
        if ($result['success'] == false) {
            return false;
        }

        $status = $result['data']['status'];
        // 自营商城订单状态: 0. 已取消;1.待付款；10.待发货(可以申请退款)；12.退款中；13.退款成功；15.待收货；16.待评价；20.订单完成；
        // erp 状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
        switch ($status) {
            case 0:
                $status = 0;
                break;
            case 1:
                $status = 1;
                break;
            case 10:
                $status = 5;
                break;
            case 12:
                $status = 5;
                break;
            case 13:
                $status = 5;
                break;
            case 15:
                $status = 10;
                break;
            case 16:
                $status = 20;
                break;
            case 20:
                $status = 20;
                break;
        }
        
        return $orderModel->changeStatus($order_id, $status);
    }
    
}
