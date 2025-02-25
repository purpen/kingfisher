<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\OrderModel;
use App\Models\ProductsSkuModel;
use App\Models\UserModel;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $order_id;
    protected $orderModel;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_id,$orderModel)
    {
        $this->order_id = $order_id;
        $this->orderModel = $orderModel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
//    public function handle(Mailer $mailer)
    public function handle()
    {
        $order_id = $this->order_id;
        $orderModel = $this->orderModel;

        $orders =DB::table('order')
            ->where('id','=',$order_id)
            ->where('status','=',1)
            ->where('is_voucher','!=',1)
            ->where('type','=',8)
            ->update(['status'=> 0]);
        if (!$orders){
            Log::info("订单延时任务获取符合要求订单失败");
            return false;
        }

        $orderSku = $orderModel->orderSkuRelation;//订单详情表
        $order_sku = $orderSku->toArray();
        foreach ($order_sku as $k=>$v) {
            $sku_id = $v['sku_id'];
            $productSku = ProductsSkuModel::where('id' , $sku_id)->first();
            if (!$productSku->decreaseReserveCount($v['sku_id'], $v['quantity'])) {
                Log::error("订单延时任务失败2");
                return false;
            }
        }

        Log::info('订单id:' . $order_id . '已取消');
    }
}
