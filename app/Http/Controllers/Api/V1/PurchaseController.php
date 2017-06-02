<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\PurchaseTransformer;
use App\Models\ProductsModel;
use App\Models\ProductsSkuModel;
use App\Models\PurchaseModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;
use Illuminate\Support\Facades\Log;

class PurchaseController extends BaseController
{
    /**
     * @api {get} /api/purchases/{purchase_id}  采购订单详情
     * @apiVersion 1.0.0
     * @apiName Purchase index
     * @apiGroup Purchase
     *
     * @apiParam {string} token token
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
                "storage_status_val": "已入库",
                "verified": 9,      //审核状态：0.未审核；1.业管主管；2.财务；9.通过
                "verified_val": "通过审核"
            },
            "meta": {
                "message": "Success.",
                "status_code": 200
            }
        }
     */
    public function index($id)
    {
        $purchase = PurchaseModel::where('id' , $id)->first();
        if(!$purchase){
            return $this->response->array(ApiHelper::error('没有采购订单', 404));
        }
        $purchase->purchaseIndex($purchase);
        return $this->response->item($purchase, new PurchaseTransformer())->setMeta(ApiHelper::meta());


    }

    /**
     * @api {get} /api/purchases 采购订单展示
     * @apiVersion 1.0.0
     * @apiName Purchase lists
     * @apiGroup Purchase
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
                    "storage_status_val": "已入库",
                    "verified": 9,
                    "verified_val": "通过审核"
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
                    "storage_status_val": "已入库",
                    "verified": 9,
                    "verified_val": "通过审核"
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
        $per_page = $request->input('per_page') ?? $this->per_page;
        $lists = PurchaseModel::query();
        $purchases = $lists->paginate($per_page);
        foreach ($purchases as $purchase){
            $purchase->purchaseIndex($purchase);

        }

        return $this->response->paginator($purchases, new PurchaseTransformer())->setMeta(ApiHelper::meta());

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
