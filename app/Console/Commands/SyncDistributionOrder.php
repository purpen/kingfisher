<?php

namespace App\Console\Commands;


use App\Models\CountersModel;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductSkuRelation;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PromptMessageModel;
use App\Models\ReceiveOrderModel;
use App\Models\SkuDistributorModel;
use App\Models\StoreStorageLogisticModel;
use App\Models\TemDistributionOrderModel;
use App\Models\UserModel;
use App\Models\UserProductModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncDistributionOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:distributionOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步分销商的订单';

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
        TemDistributionOrderModel::chunk(200, function ($distribution_orders) {
            foreach ($distribution_orders as $distribution_order){
                $distribution_id = $distribution_order->distribution_id;
                $sku_name = $distribution_order->sku_name;
                //检查分销商是否存在
                $distributor = UserModel::where('id', $distribution_id)->where('type', 1)->first();
                if (!$distributor) {
                    $message = new PromptMessageModel();
                    $message->addMessage(1, 'erp系统：分销商id为' . $distribution_id . ', 没有找到');
                    continue;
                }
                $outside_target_id = $distribution_order->outside_target_id;
                $order = OrderModel::where('outside_target_id' , $outside_target_id)->first();
                if($order){
                    //如果存在了，删除
                    $distribution_order->delete($distribution_order->id);
                    continue;
                }
                $sku_number = $distribution_order->sku_number;
                $quantity = $distribution_order->quantity;
                //判断分销id
                $skuDistributor = SkuDistributorModel::where('distributor_number' , $sku_number)->where('distributor_id' , $distribution_id)->first();
                if($skuDistributor){
                    $sku = ProductsSkuModel::where('number' , $skuDistributor->sku_number)->first();
                    //如果没有sku号码，存入到数组中
                    if (!$sku) {
                        $message = new PromptMessageModel();
                        $message->addMessage(1, 'erp系统：sku编号为' . $skuDistributor->sku_number . '的商品, 不存在');
                        continue;
                    }
                    $not_see_product_id_arr = UserProductModel::notSeeProductId($distribution_id);
                    $product_id = $sku->product_id;
                    $products = ProductsModel::where('id' , $product_id)->where('saas_type' , 1)->whereNotIn('id', $not_see_product_id_arr)->get();
                    if($products->isEmpty()){
                        $message = new PromptMessageModel();
                        $message->addMessage(1, 'erp系统：' . $distributor->realname.'分销商,' .$sku_name. ', 商品没有开放');
                        continue;

                    }
                }else{
                    $sku = ProductsSkuModel::where('number' , $sku_number)->first();
                    //如果没有sku号码，存入到数组中
                    if (!$sku) {
                        $message = new PromptMessageModel();
                        $message->addMessage(1, 'erp系统：sku编号为' . $sku_number . '的商品, 不存在');
                        continue;
                    }
                    $not_see_product_id_arr = UserProductModel::notSeeProductId($distribution_id);
                    $product_id = $sku->product_id;
                    $products = ProductsModel::where('id' , $product_id)->where('saas_type' , 1)->whereNotIn('id', $not_see_product_id_arr)->get();
                    if($products->isEmpty()){
                        $message = new PromptMessageModel();
                        $message->addMessage(1, 'erp系统：' . $distributor->realname.'分销商' .$sku_name. ', 商品没有开放');
                        continue;

                    }
                }
                //增加 付款订单占货
                $productSku = new ProductsSkuModel();
                $productSku->increasePayCount($sku->id , $quantity);
                $product_sku_id = $sku->id;

                //检查sku库存是否够用
                $product_sku_relation = new ProductSkuRelation();
                //分发saas sku信息详情
                $product_sku = $product_sku_relation->skuInfo($distribution_id , $product_sku_id);
                //saas sku库存减少
                $product_sku_quantity = $product_sku_relation->reduceSkuQuantity($product_sku_id , $distribution_id , $quantity);
                if($product_sku_quantity[0] === false){
                    $message = new PromptMessageModel();
                    $message->addMessage(1, 'erp系统：' . $distributor->realname.'分销商' .$sku_name. ', 商品库存不足');
                    continue;
                }
                $price = $distribution_order->price;
                $buyer_name = $distribution_order->buyer_name;
                $buyer_tel = $distribution_order->buyer_tel;
                $buyer_phone = $distribution_order->buyer_phone;
                $buyer_zip = $distribution_order->buyer_zip;
                $buyer_address = $distribution_order->buyer_address;
                $buyer_province = $distribution_order->buyer_province;
                $buyer_city = $distribution_order->buyer_city;
                $buyer_county = $distribution_order->buyer_county;
                $buyer_township = $distribution_order->buyer_township;
                $summary = $distribution_order->summary;
                $buyer_summary = $distribution_order->buyer_summary;
                $seller_summary = $distribution_order->seller_summary;
                $order_start_time = $distribution_order->order_start_time;
                $invoice_info = $distribution_order->invoice_info;
                $invoice_type = $distribution_order->invoice_type;
                $invoice_header = $distribution_order->invoice_header;
                $invoice_added_value_tax = $distribution_order->invoice_added_value_tax;
                $invoice_ordinary_number = $distribution_order->invoice_ordinary_number;
                $discount_money = $distribution_order->discount_money;

                $order = new OrderModel();
                $order->number = CountersModel::get_number('DD');
                $order->status = 5;
                $order->outside_target_id = $outside_target_id;
                $order->payment_type = 1;
                $order->type = 6;
                $order->payment_type = 1;
                $order->buyer_name = $buyer_name;
                $order->buyer_phone = $buyer_phone;
                $order->buyer_address = $buyer_address;
                $order->user_id = 0;
                $order->distributor_id = $distribution_id;

                $order->user_id_sales = config('constant.user_id_sales');
                $order->store_id = config('constant.store_id');
                //设置仓库id
                $storeStorageLogistics = StoreStorageLogisticModel::where('store_id' , config('constant.store_id'))->first();
                if($storeStorageLogistics){
                    $order->storage_id = $storeStorageLogistics->storage_id;
                    $order->express_id = $storeStorageLogistics->logistics_id;
                }
                $order->from_type = 2;
                $order->count = $quantity;

                $order->total_money = $quantity * $product_sku['price'];
                $order->order_start_time = $order_start_time ? $order_start_time : '0000-00-00 00:00:00';
                $order->discount_money = $discount_money;
                $order->pay_money = ($quantity * $product_sku['price']) - $discount_money;
                $order->buyer_tel = $buyer_tel;
                $order->buyer_zip = $buyer_zip;
                $order->buyer_province = $buyer_province;
                $order->buyer_city = $buyer_city;
                $order->buyer_county = $buyer_county;
                $order->buyer_township = $buyer_township;
                $order->buyer_summary = $buyer_summary;
                $order->seller_summary = $seller_summary;
                $order->summary = $summary;
                $order->invoice_type = $invoice_type;
                $order->invoice_header = $invoice_header;
                $order->invoice_info = $invoice_info;
                $order->invoice_added_value_tax = $invoice_added_value_tax;
                $order->invoice_ordinary_number = $invoice_ordinary_number;
                if ($order->save()) {

                    //保存收款单
                    $receiveOrder = new ReceiveOrderModel();
                    $receiveOrder->amount = $order->pay_money;
                    $receiveOrder->payment_user = $order->buyer_name;
                    $receiveOrder->type = 6;
                    $receiveOrder->status = 1;
                    $receiveOrder->target_id = $order->id;
                    $receiveOrder->user_id = 0;
                    $number = CountersModel::get_number('SK');
                    $receiveOrder->number = $number;
                    $receiveOrder->save();

                    //保存订单明细
                    $order_sku = new OrderSkuRelationModel();
                    $order_sku->order_id = $order->id;
                    $order_sku->sku_number = $product_sku['number'];
                    $order_sku->sku_id = $product_sku_id;
                    $product = ProductsModel::where('id', $product_id)->first();
                    $order_sku->product_id = $product_id;
                    $order_sku->sku_name = $product->title . '--' . $product_sku['mode'];
                    $order_sku->quantity = $quantity;
                    $order_sku->price = $product_sku['price'];
                    $order_sku->distributor_price = $price;
                    if($order_sku->save()) {
                        //保存之后，删除临时记录表
                        $distribution_order->delete($distribution_order->id);
                    }
                }

            }
        });
    }
}
