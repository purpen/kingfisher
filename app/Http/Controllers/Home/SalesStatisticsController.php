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
     * 渠道用户销售统计
     */
    public function User(Request $request)
    {
        $id = $request->input('id');
        $user = OrderUserModel::find($id);
        if(!$user){
            return view('error.503');
        }
        $username = $user->username;
        
        $order = OrderModel::where('buyer_name',$username)->where(['type' => 2, 'status' => 10])->select('id')->get();
        if($order->isEmpty()){
            return view('errors.200',['message' => '该用户暂时没有销售信息','back_url' => '/orderUser']);
        }
        $id_array = $order->pluck('id')->all();

        //用户销售明细
        $data = OrderSkuRelationModel::whereIn('order_id',$id_array)->orderBy('updated_at','desc')->paginate(20);
        return view('home/salesStatistics.userSalesStatistics',['data' => $data, 'username' => $username]);
    }
}
