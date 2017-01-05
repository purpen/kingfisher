<?php

/**
 * 销售统计
 */

namespace App\Http\Controllers\Home;

use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\OrderUserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalesStatisticsController extends Controller
{
    /**
     * 渠道客户销售统计
     */
    public function User(Request $request)
    {
        $id = $request->input('id');
        $user = OrderUserModel::find($id);
        if(!$user){
            return view('error.503');
        }
        
        $order = OrderModel::where('order_user_id',$id)->where(['type' => 2, 'status' => 10])->select('id')->get();
        if($order->isEmpty()){
            return view('errors.200',['message' => '该用户暂时没有销售信息','back_url' => '/orderUser']);
        }
        $id_array = $order->pluck('id')->all();

        //用户销售明细
        $data = OrderSkuRelationModel::whereIn('order_id',$id_array)->orderBy('updated_at','desc')->paginate(20);
        return view('home/salesStatistics.userSalesStatistics',['data' => $data, 'user' => $user]);
    }
    
    /**
     * 渠道客户按时间统计销售记录
     *
     */
    public function search(Request $request)
    {
        $back_url = $request->server('HTTP_REFERER');
        $id = $request->input('id');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        $user = OrderUserModel::find($id);
        if(!$user){
            return view('error.503');
        }

        $order = OrderModel::whereBetween('order_start_time', [$start_time, $end_time])->where('order_user_id',$id)->where(['type' => 2, 'status' => 10])->select('id')->get();
        if($order->isEmpty()){
            return view('errors.200',['message' => '该时段暂时没有销售信息','back_url' => $back_url]);
        }
        $id_array = $order->pluck('id')->all();

        //用户销售明细
        $data = OrderSkuRelationModel::whereIn('order_id',$id_array)->orderBy('updated_at','desc')->get();

        //总金额
        $sum_money = 0;
        //总优惠
        $discount = 0;
        //实际总金额
        $pay_money = 0;
        foreach ($data as $v){
            $sum_money += $v->quantity * $v->price;
            $discount += $v->discount;
        }
        $pay_money = $sum_money - $discount;

        return view('home/salesStatistics.search',[
            'data' => $data,
            'user' => $user,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'sum_money' => $sum_money,
            'discount' => $discount,
            'pay_money' => $pay_money
        ]);
    }

}
