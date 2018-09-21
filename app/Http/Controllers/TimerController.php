<?php
namespace App\Http\Controllers;
use App\Jobs\SendReminderEmail;
use App\Models\OrderModel;
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
    public function sendReminderEmail(Request $request, $order_id)
    {
//        $users = User::findOrFail($id);
//        $job = (new SendReminderEmail($users))->delay(5);
//        $job = (new SendReminderEmail($users))->delay(Carbon::now()->addMinutes(10));//10分钟后
//        $this->dispatch($job);
//
//        $job = new SendReminderEmail('282235309@qq.com');
//        $this->dispatch($job);
//        $users = User::find(1);
//        $this->dispatch((new SendReminderEmail($users))->delay(5));#延迟5秒

        $orderModel = OrderModel::find($order_id);
        if (!$orderModel) {
            return false;
        }
        if ($orderModel->status == 1){
           $job = (new SendReminderEmail($order_id,$orderModel))->delay(10);
           $this->dispatch($job);
        }
    }
}