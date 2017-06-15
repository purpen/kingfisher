<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiHelper;
use App\Http\Transformers\SalesInvoiceTransformer;
use App\Models\OrderModel;
use Illuminate\Http\Request;

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
     * @apiSuccess {string} pay_money 总价
     * @apiSuccess {string} supplier_name 供应商名称
     * @apiSuccess {string} sup_random_id 供应商编号
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
                "pay_money": "300.00",
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

        return $this->response->item($salesOrder, new SalesInvoiceTransformer())->setMeta(ApiHelper::meta());

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
     *
     * @apiSuccess {string} invoice_info 发票信息
     * @apiSuccess {string} invoice_time 开票时间
     * @apiSuccess {string} product_name 商品名称
     * @apiSuccess {string} buyer_name 客服名称
     * @apiSuccess {string} mode 商品规格
     * @apiSuccess {string} weight 商品重量
     * @apiSuccess {string} price 单价
     * @apiSuccess {integer} quantity 商品数量
     * @apiSuccess {string} pay_money 总价
     * @apiSuccess {string} supplier_name 供应商名称
     * @apiSuccess {string} sup_random_id 供应商编号
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
                    "pay_money": "1695.00",
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
                    "pay_money": "300.00",
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
        $per_page = $request->input('per_page') ? $this->per_page : '';
        $lists = OrderModel::query();
        $lists->where('type' , 2);
        $salesInvoices = $lists->paginate($per_page);

        foreach ($salesInvoices as $salesInvoice)
        {
            $salesInvoice->OrderLists($salesInvoice);

        }

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
