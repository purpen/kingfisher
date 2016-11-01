<?php

namespace App\Jobs;

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

        //修改同步记录状态
        if($this->mark == 'end'){
            $s_model = SynchronousStockRecordModel::find($this->sid);
            $s_model->status = 2;
            $s_model->save();
        }

        $storage_sku = StorageSkuCountModel::where('sku_id',$this->sku_id)->get();
        if($storage_sku->isEmpty()){
            return;
        }
        $sku_model = ProductsSkuModel::find($this->sku_id);
        if(!$sku_model){
            return;
        }
        $number = $sku_model->number;

        //sku可卖库存
        $quantity = $storage_sku->sum(function ($e){
            return $e->count - $e->reserve_count - $e->pay_count;
        });
        
        $this->selfShop($number, $quantity);
        Log::info('商品SKU:' . $number . '完成同步');
    }

    /**
     *同步自营店铺sku 库存
     * @param $quantity
     */
    protected function selfShop($number,$quantity){
        $shopApi = new ShopApi();
        $shopApi->changSkuCount($number, $quantity);
    }
}
