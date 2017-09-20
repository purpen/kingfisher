<?php

namespace App\Console\Commands;

use App\Models\OrderSkuRelationModel;
use App\Models\receiveOrderInterimModel;
use App\Models\UserModel;
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
        OrderSkuRelationModel::chunk(200, function ($order_sku) {
            foreach($order_sku as $orderSku){
                $receiveOrder = receiveOrderInterimModel::where('order_sku_relation_id' , $orderSku->id)->first();
                if($receiveOrder){
                    continue;
                }
                $receiveOrderInterim = new receiveOrderInterimModel();
                $receiveOrderInterim->order_sku_relation_id = $orderSku->id;
                $order = $orderSku->order ? $orderSku->order  : '';
                if($order->order_send_time == '0000-00-00 00:00:00'){
                    continue;
                }
                $user_id = $order ? $order->user_id_sales : 0;
                //检查部门id是否为0
                if($user_id !== 0 ){
                    $users = UserModel::where('id',($user_id))->first();
                    if($users){
                        //查看用户所在的部门
                        $department = $users->department;
                        $department_val = '';
                        if($department !== 0){
                            switch ($department) {
                                case 1:
                                    $department_val = 'Fiu';
                                    break;
                                case 2:
                                    $department_val = 'D3IN';
                                    break;
                                case 3:
                                    $department_val = '海外';
                                    break;
                                case 4:
                                    $department_val = '电商';
                                    break;
                                case 5:
                                    $department_val = '支持';
                                    break;
                                default:
                                    '';
                            }
                            $receiveOrderInterim->department_name = $department_val;
                        }else{
                            //为零的话就没有部门
                            $receiveOrderInterim->department_name = '';
                        }
                    }
                }else{
                    //为零的话就没有部门
                    $receiveOrderInterim->department_name = '';
                }
                $product = $orderSku->product ? $orderSku->product : '';
                $supplier = $product ? $product->supplier : '';
                $receiveOrderInterim->product_title =$product ? $product->title : '';
                $receiveOrderInterim->supplier_name =$supplier ? $supplier->name : '';
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

        });
    }
}
