<?php

namespace App\Console\Commands;


use App\Helper\YouzanApi;
use App\Jobs\SendYouZanOrder;
use App\Models\CountersModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsSkuModel;
use App\Models\PromptMessageModel;
use App\Models\ReceiveOrderModel;
use App\Models\StoreModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncYouZanOrder extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:yzOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步有赞订单';

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

        $youzan = new YouzanApi();
        $yzOrders = $youzan->YzOrders();

        // 获取自营商城类型
        $store = StoreModel::where('platform', 6)->first();
        if (!$store) {
            $this->error('有赞商城不存在');
            return false;
        }
        // 验证店铺是否设置默认仓库及物流信息
        $storeStorageLogistic = $store->storeStorageLogistic;
        if (!$storeStorageLogistic) {
            $this->error('店铺未设置默认仓库或物流');
            return false;
        }
        $storeId = $store->id;

        $yzOrdersArray = $yzOrders['response']['trades'];
        foreach ($yzOrdersArray as $yzOrder)
        {
            $count = OrderModel::where('store_id' , $storeId)->where('outside_target_id' , $yzOrder['tid'])->count();
            // 已同步记录，跳过
            if ($count > 0) {
                continue;
            }
            // 开始同步事务
            DB::beginTransaction();

            $order = new OrderModel();

            $order->number = CountersModel::get_number('DD');
            $order->outside_target_id = $yzOrder['tid'];
            $order->type = 3;   // 下载订单
            $order->store_id = $storeId;
            $order->storage_id = $storeStorageLogistic->storage_id;
            $order->payment_type = 1;
            $order->pay_money = $yzOrder['price'];
            $order->total_money = $yzOrder['total_fee'];
            $order->freight = $yzOrder['post_fee'];
            $order->discount_money = $yzOrder['discount_fee'];
            $order->express_id = $storeStorageLogistic->logistics_id;
            $order->buyer_name = $yzOrder['receiver_name'];
            $order->buyer_tel = '';
            $order->buyer_phone = $yzOrder['receiver_mobile'];
            $order->buyer_address = $yzOrder['receiver_address'];
            $order->buyer_province = $yzOrder['receiver_state'];
            $order->buyer_city = $yzOrder['receiver_city'];
            $order->buyer_county = $yzOrder['receiver_district'];
            $order->buyer_township = '';
            $order->buyer_summary = '';
            $order->order_start_time = $yzOrder['pay_time'];
            $order->invoice_header = $yzOrder['invoice_title'];
            $order->status = 5;
            $order->count = $yzOrder['num'];

            $order->user_id_sales = 6; //对应正式服务器 用户ID=6

            // 执行保存
            if (!$order->save()) {
                DB::rollBack();
                $this->error('有赞订单同步保存出错');
                return false;
            }

            $order_id = $order->id;
            // 遍历保存订单商品明细
            foreach ($yzOrder['orders'] as $orderSku)
            {
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_name = $orderSku['title'] . $orderSku['sku_properties_name'];

                 //判断sku编码是否存在
                $message = new PromptMessageModel();

                if ($skuModel = ProductsSkuModel::where('unique_number',$orderSku['outer_sku_id'])->first()) {
                    $order_sku_model->sku_id = $skuModel->id;
                    $order_sku_model->sku_number = $skuModel->number;
                    $order_sku_model->product_id = $skuModel->product->id;
                } else {
                    DB::rollBack();
                    $message->addMessage(1, 'erp系统：【' . $orderSku['title'] . $orderSku['sku_properties_name'] . '】 未添加SKU编码');
                    continue 2;
                }
                if (empty($orderSku['outer_sku_id'])) {
                    DB::rollBack();
                    $message->addMessage(1, '有赞平台：【' . $orderSku['title'] . $orderSku['sku_properties_name'] . '】未添加SKU编码');
                    continue 2;
                }

                $order_sku_model->quantity = $orderSku['num'];
                $order_sku_model->price = $orderSku['price'];
                $order_sku_model->discount = $orderSku['discount_fee'];
                //判断可卖库存是否足够此订单
                $productSkuModel = new ProductsSkuModel();
                $quantity = $productSkuModel->sellCount($skuModel->id);
                if($orderSku['num'] > $quantity){
                    DB::rollBack();
                    $message->addMessage(2, 'erp系统：【' . $orderSku['title'] . $orderSku['sku_properties_name'] . '】 库存不足');
                    continue 2;
                }


                //增加付款占货量
                if (!$productSkuModel->increasePayCount($skuModel->id, $orderSku['num'])) {
                    DB::rollBack();
                    $this->info('有赞平台同步订单时增加付款占货出错');
                    continue 2;
                };

                if (!$order_sku_model->save()) {
                    DB::rollBack();
                    $this->error('有赞平台订单详细信息同步出错');
                    continue 2;
                }
            }

            // 同步自动创建订单收款单
            $model = new ReceiveOrderModel();
            if (!$model->orderCreateReceiveOrder($order_id)) {
                DB::rollBack();
                $this->error('ID:'. $order_id .'订单发货创建订单收款单错误');
                return false;
            }
            // 事务提交
            DB::commit();
            // 同步库存任务队列
            $job = (new SendYouZanOrder($yzOrder['orders'] , $order));
            $this->dispatch($job);
        }
    }
}
