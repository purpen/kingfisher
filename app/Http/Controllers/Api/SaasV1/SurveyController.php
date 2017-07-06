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
     * "data": [
     * {
     * "cooperation_count"：12，  // 合作数量
     * "sales_volume": 123,        // 销售额
     * "order_quantity": 23333,        // 订单数
     * }
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200,
     * }
     * }
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
     * "data": [
     * {
     * "order_count": 23,        // 当天订单数量
     * "sum_money": "5003.39",   // 当天订单总金额
     * "time": "2016-12-22"      // 日期
     * },
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200,
     * }
     * }
     */
    public function salesTrends(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d", strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d", strtotime($start_time));
        $end_time = date("Y-m-d", strtotime($end_time));

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
     * "data": [
     * {
     * "order_count": 1,            // 订单数量
     * "buyer_province": "上海",     // 地区
     * "sum_money": "69.00"         // 总金额
     * },
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200,
     * }
     * }
     */
    public function orderDistribution(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d", strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d", strtotime($start_time));
        $end_time = date("Y-m-d", strtotime($end_time));

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
     * "data": [
     * {
     * "order_count": 23,        // 小时订单数量
     * "sum_money": "5003.39",   // 小时订单总金额
     * "time": "10"      // 小时
     * },
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200,
     * }
     * }
     */
    public function hourOrder(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d", strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d", strtotime($start_time));
        $end_time = date("Y-m-d", strtotime($end_time));

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
     * "data": [
     * {
     * "sum_money": "85609.03",                // 销售额
     * "sales_quantity": "138",                // 数量
     * "sku_number": "",                       // sku编号
     * "sku_id": 73,                           // sku的id
     * "sku_name": "这是第一个产品吗--黑色",     // 商品名称--型号
     * "proportion": "98.38"                   //销售金额占半分比
     * },
     * ],
     * "meta": {
     * "message": "Success.",
     * "status_code": 200,
     * }
     * }
     */
    public function salesRanking(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d", strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d", strtotime($start_time));
        $end_time = date("Y-m-d", strtotime($end_time));

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
     * {
     * "meta": {
     * "message": "Success.",
     * "status_code": 200
     * },
     * "data": {
     * "1": "11.11",   // 购买一次
     * "2": "0.00",
     * "3": "5.56",
     * "4": "0.00",
     * "5": "0.00",
     * "6": "0.00",
     * "7": "0.00",
     * "8": "0.00",
     * "9": "0.00",
     * "10": "83.33"   // 购买10次及以上
     * }
     * }
     */
    public function repeatPurchase(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d", strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d", strtotime($start_time));
        $end_time = date("Y-m-d", strtotime($end_time));

        $lists = OrderModel::select(DB::raw('count(*) as order_count, buyer_phone'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->groupBy('buyer_phone')->get();

        $count = OrderModel::select(DB::raw('count(*) as order_count'))
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->first()->order_count;

        $a1 = $a2 = $a3 = $a4 = $a5 = $a6 = $a7 = $a8 = $a9 = $a10 = 0.00;
        foreach ($lists as $v) {
            $order_count = $v->order_count;
            switch ($order_count) {
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

        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $a = 'a' . $i;
            $data[$i] = $$a ? sprintf("%0.2f", ($$a / $count * 100)) : $$a;
        }

        return $this->response->array(ApiHelper::success('Success.', 200, $data));
    }

    /**
     * @api {get} /saasApi/survey/customerPriceDistribution 客单价分布
     * @apiVersion 1.0.0
     * @apiName Survey customerPriceDistribution
     * @apiGroup Survey
     *
     * @apiParam {string} start_time 开始时间（2016-12-22）
     * @apiParam {string} end_time 结束时间（2016-12-22）
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "meta": {
     *      "message": "Success",
     *      "status_code": 200
     * },
     * "data": [
     * {
     *      "0-100": 38,                     // 订单数量
     *      "proportion": "84.44"            // 百分比
     * },
     * {
     *      "100-200": 4,
     *      "proportion": "8.89"
     * },
     * {
     * "200-300": 2,
     * "proportion": "4.44"
     * },
     * {
     * "300-400": 1,
     * "proportion": "2.22"
     * },
     * {
     * "400-500": 0,
     * "proportion": "0.00"
     * },
     * {
     * "500-800": 0,
     * "proportion": "0.00"
     * },
     * {
     * "800-1000": 0,
     * "proportion": "0.00"
     * },
     * {
     * "1000-2000": 0,
     * "proportion": "0.00"
     * },
     * {
     * "2000-3000": 0,
     * "proportion": "0.00"
     * },
     * {
     * "3000-": 0,
     * "proportion": "0.00"
     * }
     * ]
     * }
     */
    public function customerPriceDistribution(Request $request)
    {
        $start_time = $request->input('start_time') ? $request->input('start_time') : date("Y-m-d", strtotime("-30 day"));
        $end_time = $request->input('end_time') ? $request->input('end_time') : date("Y-m-d");
        $start_time = date("Y-m-d", strtotime($start_time));
        $end_time = date("Y-m-d", strtotime($end_time));

        $lists = OrderModel::select('pay_money')
            ->whereBetween('order_start_time', [$start_time, $end_time])
            ->get();

        $config = [0, 100, 200, 300, 400, 500, 800, 1000, 2000, 3000, ''];
        $data = [];

        foreach ($lists as $val) {
            for ($i = 0; $i < count($config) - 1; $i++) {
                $min = $config[$i];
                $max = $config[$i + 1];
                $key = $min . '-' . $max;
                if (!array_key_exists($key, $data)) {
                    $data[$key] = 0;
                }
                if ($val->pay_money > $min && $val->pay_money <= $max) {
                    $data[$key] += 1;
                    break;
                }
            }
        }

        $total = array_sum($data);
        $t_data = [];
        foreach ($data as $k => $v) {
            $t_data[] = [$k => $v, 'proportion' => sprintf("%0.2f", $v / $total * 100)];
        }
        return $this->response->array(ApiHelper::success('Success', 200, $t_data));
    }

    /**
     * @api {get} /saasApi/survey/topFlag TOP20标签
     * @apiVersion 1.0.0
     * @apiName Survey topFlag
     * @apiGroup Survey
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "meta": {
     *      "message": "Success.",
     *      "status_code": 200
     *      },
     * "data": {
     *      "科技",
     *      "人工智能",
     *      "大数据",
     *      "深度学习",
     *      "区块链",
     *      "自动驾驶",
     *      "量子计算机",
     *      "量子纠缠"
     *      }
     * }
     */
    public function topFlag()
    {
        $data = ['科技', '人工智能', '大数据', '深度学习', "区块链", '自动驾驶', '量子计算机', '量子纠缠'];
        return $this->response->array(ApiHelper::success('Success', 200, $data));
    }

}