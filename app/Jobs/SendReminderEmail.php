<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\OrderModel;
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
        // 获取目标订单
        if (!$order = OrderModel::find($order_id)) {
            return false;
        }
        $orders_update = OrderModel::where('id' , $order_id)->first();
        $orders['status'] = 0;
        $orders_update->update($orders);

        Log::info('订单id:' . $order_id . '已取消');
        if (!$orders){
            return false;
        }
    }
}
