<?php

namespace App\Http\Controllers\Home;

/**
 * 订单退款处理类
 * 
 * @author llh
 * @time 2016.9.19
 */
use App\Models\RefundMoneyOrderModel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefundMoneyController extends Controller
{
    /**
     * 退款页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refunds = RefundMoneyOrderModel::where('status',0)->paginate(20);
        return view('home/refund.refundMoney',['refunds' => $refunds]);
    }

    /**
     * 以同意退款页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function consentList()
    {
        $refunds = RefundMoneyOrderModel::where('status',1)->paginate(20);
        return view('home/refund.consentRefundMoney',['refunds' => $refunds]);
    }

    /**
     * 以拒绝退款页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rejectList()
    {
        $refunds = RefundMoneyOrderModel::where('status',2)->paginate(20);
        return view('home/refund.rejectRefundMoney',['refunds' => $refunds]);
    }

    /**
     * 同意退款操作
     *
     * @param Request $request
     * @return string
     */
    public function ajaxConsentRefund(Request $request)
    {
        $refund_id = (int)$request->input('refund_id');
        $refundModel = new RefundMoneyOrderModel();
        if(!$refundModel->checkRefund($refund_id,1)){
            return ajax_json(0,'error');
        }else{
            return ajax_json(1,'ok');
        }
    }

    /**
     * 拒绝退款
     *
     * @param Request $request
     * @return string
     */
    public function ajaxRejectRefund(Request $request)
    {
        $refund_id = (int)$request->input('refund_id');
        $refundModel = new RefundMoneyOrderModel();
        if(!$refundModel->checkRefund($refund_id,2)){
            return ajax_json(0,'error');
        }else{
            return ajax_json(1,'ok');
        }
    }
}
