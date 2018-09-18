<?php

namespace App\Http\Controllers\Api\DealerV1;

use App\Models\HistoryInvoiceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HistoryInvoiceController extends Controller
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

        $wherein['history_invoice.user_id'] = $user_id;
//        $wherein['history_invoice.difference'] = 0;
        $where = [];
        if($receiving_type == 1){
            $where = [1];
        } elseif($receiving_type == 2){
            $where = [2,3,4];
        } elseif($receiving_type == 3){
            $where = [5];
        }else {
            $where = [1,2,3,4,5];
        }

        $data = HistoryInvoiceModel::select('history_invoice.receiving_id','history_invoice.receiving_type','o.id as order_id','history_invoice.id','o.number','o.total_money','o.order_start_time')
            ->leftJoin('order as o', 'o.id', '=', 'history_invoice.order_id')
            ->where('o.number','like','%'.$number.'%')
            ->where($wherein)
            ->whereIn('receiving_type',$where)
            ->paginate($per_page);

        foreach($data as $k=>$v){
            $data[$k]['start'] = strtotime($v['order_start_time']);

            $v->time  =  date('Y-m-d H:i:s',$data[$k]['start']+180*24*60*60);
            $v->time =strtotime($v->time);

            if($v['receiving_type'] == 1){
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
                    $history = HistoryInvoiceModel::find($v->id);
                    $history->receiving_type = 5;
                    $invoice = $history->save();
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

        $history['total_money'] = $history->order->total_money;
        $history['number'] = $history->order->number;
        return $this->response->array(ApiHelper::success('Success.', 200, $history));

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
