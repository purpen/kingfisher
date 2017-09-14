<?php

namespace App\Console\Commands;

use App\Models\OrderSkuRelationModel;
use App\Models\receiveOrderInterimModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class receiveOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:receive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步收入明细';

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
        $order_sku = OrderSkuRelationModel::get();
        foreach($order_sku as $orderSku){
            $receiveOrder = receiveOrderInterimModel::where('order_sku_relation_id' , $orderSku->id)->first();
            if($receiveOrder){
                continue;
            }
            $receiveOrderInterim = new receiveOrderInterimModel();
            $receiveOrderInterim->order_sku_relation_id = $orderSku->id;
            $order = $orderSku->order ? $orderSku->order  : '';
            $receiveOrderInterim->store_name = $order ? $order->store->name : '';
            $product = $orderSku->product ? $orderSku->product : '';
            $receiveOrderInterim->product_title =$product ? $product->title : '';
            $receiveOrderInterim->supplier_name =$product->supplier ? $product->supplier->name : '';
            $order_type = $order ? $orderSku->order->type : '';
            $order_type_val = '';
            if(!empty($order_type)) {
                switch ($order_type) {
                    case 1:
                        $order_type_val = '普通订单';
                        break;
                    case 2:    //渠道
                        $order_type_val = '渠道订单';
                        break;
                    case 3:    //下载订单
                        $order_type_val = '下载订单';
                        break;
                    case 4:    //导入订单
                        $order_type_val = '导入订单';
                        break;
                    case 5:    //众筹订单
                        $order_type_val = '众筹订单';
                        break;
                    case 6:    //分销商
                        $order_type_val = '分销商订单 ';
                        break;
                    default:
                        '';
                }
            }
            $receiveOrderInterim->order_type = $order_type_val;
            $receiveOrderInterim->buyer_name = $orderSku->order ? $orderSku->order->buyer_name : '';
            $receiveOrderInterim->order_start_time = $orderSku->order ? $orderSku->order->order_send_time : '';
            $receiveOrderInterim->quantity = $orderSku->quantity;
            $receiveOrderInterim->price = $orderSku->price;
            $receiveOrderInterim->cost_price = $orderSku->product ? $orderSku->product->cost_price : '';
            $receiveOrderInterim->invoice_start_time = $orderSku->order ? $orderSku->order->order_send_time : '';
            $receiveOrderInterim->total_money = $orderSku->quantity * $orderSku->price;
            $receiveOrderInterim->receive_time = $orderSku->order ? $orderSku->order->order_send_time : '';
            $receiveOrderInterim->amount = $orderSku->quantity * $orderSku->price;
            $receiveOrderInterim->summary = '';
            $receiveOrderInterim->save();
        }
    }
}
