<?php

namespace App\Console\Commands;


use App\Models\ProductsSkuModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class SyncVirtualSkuCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:virtualCount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更改虚拟库存';

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
        $storage_id = config('constant.storage_id');
        $sku_number = config('constant.sku_count');
        $storage_sku_counts = StorageSkuCountModel::where('storage_id' , $storage_id)->where('department' , 1)->get();
        foreach ($storage_sku_counts as $storage_sku_count){
            if($storage_sku_count->count < $sku_number){
                $number = $sku_number - $storage_sku_count->count;
                $sku_id = $storage_sku_count->sku_id;
                // 增加商品，SKU 总库存
                $skuModel = new ProductsSkuModel();
                if(!$skuModel->addInventory($sku_id, $number)){
                    $this->error('商品sku库存变更数量失败');
                    return false;
                }
                //补充虚拟库存的数量
                $storage_sku_count->count = $storage_sku_count->count + $number;
                if(!$storage_sku_count->save()){
                    $this->error('虚拟库存变更数量失败');
                }

            }
        }

    }
}
