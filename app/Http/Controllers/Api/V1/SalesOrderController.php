<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\SalesOrderTransformer;
use App\Models\OrderModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SalesOrderController extends BaseController
{
    /**
     * @api {get} /api/salesOrder/{salesOrder_id}  销售订单详情
     * @apiVersion 1.0.0
     * @apiName salesOrder index
     * @apiGroup salesOrder
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     *
        {
            "data": {
                "id": 2,
                "number": "DD2017060200001",
                "order_start_time": "2017-06-02 09:35:48",
                "product_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底",
                "buyer_name": "客服名称",
                "mode": "绿色底",
                "weight": "0.00",
                "unit_price": "299.00",
                "quantity": 1,
                "pay_money": "300.00",
                "status": 10,  //状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
                "status_val": "已发货"
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index($id)
    {
        $salesOrder = OrderModel::where('id' , $id)->where('type' , 2)->first();
        if(!$salesOrder){
            return $this->response->array(ApiHelper::error('没有销售订单', 404));
        }
        $salesOrder->salesOrder($salesOrder);

        return $this->response->item($salesOrder, new SalesOrderTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /api/salesOrders 销售订单展示
     * @apiVersion 1.0.0
     * @apiName salesOrder lists
     * @apiGroup salesOrder
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     *
        {
            "data": [
                {
                    "id": 1,
                    "number": "DD2017060100001",
                    "order_start_time": "2017-06-01 13:38:43",
                    "product_name": "婴萌全球首款智能配奶机 --米灰",
                    "buyer_name": "蔡",
                    "mode": "米灰",
                    "weight": "0.00",
                    "unit_price": "1680.00",
                    "quantity": 1,
                    "pay_money": "1695.00",
                    "status": 10,
                    "status_val": "已发货"
                },
                {
                    "id": 2,
                    "number": "DD2017060200001",
                    "order_start_time": "2017-06-02 09:35:48",
                    "product_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底",
                    "buyer_name": "客服名称",
                    "mode": "绿色底",
                    "weight": "0.00",
                    "unit_price": "299.00",
                    "quantity": 1,
                    "pay_money": "300.00",
                    "status": 10,
                    "status_val": "已发货"
                },
            ],
                "meta": {
                    "message": "Success.",
                    "status_code": 200,
                    "pagination": {
                    "total": 3,
                    "count": 3,
                    "per_page": 15,
                    "current_page": 1,
                    "total_pages": 1,
                    "links": []
                }
            }
        }
     */
    public function lists(Request $request)
    {
        $per_page = $request->input('per_page') ?? $this->per_page;
        $lists = OrderModel::query();
        $lists->where('type' , 2);
        $salesOrders = $lists->paginate($per_page);

        foreach ($salesOrders as $salesOrder)
        {
            $salesOrder->OrderLists($salesOrder);

        }

        return $this->response->paginator($salesOrders, new SalesOrderTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
