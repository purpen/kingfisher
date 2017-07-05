<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\HourOrderTransformer;
use App\Http\SaasTransformers\OrderDistributionTransformer;
use App\Http\SaasTransformers\SalesRankingTransformer;
use App\Http\SaasTransformers\SalesTrendsTransformer;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductUserRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends BaseController
{
    /**
     * @api {get} /saasApi/survey/index 账户概况
     * @apiVersion 1.0.0
     * @apiName Survey index
     * @apiGroup Survey
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
        "data": [
            {
                "cooperation_count"：12，  // 合作数量
                "sales_volume": 123,        // 销售额
                "order_quantity": 23333,        // 订单数
            }
        ],
        "meta": {
            "message": "Success.",
            "status_code": 200,
        }
      }
     */
    public function index()
    {
        // 合作数量
        $cooperation_count = ProductUserRelation::where(['user_id' => $this->auth_user_id, 'status' => 1])
            ->count();

        // 销售额
        $sales_volume = 10000000;

        // 订单数
        $order_quantity = 10000;

        $data = compact('cooperation_count', 'sales_volume', 'order_quantity');
        return $this->response->array(ApiHelper::success('Success.', 200, $data));
    }

    /**
     * @api {get} /saasApi/survey/salesTrends 销售趋势
     * @apiVersion 1.0.0
     * @apiName Survey salesTrends
     * @apiGroup Survey
     *
     * @apiParam {string} start_time 开始时间（2016-12-22）
     * @apiParam {string} end_time 结束时间（2016-12-22）
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
    "data": [
        {
        "order_count": 23,        // 当天订单数量
        "sum_money": "5003.39",   // 当天订单总金额
        "time": "2016-12-22"      // 日期
        },
    ],
    "meta": {
        "message": "Success.",
        "status_code": 200,
        }
    }
     */
    public function salesTrends(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d",strtotime($start_time));
        $end_time = date("Y-m-d",strtotime($end_time));

        $lists = OrderModel::select(DB::raw('count(*) as order_count, sum(pay_money) as sum_money, DATE_FORMAT(order_start_time,"%Y-%m-%d") as time'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->groupBy('time')->get();

        return $this->response->collection($lists, new SalesTrendsTransformer)->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/survey/orderDistribution 订单地域分布
     * @apiVersion 1.0.0
     * @apiName Survey 订单地域分布
     * @apiGroup Survey
     *
     * @apiParam {string} start_time 开始时间（2016-12-22）
     * @apiParam {string} end_time 结束时间（2016-12-22）
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
    "data": [
    {
    "order_count": 1,            // 订单数量
    "buyer_province": "上海",     // 地区
    "sum_money": "69.00"         // 总金额
    },
    ],
    "meta": {
    "message": "Success.",
    "status_code": 200,
    }
    }
     */
    public function orderDistribution(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d",strtotime($start_time));
        $end_time = date("Y-m-d",strtotime($end_time));

        $lists = OrderModel::select(DB::raw('count(*) as order_count, buyer_province, sum(pay_money) as sum_money'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->groupBy('buyer_province')->get();

        return $this->response->collection($lists, new OrderDistributionTransformer)->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/survey/hourOrder 24小时时间段销售统计
     * @apiVersion 1.0.0
     * @apiName Survey hourOrder
     * @apiGroup Survey
     *
     * @apiParam {string} start_time 开始时间（2016-12-22）
     * @apiParam {string} end_time 结束时间（2016-12-22）
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
    "data": [
    {
    "order_count": 23,        // 小时订单数量
    "sum_money": "5003.39",   // 小时订单总金额
    "time": "10"      // 小时
    },
    ],
    "meta": {
    "message": "Success.",
    "status_code": 200,
    }
    }
     */
    public function hourOrder(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d",strtotime($start_time));
        $end_time = date("Y-m-d",strtotime($end_time));

        $lists = OrderModel::select(DB::raw('count(*) as order_count, sum(pay_money) as sum_money, DATE_FORMAT(order_start_time,"%H") as time'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->groupBy('time')->get();

        return $this->response->collection($lists, new HourOrderTransformer)->setMeta(ApiHelper::meta());
    }

    /**
     * 商品销售排行
     */
    /**
     * @api {get} /saasApi/survey/salesRanking 商品销售排行
     * @apiVersion 1.0.0
     * @apiName Survey salesRanking
     * @apiGroup Survey
     *
     * @apiParam {string} start_time 开始时间（2016-12-22）
     * @apiParam {string} end_time 结束时间（2016-12-22）
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
        "data": [
            {
            "sum_money": "85609.03",                // 销售额
            "sales_quantity": "138",                // 数量
            "sku_number": "",                       // sku编号
            "sku_id": 73,                           // sku的id
            "sku_name": "这是第一个产品吗--黑色",     // 商品名称--型号
            "proportion": "98.38"                   //销售金额占半分比
            },
        ],
        "meta": {
            "message": "Success.",
            "status_code": 200,
        }
       }
     */
    public function salesRanking(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d",strtotime($start_time));
        $end_time = date("Y-m-d",strtotime($end_time));

        $lists = OrderSkuRelationModel
            ::select(DB::raw('sum(quantity*(price-discount)) as sum_money, sum(quantity) as sales_quantity, sku_number,sku_id,sku_name'))
            ->whereBetween('created_at', [$start_time, $end_time])
            ->groupBy('sku_number')
            ->orderBy('sum_money', 'desc')
            ->limit(100)
            ->get();

        $sum = OrderSkuRelationModel::select(DB::raw('sum(quantity*(price-discount)) as sum_money'))
            ->whereBetween('created_at', [$start_time, $end_time])
            ->first()->sum_money;

        return $this->response->collection($lists, new SalesRankingTransformer($sum))->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /saasApi/survey/repeatPurchase 重复购买率
     * @apiVersion 1.0.0
     * @apiName Survey repeatPurchase
     * @apiGroup Survey
     *
     * @apiParam {string} start_time 开始时间（2016-12-22）
     * @apiParam {string} end_time 结束时间（2016-12-22）
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
        {
            "meta": {
                "message": "Success.",
                "status_code": 200
            },
            "data": {
                "1": "11.11",   // 购买一次
                "2": "0.00",
                "3": "5.56",
                "4": "0.00",
                "5": "0.00",
                "6": "0.00",
                "7": "0.00",
                "8": "0.00",
                "9": "0.00",
                "10": "83.33"   // 购买10次及以上
            }
        }
     */
    public function repeatPurchase(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d",strtotime($start_time));
        $end_time = date("Y-m-d",strtotime($end_time));

        $lists = OrderModel::select(DB::raw('count(*) as order_count, buyer_phone'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->groupBy('buyer_phone')->get();

        $count = OrderModel::select(DB::raw('count(*) as order_count'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->first()->order_count;

        $a1 = $a2 = $a3 = $a4 = $a5 = $a6 = $a7 = $a8 = $a9 = $a10 = 0.00;
        foreach ($lists as $v){
            $order_count = $v->order_count;
            switch ($order_count){
                case 1:
                    $a1 += $order_count;
                    break;
                case 2:
                    $a2 += $order_count;
                    break;
                case 3:
                    $a3 += $order_count;
                    break;
                case 4:
                    $a4 += $order_count;
                    break;
                case 5:
                    $a5 += $order_count;
                    break;
                case 6:
                    $a6 += $order_count;
                    break;
                case 7:
                    $a7 += $order_count;
                    break;
                case 8:
                    $a8 += $order_count;
                    break;
                case 9:
                    $a9 += $order_count;
                    break;
                default:
                    $a10 += $order_count;
            }
        }

        $data = [
            1 => sprintf("%0.2f", ($a1/$count*100)),
            2 => sprintf("%0.2f", ($a2/$count*100)),
            3 => sprintf("%0.2f", ($a3/$count*100)),
            4 => sprintf("%0.2f", ($a4/$count*100)),
            5 => sprintf("%0.2f", ($a5/$count*100)),
            6 => sprintf("%0.2f", ($a6/$count*100)),
            7 => sprintf("%0.2f", ($a7/$count*100)),
            8 => sprintf("%0.2f", ($a8/$count*100)),
            9 => sprintf("%0.2f", ($a9/$count*100)),
            10 => sprintf("%0.2f", ($a10/$count*100)),
        ];

        return $this->response->array(ApiHelper::success('Success.', 200, $data));
    }

}