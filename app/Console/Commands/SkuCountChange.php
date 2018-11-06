<?php

namespace App\Console\Commands;

use App\Models\ProductsModel;
use App\Models\StorageSkuCountModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SkuCountChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skuCount:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '以仓库数量为准，统一sku，商品数量';

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
        $products = ProductsModel::query()->get();
        try {
            DB::beginTransaction();

            foreach ($products as $product) {
                $productsSkus = $product->productsSku;
                if (!$productsSkus) {
                    continue;
                }
                $product_count = 0;
                foreach ($productsSkus as $sku) {
                    $sku_id = $sku->id;

                    $storge_sku = StorageSkuCountModel::select(DB::raw("sum(`count`) as sum"))
                        ->where('sku_id', $sku_id)
                        ->groupby('sku_id')
                        ->first();
                    if (!$storge_sku) {
                        continue;
                    }
                    $sku->quantity = $storge_sku->sum;
                    $sku->save();

                    $product_count += $storge_sku->sum;
                }

                $product->inventory = $product_count;
                $product->save();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->info($e->getCode() . $e->getMessage());
        }
        DB::commit();

        $this->info('ok');

    }
}
