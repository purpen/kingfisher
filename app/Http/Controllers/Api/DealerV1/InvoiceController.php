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

    public function lists(Request $request)
    {
        $user_id = $this->auth_user_id;
        $per_page = $request->input('per_page');
        $where['user_id'] = $user_id;
        $where['receiving_type'] = 1;

        $invoice = InvoiceModel::where($where)->select('duty_paragraph','company_name','receiving_id')->paginate($per_page);

        return $this->response->array(ApiHelper::success('Success.', 200, $invoice));
    }

    /**
     * @api {post} /DealerApi/invoice/ordinaryAdd 普通发票添加
     * @apiVersion 1.0.0
     * @apiName Invoice ordinaryAdd
     * @apiGroup Invoice
     * @apiParam {char} province_id 3:省份id
     * @apiParam {char} city_id 3:市id
     * @apiParam {char} area_id 3:县\区id
     * @apiParam {string} company_name 太火鸟科技:公司全称
     * @apiParam {string} company_phone 15112341234:公司电话
     * @apiParam {string} opening_bank 小关支行:开户行
     * @apiParam {string} bank_account 5361*********:银行账户
     * @apiParam {string} unit_address 时尚广场:单位地址
     * @apiParam {string} duty_paragraph 998766331:税号
     * @apiParam {string} receiving_address 时尚广场xx楼:发票收件地址
     * @apiParam {string} receiving_name 李白:收件人姓名
     * @apiParam {string} receiving_phone 15311112222:收件人电话
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     *      "meta": {
     *          "message": "添加成功.",
     *          "status_code": 200,
     *       }
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
        $all['reason'] = '';
        $all['receiving_type'] = 1;
        $all['application_time'] = '';
        $all['receiving_id'] = 2;

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
