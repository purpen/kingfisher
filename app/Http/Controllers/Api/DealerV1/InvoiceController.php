<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Models\InvoiceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @api {get} /DealerApi/invoice 普通发票和专用发票添加
     * @apiVersion 1.0.0
     * @apiName invoice ordinary
     * @apiGroup invoice
     * @apiParam {string} status 1:立即购买进入的进货单
     * @apiParam {char} title 大米:搜索时所需参数
     * @apiParam {string} per_page 1:一页多少条数据
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                      // 购物车ID
     *      product_name :"大米",                   商品名称
     *      inventory  :40,                 商品库存数量
     *      market_price    "111",            商品销售价格
     *      cover_url   ：1.img ,              图片url
     *      "product_id": 4456,           // 商品ID
     *      "price": "200.00",            // 商品价格
     *      "mode":颜色：白色 ,                   类型
     *      "number": 1,                       // 购买数量
     *      "status": 3,                  // 状态：3添加，4立即购买
     *      "focus": 1,                  // 状态：1关注，2未关注
     *       "sku_region"[{
     *               min:1, //下限数量
     *              max:2,//上限数量
     *              sell_price:22 //销售价格
     *          }]
     *      }
     *   ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           "data" : $data,
     *          "count":22,
     *       }
     *   }
     * }
     */
    public function ordinary(Request $request)
    {
        $all = $request->except('_token');
        if(!$all){
            return $this->response->array(ApiHelper::error('输入内容为空！', 500));
        }
        $cart = InvoiceModel::create($all);

        if($cart){
            return $this->response->array(ApiHelper::success('添加成功！', 500));
        } else {
            return $this->response->array(ApiHelper::error('添加失败！', 500));
        }



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
