<?php

namespace App\Jobs;

use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Jobs\Job;
use App\Models\ProductsSkuModel;
use App\Models\StorageSkuCountModel;
use App\Models\SynchronousStockRecordModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SynchronousStock extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * 商品sku ID
     * @var
     */
    protected $sku_id;

    /**
     * 队列末尾标志
     */
    protected $mark;

    /**
     * 同步记录ID
     */
    protected $sid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sku_id,$mark='',$sid)
    {
        $this->sku_id = $sku_id;
        $this->mark = $mark;
        $this->sid = $sid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //当$mark的值为 'end' 修改同步记录状态
        if($this->mark == 'end'){
            $s_model = SynchronousStockRecordModel::find($this->sid);
            $s_model->status = 2;
            $s_model->end_time = date("Y-m-d H:i:s");
            $s_model->save();
        }

        /*获取SKU编码*/
        $sku_model = ProductsSkuModel::find($this->sku_id);
        if(!$sku_model){
            return;
        }
        $number = $sku_model->number;

        /*计算SKU总的可卖库存*/
        $storage_sku = StorageSkuCountModel::where('sku_id',$this->sku_id)->get();
        if($storage_sku->isEmpty()){
            return;
        }
        $quantity = $storage_sku->sum(function ($e){
            return $e->count - $e->reserve_count - $e->pay_count;
        });
        
        /*同步自营店铺sku 库存*/
        $shopApi = new ShopApi();
        $result = $shopApi->changSkuCount($number, $quantity);

        /*京东平台商品SKU库存同步*/
        /*$jdApi = new JdApi();
        $jdApi->shopSkuStockUpdate($number, $quantity);*/

        Log::info('商品SKU:' . $number . '完成同步');
        
        //注销变量
        unset($quantity,$s_model,$storage_sku,$sku_model);
    }

}
