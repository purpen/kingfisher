<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\SalesInvoiceTransformer;
use App\Models\OrderModel;
use App\Models\OrderUserModel;
use App\Models\ProductsModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvoiceController extends BaseController
{
    /**
     * @api {get} /api/salesInvoice/{salesInvoice_id}  销售发票详情
     * @apiVersion 1.0.0
     * @apiName salesInvoice index
     * @apiGroup salesInvoice
     *
     * @apiParam {string} token token
     *
     * @apiSuccess {string} invoice_info 发票信息
     * @apiSuccess {string} invoice_time 开票时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} buyer_name 客服名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {string} price 单价
     * @apiSuccess {integer} quantity 商品数量
     *
     * @apiSuccessExample 成功响应:
     *
        {
            "data": {
                "id": 2,
                "invoice_info": "",
                "invoice_time": "",
                "product_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底",
                "buyer_name": "客服名称",
                "mode": "绿色底",
                "weight": "0.00",
                "unit_price": "299.00",
                "quantity": 1,
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index(Request $request , $id)
    {

        $salesInvoice = DB::table('order_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
            ->where('order.type' , 2)
            ->where('order.id' , (int)$id)
            ->get();

        $salesInvoices = collect($salesInvoice);
        return $this->response->collection($salesInvoices, new SalesInvoiceTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /api/salesInvoices 销售发票展示
     * @apiVersion 1.0.0
     * @apiName salesInvoice lists
     * @apiGroup salesInvoice
     * @apiParam {string} start_date 开始时间 例:20170615
     * @apiParam {string} end_date 结束时间 例:20170618
     * @apiParam {string} token token
     * @apiParam {string} random_id 客户编号
     *
     * @apiSuccess {string} invoice_info 发票信息
     * @apiSuccess {string} invoice_time 开票时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} buyer_name 客服名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {string} price 单价
     * @apiSuccess {integer} quantity 商品数量
     *
     * @apiSuccessExample 成功响应:
     *
        {
            "data": [
                {
                    "id": 1,
                    "invoice_info": "",
                    "invoice_time": "",
                    "product_name": "婴萌全球首款智能配奶机 --米灰",
                    "buyer_name": "蔡",
                    "mode": "米灰",
                    "weight": "0.00",
                    "unit_price": "1680.00",
                    "quantity": 1,
                },
                {
                    "id": 2,
                    "invoice_info": "",
                    "invoice_time": "",
                    "product_name": "emoi基本生活 智能情感音响灯H0016 APP控制--绿色底",
                    "buyer_name": "客服名称",
                    "mode": "绿色底",
                    "weight": "0.00",
                    "unit_price": "299.00",
                    "quantity": 1,
                },
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
        if(!empty($random_id)){
            $membership = OrderUserModel::where('random_id' , $random_id)->first();
            if(!$membership){
                return $this->response->array(ApiHelper::error('没有找到该客户', 404));
            }
            $mem_id = $membership->id;
            $order = OrderModel::where('order_user_id' , $mem_id)->first();
            if(!$order){
                return $this->response->array(ApiHelper::error('没有找到销售发票', 404));

            }
            $salesInvoice = DB::table('order_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
                ->where('order.type' , 2)
                ->whereIn('order.order_user_id' ,  $mem_id)
                ->whereBetween('order.created_at', [$start_date , $end_date])
                ->get();
        }else{
            $salesInvoice = DB::table('order_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
                ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
                ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
                ->where('order.type' , 2)
                ->whereBetween('order.created_at', [$start_date , $end_date])
                ->get();
        }
        $salesInvoices = collect($salesInvoice);

        return $this->response->collection($salesInvoices, new SalesInvoiceTransformer())->setMeta(ApiHelper::meta());

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
