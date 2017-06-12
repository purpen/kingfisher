<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\PurchaseInvoiceTransformer;
use App\Models\PurchaseModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;

class PurchaseInvoiceController extends BaseController
{
    /**
     * @api {get} /api/pInvoice/{pInvoice_id}  采购发票详情
     * @apiVersion 1.0.0
     * @apiName pInvoice index
     * @apiGroup pInvoice
     *
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
        {
            "data": {
                "id": 1,
                "invoice_info": "",
                "invoice_time": "",
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
        $pInvoice = PurchaseModel::where('id' , $id)->first();
        if(!$pInvoice){
            return $this->response->array(ApiHelper::error('没有采购订单', 404));
        }
        $pInvoice->purchaseIndex($pInvoice);
        return $this->response->item($pInvoice, new PurchaseInvoiceTransformer())->setMeta(ApiHelper::meta());


    }

    /**
     * @api {get} /api/pInvoices 采购发票展示
     * @apiVersion 1.0.0
     * @apiName pInvoice lists
     * @apiGroup pInvoice
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
                    "invoice_info": "",
                    "invoice_time": "",
                    "supplier_name": null,
                    "product_name": null,
                    "mode": null,
                    "weight": null,
                    "unit_price": null,
                    "count": 200,
                    "total_price": "336002.00",
                    "storage_status": 5,
                    "storage_status_val": "已入库", //入库状态： 0.未入库；1.入库中；5.已入库
                    "verified": 9,
                    "verified_val": "通过审核" //审核状态：0.未审核；1.业管主管；2.财务；9.通过
                },
                {
                    "id": 2,
                    "invoice_info": "",
                    "invoice_time": "",
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
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = PurchaseModel::query();
        $pInvoices = $lists->paginate($per_page);
        foreach ($pInvoices as $pInvoice){
            $pInvoice->purchaseIndex($pInvoice);

        }

        return $this->response->paginator($pInvoices, new PurchaseInvoiceTransformer())->setMeta(ApiHelper::meta());

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