<?php
/**
 * 同步自营商城商品信息
 */
namespace App\Console\Commands;

use App\Helper\ShopApi;
use App\Models\ProductsModel;
use Illuminate\Console\Command;

class PullProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步自营商城商品信息';

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
        $next_page = 1; //下一页页码
        do{
            //请求自营商城Api
            $result = $shopApi->getProduct($next_page);
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
                if(ProductsModel::where('number',$row['number'])->count() > 0){
                    continue;
                }
                $this->store($row);
            }

            $next_page = $result['data']['next_page'];
        }while($next_page > 0); //当不存在下一页时停止运行

        $bar->finish();
        $this->info('自营商品同步完成');
    }

    /**
     * 保存商品信息
     * @param $rows
     */
    protected function store($row){
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
    }

}
