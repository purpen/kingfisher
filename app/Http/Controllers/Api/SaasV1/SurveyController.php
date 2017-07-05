<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Http\SaasTransformers\HourOrderTransformer;
use App\Http\SaasTransformers\OrderDistributionTransformer;
use App\Http\SaasTransformers\SalesTrendsTransformer;
use App\Models\OrderModel;
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
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-365 day"));
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
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-365 day"));
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
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d",strtotime("-365 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d",strtotime($start_time));
        $end_time = date("Y-m-d",strtotime($end_time));

        $lists = OrderModel::select(DB::raw('count(*) as order_count, sum(pay_money) as sum_money, DATE_FORMAT(order_start_time,"%H") as time'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->groupBy('time')->get();

        return $this->response->collection($lists, new HourOrderTransformer)->setMeta(ApiHelper::meta());
    }

}