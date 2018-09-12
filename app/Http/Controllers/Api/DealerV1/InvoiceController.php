<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Models\InvoiceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceController extends BaseController
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
        $user_id = $this->auth_user_id;
         if(!$all){
            return $this->response->array(ApiHelper::error('输入内容为空！', 500));
        }

        $all['user_id'] = $user_id;
        $all['reviewer'] = '';
        $all['audit'] = '';
        $all['invoice_value'] = '';
        $all['reason'] = '';
        $all['receiving_type'] = 1;
        $all['application_time'] = '';

        $cart = InvoiceModel::create($all);

        if($cart){
            return $this->response->array(ApiHelper::success('添加成功！', 500));
        } else {
            return $this->response->array(ApiHelper::error('添加失败！', 500));
        }



    }

    /**
     * @param Request $request
     * @return mixed 普通发票编辑和详情
     */

    public function ordinaryList(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 412));
        }
        $ids = InvoiceModel::find($id);
        if (empty($ids)) {
            return $this->response->array(ApiHelper::error('error！', 412));
        }

        return $this->response->array(ApiHelper::success('Success.', 200, $ids));
    }

    /**
     * @param Request $request
     * @return mixed 普通发票修改
     */
    public function ordinaryEdit(Request $request)
    {
        $data = $request->except('_token');
        $receipt =  ReceiptModel::find($data['id']);
        if (empty($receipt)) {
            return $this->response->array(ApiHelper::error('error！', 412));
        }
        if (!$receipt->save()){
            return $this->response->array(ApiHelper::error('更新失败！', 501));
        }
        return $this->response->array(ApiHelper::success('Success.', 200));

    }

    /**
     * @api {post} /DealerApi/invoice/deleted 删除发票
     * @apiVersion 1.0.0
     * @apiName Cart deleted
     * @apiGroup Cart
     *
     * @apiParam {integer} id invoice id :1
     * @apiParam {string} token token
     */

    public function deleted(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->response->array(ApiHelper::error('缺少请求参数！', 412));
        }
        $ids = InvoiceModel::find($id);
        if (empty($ids)) {
            return $this->response->array(ApiHelper::error('error！', 412));
        }
        if(!$ids->delete()){
            return $this->response->array(ApiHelper::error('删除失败！', 500));
        }
        return $this->response->array(ApiHelper::success('success！', 200));


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
