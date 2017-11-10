<?php

namespace App\Console\Commands;

use App\Models\OrderSkuRelationModel;
use App\Models\ProductsModel;
use App\Models\SupplierModel;
use App\Models\SupplierMonthModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncSupplierMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:supplierMonth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '供应商月统计';

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
        $day = date('d');
        if($day == 6){

            //检查当前的月份
            $month = date('m');
            //如果当前是1月份，就减去1年
            $year = date('Y')-1;
            //1月份走上面，其他月份走下面
            if ($month == 1){
                $Ym = date($year."-12");
                $start = date("Y-m-d H:i:s", strtotime($Ym));
                $Y_m = date("Y-m");
                $end = date("Y-m-d H:i:s", strtotime($Y_m));
            }else{
                $Ym = date("Y-".($month-1));
                $Y_m = date("Y-m");
                $start = date("Y-m-d H:i:s", strtotime($Ym));
                $end = date("Y-m-d H:i:s", strtotime($Y_m));
            }

            //获取代发的供应商
            $suppliers = SupplierModel::where('type' , 3)->get();

            //循环供应商列表
            foreach ($suppliers as $supplier){
                //供应商名称
                $supplier_name = $supplier->name;

                $sup_id = $supplier->id;
                $product_id = [];
                //查看代发供应商下面的商品，把商品id存入到数组里
                $products = ProductsModel::where('supplier_id' , $sup_id)->get();
                foreach ($products as $product){
                    $product_id[] = $product->id;
                }
                //查看供应商提供的商品
                $all_total = 0;
                $order_sku_relation = OrderSkuRelationModel::whereIn('product_id' , $product_id)->whereBetween('created_at' , [$start,$end])->get();
                foreach ($order_sku_relation as $v){
                    $order_sku_relation_id[] = $v->id;
                    $price = $v->price;
                    $quantity = $v->quantity;
                    $total = $price * $quantity;
                    $all_total += $total;
                }
                //代发供应商提供的商品，每月卖出去多少钱
                $supplierMonth = new SupplierMonthModel();
                $supplierMonth->supplier_name = $supplier_name;
                $supplierMonth->year_month = $Ym;
                $supplierMonth->total_price = $all_total;
                $supplierMonth->status = 0;
                $supplierMonth->save();
            }
        }else{
            return;
        }
    }
}
