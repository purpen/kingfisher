<?php

namespace App\Console\Commands;

use App\Helper\ShopApi;
use App\Models\ProductsSkuModel;
use Illuminate\Console\Command;

class PullProductSku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productSku:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步自营商店商品SKU';

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
        $shopApi = new ShopApi();
        $next_page = 1;
        do{
            $result = $shopApi->getProductSku($next_page);
            if(!$result['success']){
                $this->error('请求商城api出错！');
                return;
            }
            $rows = $result['data']['rows'];
            if(!isset($bar)){
                $bar = $this->output->createProgressBar($result['data']['total_rows']);
            }
            //保存商品信息
            foreach ($rows as $row){
                $bar->advance();
                if(ProductsSkuModel::where('number',$row['number'])->count() > 0){
                    continue;
                }
                $this->store($row);
            }

            $next_page = $result['data']['next_page'];
        }while($next_page > 0);

        $bar->finish();
        $this->info('自营商品SKU同步完成');
    }

    /**
     * 保存商品SKU
     * @param $row
     */
    public function store($row)
    {
        $productSku = new ProductsSkuModel();
        $productSku->bid_price = '';
        $productSku->cost_price = '';
        $productSku->price = $row['price'];
        $productSku->mode = $row['mode'];
        $productSku->product_id = '';
        if(!$row['product_number']){
            return;
        }
        $productSku->product_number = $row['product_number'];
        $productSku->number = $row['number'];
        $productSku->summary = $row['summary'];
        $productSku->user_id = 0;
        $productSku->cover_id = '';
        if(!$productSku->save()){
            $this->error('保存商品SKU信息出错');
            return;
        }
    }
}
