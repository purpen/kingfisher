<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Models\AssetsModel;
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
     * @api {get} /DealerApi/invoice 发票管理
     * @apiVersion 1.0.0
     * @apiName Invoice
     * @apiGroup Invoice
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "invoice": [
     *      {
     *      "company_name": 太火鸟1,              // 公司全称
     *      "company_phone": 15112341234,          // 公司电话
     *      "opening_bank": 小关支行,           // 开户行
     *      "bank_account": 879799***989,           // 银行账户
     *      "unit_address": 朝阳区时尚广场b区,           // 单位地址
     *      "duty_paragraph": 7879***8032,           // 税号
     *      "receiving_address": 朝阳时尚广场C区A東,      // 发票收件地址
     *      "receiving_name": 李白,      // 发票收件姓名
     *      "cover_url": 1.img,      // 一般纳税人证明(专票时有url,普通时无此字段)
     *      "receiving_phone": 15112341234,      // 发票收件电话
     *      "receiving_id" :"1",            //  	发票类型0.不开票 1.普通发票 2.专票
     *      }
     *   ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           "invoice" : $invoice,
     *       }
     *   }
     * }
     */
    public function lists(Request $request)
    {
        $user_id = $this->auth_user_id;
//        $per_page = $request->input('per_page',20);
        $where['user_id'] = $user_id; 

        $invoice = InvoiceModel::where($where)
            ->select('duty_paragraph','company_name','receiving_id','id','company_phone','opening_bank','bank_account','unit_address','receiving_address','receiving_name','receiving_phone','receiving_id')
            ->orderBy('id','desc')
            ->get();
       if(!$invoice){
           return $this->response->array(ApiHelper::error('error！', 500));
       }
        foreach($invoice as $k=>$v){
////            $invoice[$k]['province'] =  $v->province->name;
////            $invoice[$k]['city'] =  $v->city->name;
////            $invoice[$k]['county'] =  $v->county->name;
            if($v['receiving_id'] == 2){
                $invoice[$k]['cover_url'] = $v->getFirstImgInvoice();
            }
        }

        return $this->response->array(ApiHelper::success('Success.', 200, $invoice));
    }

    /**
     * @api {post} /DealerApi/invoice/ordinaryAdd 普通和专票发票添加
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
     * @apiParam {string} receiving_id 1:发票类型0.不开票 1.普通发票 2.专票
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
    public function ordinaryAdd(Request $request)
    {
        $data = $request->input('data');
        $prover = $request->input('prover');
        if(!$data){
            return $this->response->array(ApiHelper::error('输入内容为空！', 500));
        }
        $user_id = $this->auth_user_id;


        $data['user_id'] = $user_id;
        $data['reviewer'] = '';
        $data['audit'] = '';
        $data['city_id'] = '';
        $data['province_id'] = '';
        $data['area_id'] = '';
        if($prover){
            $data['prove_id'] = $prover['id'];
        }else {
            $data['prove_id'] = '';
        }
        $data['reason'] = '';
        $data['receiving_type'] = 1;
        $data['application_time'] = '';
//        $data['receiving_id'] = 2;

        $cart = InvoiceModel::insertGetId($data);

        if(!$cart){
            return $this->response->array(ApiHelper::error('添加发票失败！', 500));
        }
        if($prover){
            $assets = AssetsModel::where('random',$prover['random'])->get();
            foreach($assets as $asse){
                $asse->target_id = $cart;
                $asse['type'] = 24;
                $asse->save();
            }

        }

        return $this->response->array(ApiHelper::success('添加成功！', 200));


    }

    /**
     * @api {post} /DealerApi/invoice/ordinaryList 普通发票和专票编辑展示与详情
     * @apiVersion 1.0.0
     * @apiName Invoice ordinaryList
     * @apiGroup Invoice
     * @apiParam {int} id 3:发票id
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     *  {"ids": [
     *      {
     *      "company_name": 太火鸟2,              // 公司全称
     *      "company_phone": 15112341234,          // 公司电话
     *      "opening_bank": 小关支行,           // 开户行
     *      "bank_account": 879799***989,           // 银行账户
     *      "unit_address": 朝阳区时尚广场b区,           // 单位地址
     *      "duty_paragraph": 7879***8032,           // 税号
     *      "receiving_address": 朝阳时尚广场C区A東,      // 发票收件地址
     *      "receiving_name": 李白,      // 发票收件姓名
     *      "cover_url": 1.img,      // 一般纳税人证明(专票时有url,普通时无此字段)
     *      "receiving_phone": 15112341234,      // 发票收件电话
     *      "receiving_id" :"1",            //  	发票类型0.不开票 1.普通发票 2.专票
     *      }
     *   ],
     *      "meta": {
     *          "message": "success.",
     *          "status_code": 200,
     *          'ids':$ids,
     *       }
     * }
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
        if($ids['receiving_id'] == 2 ){
            $ids['cover_url'] = $ids->getFirstImgInvoice();
        }

        return $this->response->array(ApiHelper::success('Success.', 200, $ids));
    }

    /**
     * @api {post} /DealerApi/invoice/ordinaryEdit 普通发票和专票修改
     * @apiVersion 1.0.0
     * @apiName Invoice ordinaryEdit
     * @apiGroup Invoice
     * @apiParam {int} id 3:发票id
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *       }
     */
    public function ordinaryEdit(Request $request)
    {
//        $data = $request->all();
        $all = $request->input('data');
        $assets = $request->input('assets');

        $receipt =  InvoiceModel::find($all['id']);
        if (empty($receipt)) {
            return $this->response->array(ApiHelper::error('error！', 412));
        }
        $receipt['company_phone'] = $all['company_phone'] ?  $all['company_phone'] : '';
        $receipt['company_name'] = $all['company_name']  ?  $all['company_name'] : '';
        $receipt['opening_bank'] = $all['opening_bank']  ?  $all['opening_bank'] : '';
        $receipt['bank_account'] = $all['bank_account']  ?  $all['bank_account'] : '';
        $receipt['unit_address'] = $all['unit_address']  ?  $all['unit_address'] : '';
        $receipt['duty_paragraph'] = $all['duty_paragraph']  ?  $all['duty_paragraph'] : '';
        $receipt['receiving_address'] = $all['receiving_address']  ?  $all['receiving_address'] : '';
        $receipt['receiving_name'] = $all['receiving_name']  ?  $all['receiving_name'] : '';
        $receipt['receiving_phone'] = $all['receiving_phone']  ?  $all['receiving_phone'] : '';
        if($assets){
            $receipt['prove_id'] = $assets['id'];
        } else {
            $receipt['prove_id'] = '';
        }



        if (!$receipt->save()){
            return $this->response->array(ApiHelper::error('更新失败！', 501));
        }

        if(!empty($assets['random'])){
                $asse = AssetsModel::where('random',$assets['random'])->get();
                foreach ($asse as $asset){
                    $asset->target_id = $receipt->id;
                    $asset['type'] = 24;
                     $asset->save();
                }
        }
        return $this->response->array(ApiHelper::success('Success.', 200));

    }

    /**
     * @api {post} /DealerApi/invoice/deleted 删除发票
     * @apiVersion 1.0.0
     * @apiName Invoice deleted
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
