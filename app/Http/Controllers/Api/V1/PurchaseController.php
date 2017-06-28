<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\PurchaseTransformer;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends BaseController
{
    /**
     * @api {get} /api/purchases/{purchase_sku_id}  采购订单详情
     * @apiVersion 1.0.0
     * @apiName Purchase index
     * @apiGroup Purchase
     *
     * @apiParam {string} token token
     *
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} predict_time  下单时间
     * @apiSuccess {string} supplier_name  供应商名称
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {string} price 单价
     * @apiSuccess {string} total_price 总价
     * @apiSuccess {integer} count 商品数量
     * @apiSuccess {integer} storage_status 入库状态： 0.未入库；1.入库中；5.已入库
     * @apiSuccess {integer} verified 审核状态：0.未审核；1.业管主管；2.财务；9.通过
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 1,
                "number": "CG2017053100001",
                "predict_time": "2017-06-01",
                "supplier_name": "北京太火鸟",
                "product_name": "婴萌全球首款智能配奶机 ",
                "mode": "米灰",
                "weight": "0.00",
                "unit_price": "1680.00",
                "count": 200,
                "total_price": "336002.00",
                "storage_status": 5, //入库状态： 0.未入库；1.入库中；5.已入库
                "verified": 9,      //审核状态：0.未审核；1.业管主管；2.财务；9.通过
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index(Request $request , $id)
    {
        $purchase = DB::table('purchase_sku_relation')
            ->join('products_sku' , 'products_sku.id' , '=' ,'purchase_sku_relation.sku_id')
            ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
            ->join('purchases', 'purchases.id', '=', 'purchase_sku_relation.purchase_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('purchases.*', 'suppliers.name as supplier_name' , 'purchases.number as purchase_number','purchase_sku_relation.*' , 'purchase_sku_relation.id as purchase_sku_id' , 'products_sku.*', 'products.*' )
            ->where('purchase_sku_relation.id' , (int)$id)
            ->get();
        if(!$purchase){
            return $this->response->array(ApiHelper::error('没有找到相关的采购订单', 404));
        }
        $purchases = collect($purchase);
        return $this->response->collection($purchases, new PurchaseTransformer())->setMeta(ApiHelper::meta());
    }

    /**
     * @api {get} /api/purchases 采购订单展示
     * @apiVersion 1.0.0
     * @apiName Purchase lists
     * @apiGroup Purchase
     *
     * @apiParam {string} token token
     * @apiParam {string} start_date 开始时间 例:20170615
     * @apiParam {string} end_date 结束时间 例:20170618
     * @apiParam {string} random_id 供应商编号
     *
     * @apiSuccess {string} number 订单号
     * @apiSuccess {string} predict_time  下单时间
     * @apiSuccess {string} supplier_name  供应商名称
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {string} price 单价
     * @apiSuccess {string} total_price 总价
     * @apiSuccess {integer} count 商品数量
     * @apiSuccess {integer} storage_status 入库状态： 0.未入库；1.入库中；5.已入库
     * @apiSuccess {integer} verified 审核状态：0.未审核；1.业管主管；2.财务；9.通过
     *
     * @apiSuccessExample 成功响应:
     *
        {
            "data": [
                {
                    "id": 1,
                    "number": "CG2017053100001",
                    "predict_time": "2017-06-01",
                    "supplier_name": null,
                    "product_name": null,
                    "mode": null,
                    "weight": null,
                    "unit_price": null,
                    "count": 200,
                    "total_price": "336002.00",
                    "storage_status": 5,
                    "verified": 9,
                },
                {
                    "id": 2,
                    "number": "CG2017060100001",
                    "predict_time": "2017-06-15",
                    "supplier_name": null,
                    "product_name": null,
                    "mode": null,
                    "weight": null,
                    "unit_price": null,
                    "count": 100,
                    "total_price": "29902.00",
                    "storage_status": 5,
                    "verified": 9,
                }
            ],
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
            $suppliers = SupplierModel::where('random_id' , $random_id)->first();
            if(!$suppliers){
                return $this->response->array(ApiHelper::error('没有找到该供应商', 404));
            }
            $sup_id = $suppliers->id;
            $purchase = DB::table('purchase_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'purchase_sku_relation.sku_id')
                ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
                ->join('purchases', 'purchases.id', '=', 'purchase_sku_relation.purchase_id')
                ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
                ->select('purchases.*', 'suppliers.name as supplier_name', 'purchases.number as purchase_number','purchase_sku_relation.*' , 'purchase_sku_relation.id as purchase_sku_id' , 'products_sku.*', 'products.*' )
                ->whereBetween('purchases.created_at', [$start_date , $end_date])
                ->where('products.supplier_id' , '=' ,(int)$sup_id)
                ->get();
        }else{
            $purchase = DB::table('purchase_sku_relation')
                ->join('products_sku' , 'products_sku.id' , '=' ,'purchase_sku_relation.sku_id')
                ->join('products' , 'products.id' , '=' , 'products_sku.product_id')
                ->join('purchases', 'purchases.id', '=', 'purchase_sku_relation.purchase_id')
                ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
                ->select('purchases.*', 'suppliers.name', 'purchases.number as purchase_number','purchase_sku_relation.*' , 'purchase_sku_relation.id as purchase_sku_id' , 'products_sku.*', 'products.*' )
                ->whereBetween('purchases.created_at', [$start_date , $end_date])
                ->get();
        }
        $purchases = collect($purchase);
        return $this->response->collection($purchases, new PurchaseTransformer())->setMeta(ApiHelper::meta());

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
