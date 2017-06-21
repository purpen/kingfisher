<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\SalesInvoiceTransformer;
use App\Models\OrderModel;
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
     * @apiParam {string} random_id 供应商编号
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
        $salesInvoices = DB::table('order_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
            ->where('order.type' , 2)
            ->whereIn('order_sku_relation.product_id' ,  $product_id)
            ->where('order.id' , (int)$id)->first();
        if(!$salesInvoices){
            return $this->response->array(ApiHelper::error('没有找到相关的销售订单', 404));
        }

        return $this->response->item($salesInvoices, new SalesInvoiceTransformer())->setMeta(ApiHelper::meta());

    }

    /**
     * @api {get} /api/salesInvoices 销售发票展示
     * @apiVersion 1.0.0
     * @apiName salesInvoice lists
     * @apiGroup salesInvoice
     *
     * @apiParam {integer} per_page 分页数量  默认10
     * @apiParam {integer} page 页码
     * @apiParam {string} token token
     * @apiParam {string} random_id 供应商编号
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

        $random_id = $request->input('random_id');
        if($random_id == null){
            return $this->response->array(ApiHelper::error('请填写供应商编号', 404));
        }
        $per_page = $request->input('per_page') ? $request->input('per_page') : $this->per_page ;

        $suppliers = SupplierModel::where('random_id' , $random_id)->first();
        $sup_id = $suppliers->id;
        $product_id = [];
        $products = ProductsModel::where('supplier_id' , $sup_id)->get();
        foreach ($products as $product){
            $product_id[] = $product->id;
        }
        $salesInvoices = DB::table('order_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'order_sku_relation.sku_id')
            ->join('order', 'order.id', '=', 'order_sku_relation.order_id')
            ->select('products_sku.*',  'order_sku_relation.*' ,'order.*' )
            ->where('order.type' , 2)
            ->whereIn('order_sku_relation.product_id' ,  $product_id)
            ->paginate($per_page);

        return $this->response->paginator($salesInvoices, new SalesInvoiceTransformer())->setMeta(ApiHelper::meta());

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
