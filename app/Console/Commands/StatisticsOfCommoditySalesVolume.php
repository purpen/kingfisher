<?php

namespace App\Console\Commands;

use App\Models\OutWarehouseSkuRelationModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductSkuRelation;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatisticsOfCommoditySalesVolume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:salesStatistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计数据库中商品的销售数量，同步到产品表中';

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
        $out_order_id_array = $this->salesOutWarehouseOrderIdArray();

        // 订单的出库单中的各sku_id及数量de对象集合
        $sku_object = $this->skuCountArray($out_order_id_array);

        $product_id_count_array = $this->productCount($sku_object);

        foreach ($product_id_count_array as $product_id => $count){
            $product = ProductsModel::find($product_id);
            $product->sales_number = $count;
            $product->save();
        }

        $this->info('统计数据库中各商品的销售数量完成');
    }

    /**
     * 返回订单的出库单ID数组
     *
     * @return array
     */
    protected function salesOutWarehouseOrderIdArray()
    {
        return (array)OutWarehousesModel::select('id')
            ->where(['type' => 2])
            ->whereIn('storage_status', [1, 5])
            ->get()
            ->pluck('id')
            ->all();
    }

    /**
     * 返回订单的出库单中的各sku_id及数量de对象集合
     *
     * @param array $data  订单的出库单ID数组
     * @return object
     */
    protected function skuCountArray(array $data)
    {
        return (object)OutWarehouseSkuRelationModel::select(DB::raw('sku_id, sum(out_count) as count'))
            ->whereIn('out_warehouse_id', $data)
            ->groupBy('sku_id')
            ->get();
    }

    protected function productCount($object)
    {
        // 商品id和数量的关联数组
        $product_id_array = [];

        foreach($object as $item){
            $sku_model = ProductsSkuModel::find($item->sku_id);
            if (!$sku_model){
                continue;
            }
            $product_model = $sku_model->product;
            if(!$product_model){
                continue;
            }

            if(array_key_exists($product_model->id, $product_id_array)){
                $product_id_array[$product_model->id] += $item->count;
            }else{
                $product_id_array[$product_model->id] = $item->count;
            }
        }

        return $product_id_array;
    }


}
