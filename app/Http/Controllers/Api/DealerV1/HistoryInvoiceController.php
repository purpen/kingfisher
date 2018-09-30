<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Models\HistoryInvoiceModel;
use App\Models\InvoiceModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use App\Http\ApiHelper;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoryInvoiceController extends BaseController
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
     * @api {get} /DealerApi/history/lists  开票记录列表
     * @apiVersion 1.0.0
     * @apiName HistoryInvoice lists
     * @apiGroup HistoryInvoice
     * @apiParam {int} receiving_type 1:开发票的状态 1.未开票 2.审核中 3.已开票. 4.拒绝 5.已过期(为空查询所有)
     * @apiParam {char} number DD2018042600002:搜索时所需参数
     * @apiParam {string} per_page 1:一页多少条数据
     * @apiParam {string} page 1:页码
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                      // 发票历史表id
     *      receiving_id :"1",            //发票类型 发票类型0.不开票 1.普通发票 2.专票
     *      receving_type  :1,            //开发票的状态 1.未开票 2.审核中 3.已开票. 4.拒绝 5.已过期
     *      order_id    "111",            //订单id
     *      number   ：DD2018042600002,   //订单编号
     *      "total_money": 500.00,           // 订单金额
     *      "remaining":178,               // 未开票倒计时(天数)
     *      }
     *   ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           "data" : $data,
     *       }
     *   }
     * }
     */
    public function lists(Request $request)
    {
        $user_id = $this->auth_user_id;
        $number = $request->input('number');
        $per_page = $request->input('per_page',20);
        $receiving_type = $request->input('receiving_type');

        $wherein['order.user_id'] = $user_id;
//        $wherein['order.id'] = 1659;
        $where = [];
        if($receiving_type == 1){
            $where = [2,3,4];
        } elseif($receiving_type == 2){
            $notfound = 111;
        } elseif($receiving_type == 3){
            $where = [5];
        }elseif($receiving_type == 4){
            $receiving = 999;
        }
        $data = [];
        if(!empty($notfound)){
            $historyInvoice = HistoryInvoiceModel::select('order_id')->get();
            //二维数组改为一维数组
            foreach($historyInvoice as $key=>$value){
                $ids[] = $value['order_id'];
            }
            //去重
            $heavy = array_unique($ids);
            $heavy = implode(',',$heavy);
//            $data = OrderModel::
//                whereNotNull(DB::raw("(status IN (8,10,20) and  payment_type = 6 and user_id = 1) OR (status IN (5, 6, 7, 10, 20) and payment_type IN (1, 4) and user_id = 1)"))
//                ->whereNotIn('id',$heavy)
//                ->select('id as order_id','number','total_money','order_start_time')
//                ->where('number','like','%'.$number.'%')
//                ->orderBy('order.id','desc')
//                ->paginate($per_page);
            $data = OrderModel::whereRaw(DB::raw("`id` not in (".$heavy.") and ((`status` IN (8,10,20) and  `payment_type` = 6 and `user_id` = ".$user_id.") OR (`status` IN (5, 6, 7, 10, 20) and `payment_type` IN (1, 4) and `user_id` = ".$user_id."))"))
                ->select('id as order_id','number','total_money','order_start_time','status','payment_type')
                ->where('number','like','%'.$number.'%')
                ->orderBy('order.id','desc')
                ->paginate($per_page);
        }

        if ($where){
//            $data = OrderModel::select('history_invoice.receiving_id','history_invoice.receiving_type','order.id as order_id','history_invoice.id','order.number','order.total_money','order.order_start_time')
//                ->leftJoin('history_invoice', 'order.id', '=', 'history_invoice.order_id')
//                ->where('order.number','like','%'.$number.'%')
//                ->whereIn('order.status', [8, 10, 20])
//                ->where($wherein)
//                ->orderBy('order.id','desc')
//                ->whereIn('receiving_type',$where)
//                ->paginate($per_page);

            $data = OrderModel::whereRaw(DB::raw("((`status` IN (8,10,20) and  `payment_type` = 6) OR (`status` IN (5, 6, 7, 10, 20) and `payment_type` IN (1, 4)))"))
                ->select('order.user_id','history_invoice.receiving_id','history_invoice.receiving_type','order.id as order_id','history_invoice.id','order.number','order.total_money','order.order_start_time')
                ->leftJoin('history_invoice', 'order.id', '=', 'history_invoice.order_id')
                ->where('order.number','like','%'.$number.'%')
                ->where($wherein)
                ->orderBy('order.id','desc')
                ->whereIn('receiving_type',$where)
                ->paginate($per_page);
        }elseif(!empty($receiving)){
//            $data = OrderModel::select('history_invoice.receiving_id','history_invoice.receiving_type','order.id as order_id','history_invoice.id','order.number','order.total_money','order.order_start_time')
//                ->leftJoin('history_invoice', 'order.id', '=', 'history_invoice.order_id')
//                ->where('order.number','like','%'.$number.'%')
//                ->whereIn('order.status', [8, 10, 20])
//                ->where($wherein)
//                ->orderBy('order.id','desc')
//                ->paginate($per_page);
            $data = OrderModel::whereRaw(DB::raw("((`status` IN (8,10,20) and  `payment_type` = 6) OR (`status` IN (5, 6, 7, 10, 20) and `payment_type` IN (1, 4)))"))
                ->select('history_invoice.receiving_id','history_invoice.receiving_type','order.id as order_id','history_invoice.id','order.number','order.total_money','order.order_start_time')
                ->leftJoin('history_invoice', 'order.id', '=', 'history_invoice.order_id')
                ->where('order.number','like','%'.$number.'%')
//                ->whereIn('order.status', [8, 10, 20])
                ->where($wherein)
                ->orderBy('order.id','desc')
                ->paginate($per_page);
        }



        foreach($data as $k=>$v){
            $data[$k]['start'] = strtotime($v['order_start_time']);

            $v->time  =  date('Y-m-d H:i:s',$data[$k]['start']+180*24*60*60);
            $v->time =strtotime($v->time);

            if(!in_array($v['receiving_type'],[1,2,3,4,5])){
                if($v->time > time()){
                    $timediff = $v->time -  time();
                    $data[$k]['days']  = intval($timediff/86400);
                    $data[$k]['hours'] = 0;
                    $remain = $timediff%86400;
                    $hours = intval($remain/3600);
                    if($hours){
                        $data[$k]['hours']  = $hours;
                    }
                    $data[$k]['remaining'] = ceil($data[$k]['days'].'.'.$data[$k]['hours']);

                } else{
                    //如果时间到了则为已过期
                    $history = HistoryInvoiceModel::find($v->id);
                    if($history){
                        $history->receiving_type  = 5;
                        $history->receiving_id  = 0;
                        $history->user_id = $user_id;
                       $history->order_id = $v->order_id;

                        $invoice = $history->save();
                    }else{
                        $historyIn = new HistoryInvoiceModel();
                        $hist = [];
                        $hist['receiving_type'] = 5;
                        $hist['receiving_id'] = 0;
                        $hist['user_id'] = $user_id;
                        $hist['order_id'] = $v->order_id;

                        $invoice = $historyIn->create($hist);
                    }

                    if(!$invoice){
                        return $this->response->array(ApiHelper::error('error', 500));
                    }
                }
            }
        }

        return $this->response->array(ApiHelper::success('Success.', 200, $data));


    }

    /**
     * @api {get} /DealerApi/history/historyTo 查看专用增值税发票详情-弹框页面
     * @apiVersion 1.0.0
     * @apiName HistoryInvoice historyTo
     * @apiGroup HistoryInvoice
      * @apiParam {int} id 1:发票历史id
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     * {
     * "data": [
     *      {
     *      "id": 2,                      // 发票历史表id
     *      "number": DD2018042600003,    // 订单号
     *      total_money :"500",            //总金额
     *      receiving_id	  :1,            //发票类型 发票类型0.不开票 1.普通发票 2.专票
     *      company_name    "111",            //名称
     *      duty_paragraph   ：84091-1,   //税号
     *      "unit_address": 时尚广场,           // 单位地址
     *      "company_phone":15112341234,               // 电话号码
     *      "opening_bank":小关支行,               // 开户银行
     *      "receiving_name":李白,               // 收件人姓名
     *      "receiving_phone":15112341234,               // 收件人电话
     *      "receiving_address":时尚广场,               // 收件人地址
     *      }
     *   ],
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *           "history" : $history,
     *       }
     *   }
     * }
     */
    public function historyTo(Request $request)
    {
        $user_id = $this->auth_user_id;
        $id = $request->input('id');
        if(!$id){
            return $this->response->array(ApiHelper::error('参数错误', 500));
        }
        $history = HistoryInvoiceModel::find($id);
        if(!$history){
            return $this->response->array(ApiHelper::error('无此数据', 500));
        }

        $history['number'] = $history->order->number;
//        $history['company_phone'] = $history->historyInvoice->company_phone;
//        $history['opening_bank'] = $history->historyInvoice->opening_bank;
//        $history['bank_account'] = $history->historyInvoice->bank_account;
//        $history['receiving_address'] = $history->historyInvoice->receiving_address;
//        $history['receiving_name'] = $history->historyInvoice->receiving_name;
//        $history['receiving_phone'] = $history->historyInvoice->receiving_phone;
        return $this->response->array(ApiHelper::success('Success.', 200, $history));

    }

    /**
     * @api {post} /DealerApi/history/application 开票记录中申请开票
     * @apiVersion 1.0.0
     * @apiName HistoryInvoice application
     * @apiGroup HistoryInvoice
     * @apiParam {int} invoice_id 1:发票表id
     * @apiParam {int} order_id 1:订单id
     * @apiParam {int} invoicevalue 321:订单金额
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
     *      "meta": {
     *          "message": "Success.",
     *          "status_code": 200,
     *       }
     *   }
     * }
     */
    public function application(Request $request)
    {
        $user_id = $this->auth_user_id;
        $invoice_id = $request->input('invoice_id');
        $order_id = $request->input('order_id');
        $invoicevalue = $request->input('invoicevalue');
        if(!$invoice_id || !$order_id || !$invoicevalue){
            return $this->response->array(ApiHelper::error('参数错误', 500));
        }
        $invoice = InvoiceModel::find($invoice_id);
        if (!$invoice){
            return $this->response->array(ApiHelper::error('数据异常', 412));
        }
        $historyInvoice = new HistoryInvoiceModel();
        $time = date('Y-m-d H:i:s',time());
        $data['user_id'] = $user_id;
        $data['order_id'] = $order_id;
        $data['invoice_id'] = $invoice_id;
        $data['receiving_id'] = $invoice['receiving_id'];
        $data['company_name'] = $invoice['company_name'];
        $data['invoice_value'] = $invoicevalue;
        $data['duty_paragraph'] = $invoice['duty_paragraph'];
        $data['company_phone'] = $invoice['company_phone'];
        $data['opening_bank'] = $invoice['opening_bank'];
        $data['bank_account'] = $invoice['bank_account'];
        $data['receiving_address'] = $invoice['receiving_address'];
        $data['receiving_name'] = $invoice['receiving_name'];
        $data['receiving_phone'] = $invoice['receiving_phone'];
        $data['unit_address'] = $invoice['unit_address'];
        $data['prove_id'] = $invoice['prove_id'];
        $data['receiving_type'] = 2;
        $data['application_time'] = $time;

        $res = $historyInvoice::create($data);
        if($res){
            return $this->response->array(ApiHelper::success('申请成功', 200));
        } else {
            return $this->response->array(ApiHelper::error('申请失败', 500));
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
