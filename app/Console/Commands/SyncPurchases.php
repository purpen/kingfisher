<?php

namespace App\Console\Commands;

use App\Models\purchasesInterimModel;
use App\Models\PurchaseSkuRelationModel;
use App\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步采购详情单ß';

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
        PurchaseSkuRelationModel::chunk(200, function ($purchases_sku) {
            foreach ($purchases_sku as $purchasesSku){
                $purchasesInterim = purchasesInterimModel::where('purchase_sku_relation_id' , $purchasesSku->id)->first();
                if($purchasesInterim){
                    continue;
                }
                $purchases_interim = new purchasesInterimModel();
                $purchases_interim->purchase_sku_relation_id = $purchasesSku->id;
                $purchase = $purchasesSku->purchase ? $purchasesSku->purchase  : '';
                if($purchase->predict_time == '0000-00-00'){
                    continue;
                }
                $user_id = $purchase ? $purchase->user_id : 0;
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
                            $purchases_interim->department_name = $department_val;
                        }else{
                            //为零的话就没有部门
                            $purchases_interim->department_name = '';
                        }
                    }
                }else{
                    //为零的话就没有部门
                    $purchases_interim->department_name = '';
                }
                //商品名称
                $sku = $purchasesSku->productsSku ? $purchasesSku->productsSku  : '';
                $product = $sku ? $sku->product : '';
                $purchases_interim->product_title = $product ? $product->title : '';
                //供应商名称
                $supplier = $purchase ? $purchase->supplier : '';
                $purchases_interim->supplier_name = $supplier ? $supplier->name : '';
                //采购时间
                $purchases_time = $purchase ? $purchase->created_at : '';
                $purchases_interim->purchases_time = $purchases_time;
                //采购数量
                $purchases_interim->quantity = $purchasesSku->count;
                //采购价钱
                $purchases_interim->purchases_price = $purchasesSku->price;
                //来票时间
                $purchases_interim->invoice_start_time = $purchase ? $purchase->created_at : '';
                //来票金额
                $purchases_interim->total_money = $purchasesSku->count * $purchasesSku->price;
                //付款时间
                $purchases_interim->payment_time = $purchase ? $purchase->predict_time : '';
                //付款金额
                $purchases_interim->payment_price = $purchasesSku->count * $purchasesSku->price;
                $purchases_interim->summary = '';
                $purchases_interim->save();
            }
        });
    }
}
