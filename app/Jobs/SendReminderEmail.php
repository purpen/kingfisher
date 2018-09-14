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
     * Execute the job.User用于获取用户信息/Mailer用于发送邮件
     *
     * @return void
     */
//    public function handle(Mailer $mailer)
    public function handle()
    {
        $order_id = $this->order_id;
        Log::info('我是来自队列666,发送了一个邮件'.$order_id);
        $orderModel = $this->orderModel;
//        $mailer->send('timer.timer',['users'=>$users],function($message) use ($users){
//            $message->to($users->email)->subject('新功能发布');
////            $this->job->delete();
//        });

//        Mail::raw('你现在还好吗？',function ($message){
//            // 发件人（你自己的邮箱和名称）
//            $message->from('282235309@qq.com', '沁雅児');
//            // 收件人的邮箱地址
//            $message->to('2834144959@qq.com',$this->users);
//            // 邮件主题
//            $message->subject('队列发送邮件');
//        });
        $orders =DB::table('order')
//            ->where('user_id','=',$this->auth_user_id)
            ->where('id','=',$order_id)
            ->update(['status'=> 0]);
        if (!$orders){
            return false;
        }

        Log::info('我是来自队列999,发送了一个邮件'.$orderModel);
        Log::info('我是来自队列000,发送了一个邮件'.$orders);


    }
}
