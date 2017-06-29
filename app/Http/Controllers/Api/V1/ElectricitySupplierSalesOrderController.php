<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\ESSalesOrderTransformer;
use App\Models\OrderModel;
use App\Models\OrderUserModel;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ElectricitySupplierSalesOrderController extends BaseController
{
    /**
     * @api {get} /api/ESSalesOrder/{order_sku_relation_id}  电商销售订单详情
     * @apiVersion 1.0.0
     * @apiName ESSalesOrders index
     * @apiGroup ESSalesOrders
     *
     * @apiParam {string} token token
     *
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} order_start_time 下单时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {integer} form_app 应用来源：1.商城；2. Fiu
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {string} price 单价
     * @apiSuccess {string} pay_money 总价
     * @apiSuccess {integer} quantity 商品数量
     * @apiSuccess {integer} status 状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiSuccess {string} refund_status 退货退款状态	0:默认,1:已退款2:已退货3:已返修
     * @apiSuccess {string} platform 商品来源	1.淘宝；2.京东；3.自营平台；4.虚拟店铺；5.众筹
     *
     * @apiSuccessExample 成功响应:
     *
        {
            "data": {
                "id": 1,
                "number": "DD2017060100001",
                "order_start_time": "2017-06-01 13:38:43",
                "product_name": "婴萌全球首款智能配奶机 --米灰",
                "form_app": 0, //应用来源：1.商城；2. Fiu
                "mode": "米灰",
                "weight": "0.00",
                "unit_price": "1680.00",
                "quantity": 1,
                "pay_money": "1695.00",
                "status": 10,
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index(Request $request , $id)
    {

        $ESSalesOrder = DB::table('order_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
            ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->join('stores', 'stores.id', '=', 'order.store_id')
            ->select('products_sku.*', 'products.title',  'stores.platform' , 'order_sku_relation.*' , 'order_sku_relation.id as order_sku_relation_id'  ,'order.*' )
            ->whereIn('order.type' , [3 , 5])
            ->where('order_sku_relation.id' , (int)$id)
            ->get();
        if(!$ESSalesOrder){
            return $this->response->array(ApiHelper::error('没有找到相关的销售订单', 404));
        }
        $ESSalesOrders = collect($ESSalesOrder);

        return $this->response->collection($ESSalesOrders, new ESSalesOrderTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /api/ESSalesOrders 电商销售订单展示
     * @apiVersion 1.0.0
     * @apiName ESSalesOrders lists
     * @apiGroup ESSalesOrders
     *
     * @apiParam {string} token token
     * @apiParam {string} start_date 开始时间 例:20170615
     * @apiParam {string} end_date 结束时间 例:20170618
     * @apiParam {string} random_id 客户编号
     *
     *
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} order_start_time 下单时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {integer} form_app 应用来源：1.商城；2. Fiu
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {string} price 单价
     * @apiSuccess {string} pay_money 总价
     * @apiSuccess {integer} quantity 商品数量
     * @apiSuccess {integer} status 状态: 0.取消(过期)；1.待付款；5.待审核；8.待发货；10.已发货；20.完成
     * @apiSuccess {string} refund_status 退货退款状态	0:默认,1:已退款2:已退货3:已返修
     * @apiSuccess {string} platform 商品来源	1.淘宝；2.京东；3.自营平台；4.虚拟店铺；5.众筹
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
                    "form_app": 1,
                    "form_app_val": "商城",
                    "mode": "米灰",
                    "weight": "0.00",
                    "unit_price": "1680.00",
                    "quantity": 1,
                    "pay_money": "1695.00",
                    "status": 10,
                },
                {
                    "id": 2,
                    "number": "DD2017060200001",
                    "order_start_time": "2017-06-02 09:35:48",
                    "product_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底",
                    "form_app": 2,
                    "form_app_val": "Fiu",
                    "mode": "绿色底",
                    "weight": "0.00",
                    "unit_price": "299.00",
                    "quantity": 1,
                    "pay_money": "300.00",
                    "status": 10,
                }
            ],
            "meta": {
            "message": "Success.",
            "status_code": 200,
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
            $ESSalesOrder = DB::table('order_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
                ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->join('stores', 'stores.id', '=', 'order.store_id')
                ->select('products_sku.*', 'products.title',  'stores.platform',  'order_sku_relation.*' , 'order_sku_relation.id as order_sku_relation_id'  ,'order.*' )
                ->whereBetween('order.created_at', [$start_date , $end_date])
                ->whereIn('order.type' , [3 , 5])
                ->where('order.order_user_id' , $mem_id)
                ->get();
        }else{
            $ESSalesOrder = DB::table('order_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
                ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->join('stores', 'stores.id', '=', 'order.store_id')
                ->select('products_sku.*', 'products.title' , 'stores.platform',  'order_sku_relation.*' , 'order_sku_relation.id as order_sku_relation_id'  ,'order.*' )
                ->whereBetween('order.created_at', [$start_date , $end_date])
                ->whereIn('order.type' , [3 , 5])
                ->get();
        }
        $ESSalesOrders = collect($ESSalesOrder);
        return $this->response->collection($ESSalesOrders, new ESSalesOrderTransformer())->setMeta(ApiHelper::meta());

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
