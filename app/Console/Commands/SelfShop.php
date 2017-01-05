<?php
/**
 * 同步自营商城商品信息
 */
namespace App\Console\Commands;

use App\Helper\ShopApi;
use App\Http\Controllers\Common\AssetController;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use Illuminate\Console\Command;
use Illuminate\Contracts\Logging\Log;

class SelfShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'product:pull';
    //使用参数选择执行的同步操作
    protected $signature = 'selfShop:pull {option}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步自营商城信息';

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
        $option = $this->argument('option');
        if(!in_array($option,['product','sku'])){
            $this->error('输入参数不正确');
        }

        switch ($option){
            //同步商品
            case 'product':
                $this->getProduct();
                break;
            //同步SKU
            case 'sku':
                $this->getProductSku();
                break;
        }
    }

    /**
     * 同步自营商城商品信息
     */
    protected function getProduct()
    {
        $shopApi = new ShopApi();
        //设置请求的页码
        $next_page = 1;
        do{
            //请求自营商城Api
            $result = $shopApi->getProduct($next_page,50);
            if(!$result['success']){
                $this->error('请求商城api出错！');
                return;
            }

            //创建进度条
            if(!isset($bar)){
                $bar = $this->output->createProgressBar($result['data']['total_rows']);
            }

            //保存商品信息
            $rows = $result['data']['rows'];
            foreach ($rows as $row){
                $bar->advance();
                $product = ProductsModel::where('number',$row['number'])->first();
                if($product){
                    $this->updateProduct($row,$product);
                }else{
                    $this->storeProduct($row);
                }
            }

            //获取商品列表下一页 页码
            $next_page = $result['data']['next_page'];
        }while($next_page > 0); //当下一页不存在是停止

        $bar->finish();
        $this->info('自营商品同步完成');
    }

    /**
     * 同步SKU信息
     */
    protected function getProductSku()
    {
        $shopApi = new ShopApi();
        $next_page = 1;
        do{
            $result = $shopApi->getProductSku($next_page);
            if(!$result['success']){
                $this->error('请求商城api出错！');
                return;
            }

            if(!isset($bar)){
                $bar = $this->output->createProgressBar($result['data']['total_rows']);
            }

            //保存商品信息
            $rows = $result['data']['rows'];
            foreach ($rows as $row){
                $bar->advance();
                $productSku = ProductsSkuModel::where('number',$row['number'])->first();
                if($productSku){
                    $this->updateSku($row,$productSku);
                }else{
                    $this->storeSku($row);
                }

            }

            $next_page = $result['data']['next_page'];
        }while($next_page > 0);

        $bar->finish();
        $this->info('自营商品SKU同步完成');
    }

    /**
     * 保存商品信息
     * @param $rows
     */
    protected function storeProduct($row){
        $product = new ProductsModel();
        $product->number = $row['number'];
        $product->title = $row['title'];
        $product->tit = $row['short_title'];
        $product->category_id = '';
        $product->supplier_id = '';
        $product->supplier_name = '';
        $product->market_price = $row['market_price'];
        $product->sale_price = $row['sale_price'];
        $product->cost_price = '';
        $product->cover_id = '';
        $product->unit = '';
        $product->weight = '';
        $product->summary = $row['summary'];
        $product->type = 1;
        $product->user_id = 0;
        if(!$product->save()){
            $this->error('保存商品信息出错');
            return;
        }
        if(empty($row['cover_url']) || !AssetController::copyImg($row['cover_url'],$product->id)){
            $this->error('同步商品封面图失败');
        }
    }

    /**
     * 更新商品信息
     * @param $row
     * @param $product
     */
    protected function updateProduct($row,$product){
        $product->title = $row['title'];
        $product->tit = $row['short_title'];
        $product->market_price = $row['market_price'];
        $product->sale_price = $row['sale_price'];
        $product->summary = $row['summary'];
        $product->type = 1;
        $product->user_id = 0;
        if(!$product->save()){
            $this->error('保存商品信息出错');
            return;
        }
    }

    /**
     * 保存商品SKU
     * @param $row
     */
    protected function storeSku($row)
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
        if(empty($row['cover_url'])){
            $this->error('商品SKU封面图不存在');
            return;
        }
        if(!AssetController::copyImg($row['cover_url'],$productSku->id,4)){
            $this->error('同步商品SKU封面图失败');
        }
    }

    /**
     * 更新sku信息
     * @param $row
     * @param $productSku
     */
    protected function updateSku($row,$productSku)
    {
        $productSku->price = $row['price'];
        $productSku->mode = $row['mode'];
        if(!$row['product_number']){
            return;
        }
        $productSku->product_number = $row['product_number'];
        $productSku->summary = $row['summary'];
        $productSku->user_id = 0;
        if(!$productSku->save()){
            $this->error('保存商品SKU信息出错');
            return;
        }
    }

}
