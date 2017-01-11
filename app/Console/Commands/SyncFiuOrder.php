<?php

namespace App\Console\Commands;

use DB;
use App\Models\StoreModel;
use App\Models\CountersModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ReceiveOrderModel;
use App\Models\PromptMessageModel;
use App\Models\ProductsSkuModel;

use App\Helper\Utils;
use App\Helper\ShopApi;
use App\Jobs\ChangeSkuCount;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * 同步自营商城待处理订单,保存到本地
 */
class SyncFiuOrder extends Command
{
    use DispatchesJobs;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:fiuOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Fiu Order Task.';

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
        $this->info('This is sync fiu order task!');
        
        // 获取自营商城类型
        $store = StoreModel::where('platform', 3)->first();
        if (!$store) {
            $this->error('自营商城不存在');
            return false;
        }
        // 验证店铺是否设置默认仓库及物流信息
        $storeStorageLogistic = $store->storeStorageLogistic;
        if (!$storeStorageLogistic) {
            $this->error('店铺未设置默认仓库或物流');
            return false;
        }
        $storeId = $store->id;
        
        // 拉取自营商城订单
        $shopApi = new ShopApi();
        $data = $shopApi->pullOderList();
        
        // 如果获取列表失败
        if ($data[0] === false) {
            $this->error($data[1]);
            return false;
        }
        
        $order_list = $data[1];
        // 遍历保存订单
        foreach ($order_list as $order)
        {
            $count = OrderModel::where(['store_id' => $storeId, 'outside_target_id' => $order['rid']])->count();
            // 已同步记录，跳过
            if ($count > 0) {
                continue;
            }
            // 检测物流信息，无信息跳过
            if ($order['express_info'] === null) {
                $this->error('自营平台商店同步订单'. $order['rid'] .':express_info 字段：null');
                continue;
            }
            
            // 开始同步事务
            DB::beginTransaction();
            
            $order_model = new OrderModel();
            
            $order_model->number = CountersModel::get_number('DD');
            $order_model->outside_target_id = $order['rid'];
            $order_model->type = 3;   // 下载订单
            $order_model->store_id = $storeId;
            $order_model->storage_id = $storeStorageLogistic->storage_id;    
            $order_model->payment_type = 1;
            $order_model->pay_money = $order['pay_money'];
            $order_model->total_money = $order['total_money'];
            $order_model->freight = $order['freight'];
            $order_model->discount_money = $order['discount_money'];
            $order_model->express_id = $storeStorageLogistic->logistics_id;
            $order_model->buyer_name = $order['express_info']['name'];
            $order_model->buyer_tel = '';
            $order_model->buyer_phone = $order['express_info']['phone'];
            $order_model->buyer_address = $order['express_info']['address'];
            $order_model->buyer_province = $order['express_info']['province'];
            $order_model->buyer_city = $order['express_info']['city'];
            
            if (key_exists('county', $order['express_info'])) {
                $order_model->buyer_county = $order['express_info']['county'];
            } else {
                $order_model->buyer_county = '';
            }
            if (key_exists('town',$order['express_info'])) {
                $order_model->buyer_township = $order['express_info']['town'];
            } else {
                $order_model->buyer_township = '';
            }
            $order_model->buyer_summary = '';
            $order_model->order_start_time = $order['created_at'];
            
            // 设置发票信息
            $order_model->invoice_info = Utils::invoice($order['invoice_caty'], $order['invoice_title'] , $order['invoice_content']);
            
            // $order_model->seller_summary = $order_info['vender_remark'];
            $order_model->pec = $order['referral_code'] ? $order['referral_code'] : '';
            $order_model->from_site = $order['from_site'];
            $order_model->status = 5;
            $order_model->count = $order['items_count'];
            
            // 是否开普勒订单
            $order_model->is_vop = isset($order['is_vop']) ? $order['is_vop'] : '';
            // 开普勒订单号
            $order_model->jd_order_id = isset($order['jd_order_id']) ? $order['jd_order_id'] : '';
            
            // 执行保存
            if (!$order_model->save()) {
                DB::rollBack();
                $this->error('自营订单同步保存出错');
                return false;
            }
            $order_id = $order_model->id;

            // 遍历保存订单商品明细
            foreach ($order['items'] as $item) {
                if (!array_key_exists('number', $item)) {
                    DB::rollBack();
                    continue 2;
                }
                
                $order_sku_model = new OrderSkuRelationModel();
                $order_sku_model->order_id = $order_id;
                $order_sku_model->sku_number = $item['number'];
                $order_sku_model->sku_name = $item['name'] . $item['sku_name'];
                if (array_key_exists('storage_id', $item)) {
                    $order_sku_model->out_storage_id = $item['storage_id'];
                }
                if (array_key_exists('vop_id', $item)) {
                    $order_sku_model->vop_id = $item['vop_id'];
                }

                // 判断sku编码是否存在
                $message = new PromptMessageModel();
                if (empty($item['number'])) {
                    DB::rollBack();
                    $message->addMessage(1, '自营平台：【' . $item['name'] . $item['sku_name'] . '】未添加SKU编码');
                    continue 2;
                }
                
                if ($skuModel = ProductsSkuModel::where('number',$item['number'])->first()) {
                    $order_sku_model->sku_id = $skuModel->id;
                    $order_sku_model->product_id = $skuModel->product->id;
                } else {
                    DB::rollBack();
                    $message->addMessage(1, 'erp系统：【' . $item['name'] . $item['sku_name'] . '】 未添加SKU编码');
                    continue 2;
                }
                
                $order_sku_model->quantity = $item['quantity'];
                $order_sku_model->price = $item['price'];
                $order_sku_model->discount = $item['price'] - $item['sale_price'];

                // 增加付款占货量
                $productSkuModel = new ProductsSkuModel();
                if (!$productSkuModel->increasePayCount($skuModel->id, $item['quantity'])) {
                    DB::rollBack();
                    $this->info('自营平台同步订单时增加付款占货出错');
                    continue 2;
                };
                
                if (!$order_sku_model->save()) {
                    DB::rollBack();
                    $this->error('自营平台订单详细信息同步出错');
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
            $this->dispatch(new ChangeSkuCount($order_model));
            
        }
        
        $this->info('Sync fiu order ok!');
        
        return true;
    }
}