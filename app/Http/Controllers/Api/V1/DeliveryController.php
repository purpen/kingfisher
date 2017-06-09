<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\DeliveryTransformer;
use App\Models\OrderModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DeliveryController extends BaseController
{
    /**
     * @api {get} /api/delivery/{delivery_id}  配送详情
     * @apiVersion 1.0.0
     * @apiName delivery index
     * @apiGroup delivery
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 2,
                "number": "DD2017060200001",    //订单号
                "order_start_time": "2017-06-02 09:35:48", //下单时间
                "order_send_time": "2017-06-02 09:37:22",   //配送时间
                "product_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底", //商品名称
                "mode": "绿色底",  // 商品规格
                "weight": "0.00",   //商品重量
                "quantity": 1,      //商品数量
                "status": 10,
                "status_val": "已发货",    //配送状态
                "express_no": "1203455"     //配送单号
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index($id)
    {
        $delivery = OrderModel::where('id' , $id)->first();
        if(!$delivery){
            return $this->response->array(ApiHelper::error('没有配送信息', 404));
        }
        $delivery->salesOrder($delivery);

        return $this->response->item($delivery, new DeliveryTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /api/deliveries  配送列表
     * @apiVersion 1.0.0
     * @apiName delivery lists
     * @apiGroup delivery
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 2,
                "number": "DD2017060200001",    //订单号
                "order_start_time": "2017-06-02 09:35:48", //下单时间
                "order_send_time": "2017-06-02 09:37:22",   //配送时间
                "product_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底", //商品名称
                "mode": "绿色底",  // 商品规格
                "weight": "0.00",   //商品重量
                "quantity": 1,      //商品数量
                "status": 10,
                "status_val": "已发货",    //配送状态
                "express_no": "1203455"     //配送单号
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function lists(Request $request)
    {
        $per_page = $request->input('per_page') ?? $this->per_page;
        $lists = OrderModel::query();
        $deliveries = $lists->paginate($per_page);
        foreach ($deliveries as $delivery)
        {
            $delivery->OrderLists($delivery);

        }

        return $this->response->paginator($deliveries, new DeliveryTransformer())->setMeta(ApiHelper::meta());
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
