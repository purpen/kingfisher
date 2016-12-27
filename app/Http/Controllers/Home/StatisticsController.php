<?php

/**
 * 统计控制器
 */

namespace App\Http\Controllers\Home;

use App\Models\OrderSkuRelationModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * SKU销售统计
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function skuSale(Request $request)
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

        $sku_list = OrderSkuRelationModel
            ::select(DB::raw('sum(quantity * price) as sale_money,sum(quantity) as count,id,sku_id,sku_number,product_id'))
            ->where('refund_status','=', 0)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('sku_number')
            ->paginate($this->per_page);
//        dd($sku_list);
        return view('home/statistics.skuSale',['sku_list' => $sku_list]);
    }
}
