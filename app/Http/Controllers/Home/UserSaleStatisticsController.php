<?php

namespace App\Http\Controllers\Home;

use App\Models\OrderModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserSaleStatisticsController extends Controller
{
    /**
     * 销售人员销售统计
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        if($request->isMethod('get')){
            $time = $request->input('time')?(int)$request->input('time'):30;
            $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
            $end_date = date("Y-m-d H:i:s");
        }

        if($request->isMethod('post')){
            $start_date = date("Y-m-d H:i:s",strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s",strtotime($request->input('end_date')));
        }

        $user_list = OrderModel
            ::join('users', 'users.id', '=', 'order.user_id_sales')
            ->select(DB::raw('sum(order.pay_money) as money_sum, sum(order.received_money) as received_sum, users.id, users.account, users.realname, users.phone, users.department'))
            ->where('order.type', "=", '2')
            ->where('order.status', '>', '8')
            ->whereBetween('order_send_time', [$start_date, $end_date])
            ->groupBy('order.user_id_sales')
            ->orderBy('money_sum','desc')->get();

        return view('home/userSaleStatistics.index',['user_list' => $user_list]);
    }

    /**
     * 部门销售统计统计
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function department(Request $request)
    {
        if($request->isMethod('get')){
            $time = $request->input('time')?(int)$request->input('time'):30;
            $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
            $end_date = date("Y-m-d H:i:s");
        }

        if($request->isMethod('post')){
            $start_date = date("Y-m-d H:i:s",strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s",strtotime($request->input('end_date')));
        }

        $department_list = OrderModel
            ::join('users', 'users.id', '=', 'order.user_id_sales')
            ->select(DB::raw('sum(order.pay_money) as money_sum, sum(order.received_money) as received_sum, users.department'))
            ->where('order.type', "=", '2')
            ->where('order.status', '>', '8')
            ->whereBetween('order_send_time', [$start_date, $end_date])
            ->groupBy('users.department')
            ->orderBy('money_sum','desc')->get();

        return view('home/userSaleStatistics.department',['department_list' => $department_list]);
    }

}
