<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\UserModel;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendReminderEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels,Queueable,Dispatchable;

    protected $users;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.User用于获取用户信息/Mailer用于发送邮件
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
//        $users = $this->users;
//        $mailer->send('timer.timer',['users'=>$users],function($message) use ($users){
//            $message->to($users->email)->subject('新功能发布');
////            $this->job->delete();
//        });
        Log::info('我是来自队列,发送了一个邮件', ['id' => $this->user->id, 'realname' => $this->user->realname]);
    }
}
