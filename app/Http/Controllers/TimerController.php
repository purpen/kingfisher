<?php
namespace App\Http\Controllers;
use App\Jobs\SendReminderEmail;
use App\Models\UserModel;
use App\User;
use Illuminate\Http\Request;

class TimerController extends Controller
{
    /**
     * 发送提醒的 e-mail 给指定用户。
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
//    public function sendReminderEmail(Request $request, $id)
    public function sendReminderEmail()
    {
//        $users = User::findOrFail($id);
//        $job = (new SendReminderEmail($users))->delay(5);
////        $job = (new SendReminderEmail($users))->delay(Carbon::now()->addMinutes(10));//10分钟后
//        $this->dispatch($job);

        $user = User::find(1);
        $this->dispatch((new SendReminderEmail($user))->delay(5));#延迟5秒
    }
}