<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\DeliveryTransformer;
use App\Http\Transformers\SupplierTransformer;
use App\Models\OrderModel;
use App\Models\OrderUserModel;
use App\Models\ProductsModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} order_start_time 下单时间
     * @apiSuccess {string} order_send_time 配送时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {integer} quantity 商品数量
     * @apiSuccess {integer} status 配送状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiSuccess {string} express_no 配送单号
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
                "express_no": "1203455"     //配送单号
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index(Request $request , $id)
    {
        $delivery = DB::table('order_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
            ->where('order.id' , (int)$id)
            ->get();
        if(!$delivery){
            return $this->response->array(ApiHelper::error('没有找到相关的销售订单', 404));
        }
        $deliveries = collect($delivery);

        return $this->response->collection($deliveries, new DeliveryTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /api/deliveries  配送列表
     * @apiVersion 1.0.0
     * @apiName delivery lists
     * @apiGroup delivery
     *
     * @apiParam {string} token token
     * @apiParam {string} start_date 开始时间 例:20170615
     * @apiParam {string} end_date 结束时间 例:20170618
     * @apiParam {string} random_id 客户编号
     *
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} order_start_time 下单时间
     * @apiSuccess {string} order_send_time 配送时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {integer} quantity 商品数量
     * @apiSuccess {integer} status 配送状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiSuccess {string} express_no 配送单号
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
        $time = null;
        $start_date = null;
        $end_date = null;

        if($request->isMethod('get')){
            if($request->input('start_date')){
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
            }else{
                $time = $request->input('time')?(int)$request->input('time'):30;
                $start_date = date("Y-m-d H:i:s",strtotime("-" . $time ." day"));
                $end_date = date("Y-m-d H:i:s");
            }
        }

        if($request->isMethod('post')){
            $start_date = date("Y-m-d H:i:s",strtotime($request->input('start_date')));
            $end_date = date("Y-m-d H:i:s",strtotime($request->input('end_date')));
        }
        $random_id = $request->input('random_id');
        if(!empty($random_id)){
            $membership = OrderUserModel::where('random_id' , $random_id)->first();
            if(!$membership){
                return $this->response->array(ApiHelper::error('没有找到该客户', 404));
            }
            $mem_id = $membership->id;
            $delivery = DB::table('order_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
                ->where('order.order_user_id' , $mem_id)
                ->whereBetween('order.created_at', [$start_date , $end_date])
                ->get();
        }else{
            $delivery = DB::table('order_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
                ->whereBetween('order.created_at', [$start_date , $end_date])
                ->get();
        }

        $deliveries = collect($delivery);

        return $this->response->collection($deliveries, new DeliveryTransformer())->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /api/sup_name  根据供应商全称获取编号
     * @apiVersion 1.0.0
     * @apiName ApiSupplier lists
     * @apiGroup ApiSupplier
     *
     * @apiParam {string} token token
     * @apiParam {string} supplier_name 供应商名称
     *
     * @apiSuccess {string} random_id 供应商编号
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "random_id": wed223,
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function sup_name(Request $request)
    {
        $sup_name = $request->input('supplier_name');
        $supplier = SupplierModel::where('name' , $sup_name)->first();
        if(!$supplier){
            return $this->response->array(ApiHelper::error('没有找到该供应商', 404));
        }
        return $this->response->item($supplier, new SupplierTransformer())->setMeta(ApiHelper::meta());

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
