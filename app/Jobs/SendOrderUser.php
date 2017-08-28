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
        $username = OrderUserModel::where('username' , $this->order->buyer_name)->first();
        $phone = OrderUserModel::where('phone' , $this->order->buyer_phone)->first();
//        \Log::info($buyer_address);
//        \Log::info($this->order);
        if(($username && $phone) !=null){
            return;
        }
        $orderUser = new OrderUserModel();
        $orderUser->username = $this->order->buyer_name?$this->order->buyer_name:'';
        $orderUser->phone = $this->order->buyer_phone ?$this->order->buyer_phone:'';
        $orderUser->store_id = $this->order->store_id;
        $orderUser->type = $this->order->type;
        $orderUser->from_to = $this->order->store ? $this->order->store->platform : '';
        $orderUser->buyer_address = $this->order->buyer_address;
        $orderUser->buyer_province = $this->order->buyer_province;
        $orderUser->buyer_city = $this->order->buyer_city;
        $orderUser->buyer_county = $this->order->buyer_county;
        $orderUser->random_id = str_random(6);

        $orderUser->save();

    }
}
