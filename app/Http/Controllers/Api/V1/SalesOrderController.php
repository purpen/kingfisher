<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\SalesOrderTransformer;
use App\Models\OrderModel;
use App\Models\OrderSkuRelationModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesOrderController extends BaseController
{
    /**
     * @api {get} /api/salesOrder/{salesOrder_id}  销售订单详情
     * @apiVersion 1.0.0
     * @apiName salesOrder index
     * @apiGroup salesOrder
     *
     * @apiParam {string} random_id 供应商编号
     * @apiParam {string} token token
     *
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} order_start_time 下单时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} buyer_name 客户名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {integer} quantity 商品数量
     * @apiSuccess {integer} status 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiSuccess {string} price 单价
     *
     * @apiSuccessExample 成功响应:
     *
        {
            "data": {
                "id": 277,
                "number": "DD2017060800008",
                "order_start_time": "2017-06-08 14:58:37",
                "buyer_name": "客服名称",
                "mode": "颜色型号",
                "weight": "0.00",
                "quantity": 1,
                "price": "299.00",
                "status": 10
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index(Request $request ,$id)
    {

        $random_id = $request->input('random_id');
        if($random_id == null){
            return $this->response->array(ApiHelper::error('请填写供应商编号', 404));
        }
        $suppliers = SupplierModel::where('random_id' , $random_id)->first();
        if(!$suppliers){
            return $this->response->array(ApiHelper::error('没有找到该供应商', 404));
        }
        $sup_id = $suppliers->id;
        $product_id = [];
        $products = ProductsModel::where('supplier_id' , $sup_id)->get();
        foreach ($products as $product){
            $product_id[] = $product->id;
        }
        $salesOrders = DB::table('order_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
            ->where('order.type' , 2)
            ->whereIn('order_sku_relation.product_id' ,  $product_id)
            ->where('order.id' , (int)$id)->first();
        if(!$salesOrders){
            return $this->response->array(ApiHelper::error('没有找到相关的销售订单', 404));
        }
        return $this->response->item($salesOrders, new SalesOrderTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /api/salesOrders 销售订单展示
     * @apiVersion 1.0.0
     * @apiName salesOrder lists
     * @apiGroup salesOrder
     *
     * @apiParam {string} start_date 开始时间 例:20170615
     * @apiParam {string} end_date 结束时间 例:20170618
     * @apiParam {string} token token
     * @apiParam {string} random_id 供应商编号
     *
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} order_start_time 下单时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} buyer_name 客户名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {integer} quantity 商品数量
     * @apiSuccess {integer} status 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiSuccess {string} price 单价
     *
     * @apiSuccessExample 成功响应:
     *
        {

        "data": [
            {
                "id": 277,
                "number": "DD2017060800008",
                "order_start_time": "2017-06-08 14:58:37",
                "buyer_name": "客服名称",
                "mode": "颜色型号",
                "weight": "0.00",
                "quantity": 1,
                "price": "299.00",
                "status": 10
            },
            {
                "id": 376,
                "number": "DD2017061400001",
                "order_start_time": "2017-06-14 16:02:43",
                "buyer_name": "客服名称",
                "mode": "颜色型号",
                "weight": "0.00",
                "quantity": 1,
                "price": "299.00",
                "status": 5
            },
            {
                "id": 377,
                "number": "DD2017061400002",
                "order_start_time": "2017-06-14 17:01:28",
                "buyer_name": "蔡",
                "mode": "颜色型号",
                "weight": "0.00",
                "quantity": 1,
                "price": "299.00",
                "status": 5
            },
            {
                "id": 378,
                "number": "DD2017061400003",
                "order_start_time": "2017-06-14 17:04:11",
                "buyer_name": "客服名称",
                "mode": "颜色型号",
                "weight": "0.00",
                "quantity": 1,
                "price": "299.00",
                "status": 5
            }
            ],
            "meta": {
                "message": "Success.",
                "status_code": 200,
                }
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
        if($random_id == null){
            return $this->response->array(ApiHelper::error('请填写供应商编号', 404));
        }
        $suppliers = SupplierModel::where('random_id' , $random_id)->first();
        $sup_id = $suppliers->id;
        $product_id = [];
        $products = ProductsModel::where('supplier_id' , $sup_id)->get();
        foreach ($products as $product){
            $product_id[] = $product->id;
        }
        $salesOrder = DB::table('order_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
            ->where('order.type' , 2)
            ->whereIn('order_sku_relation.product_id' ,  $product_id)
            ->whereBetween('order.created_at', [$start_date , $end_date])
            ->get();
        $salesOrders = collect($salesOrder);
        return $this->response->collection($salesOrders, new SalesOrderTransformer())->setMeta(ApiHelper::meta());

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
