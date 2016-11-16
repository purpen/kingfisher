<?php

namespace App\Jobs;

/**
 *同步会员，队列任务
 */
use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Jobs\Job;

use App\Models\OrderUserModel;
use App\Models\OrderModel;
use App\Models\ChinaCityModel;
use App\Models\ShippingAddressModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderUser extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OrderModel $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderUser = new OrderUserModel();
        $orderUser->store_id = $this->order->store_id;
        $orderUser->username = $this->order->buyer_name;
        $orderUser->phone = $this->order->buyer_phone;
        $orderUser->from_to = $this->order->store->platform;
        $orderUser->type = $this->order->type;
        $orderUsers = $orderUser->save();

        $order_user_id = $orderUser->id;

        if($orderUsers == true){
            $all['order_user_id'] = $order_user_id;
            $all['buyer_address'] = $this->order->buyer_address;
            $all['buyer_province'] = $this->order->buyer_province;
            $all['buyer_city'] = $this->order->buyer_city;
            $all['buyer_county'] = $this->order->buyer_county;
            ShippingAddressModel::create($all);
        }
        \Log::info($order_user_id);
    }
}
