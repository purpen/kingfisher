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
        $time = null;
        $start_date = null;
        $end_date = null;

        if($request->isMethod('get')){
            if($request->input('start_date')){
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
            }else{
                $time = $request->input('time')?(int)$request->input('time'):365;
                $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
                $end_date = date("Y-m-d H:i:s");
            }
        }

        if($request->isMethod('post')){
            $start_date = date("Y-m-d H:i:s",strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s",strtotime($request->input('end_date')));
        }

        $sku_list = OrderSkuRelationModel
            ::select(DB::raw('sum(quantity * price) as sale_money,sum(quantity) as count,id,sku_id,sku_number,product_id'))
            ->where('refund_status','=', 0)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('sku_id')
            ->orderBy('sale_money','desc')
            ->paginate($this->per_page);
        return view('home/statistics.skuSale',[
            'sku_list' => $sku_list,
            'time' => $time,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

    }
}
