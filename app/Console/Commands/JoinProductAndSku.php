<?php

namespace App\Console\Commands;

use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Console\Command;

class JoinProductAndSku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productAndSku:join';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '通过商品编码建立商品与SKU的关联';

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
        $productSkus = ProductsSkuModel::where('product_id',0)->get();

        //设置进度条
        $bar = $this->output->createProgressBar($productSkus->count());

        foreach ($productSkus as $productSku){
            $product_number = $productSku->product_number;

            //查询sku对应的商品
            if(!$productModel = ProductsModel::where('number',$product_number)->first()){
                $this->error('SKU编号:【' . $productSku->number . '】没找到关联商品');
                continue;
            }
            $id = $productModel->id;

            $productSku->product_id = $id;
            if(!$productSku->save()){
                $this->error('SKU编号:【' . $productSku->number . '】关联出错');
            }
            $bar->advance();
        }
        $bar->finish();
    }

}
