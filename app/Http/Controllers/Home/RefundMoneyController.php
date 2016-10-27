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
    public function index(Request $request)
    {
        $this->tab_menu = 'all';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list();
    }
    
    /**
     * 已同意退款列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function consentList(Request $request)
    {
        $this->tab_menu = 'agree';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(1);
    }

    /**
     * 拒绝退款列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rejectList(Request $request)
    {
        $this->tab_menu = 'reject';
        $this->per_page = $request->input('per_page', $this->per_page);
        
        return $this->display_tab_list(2);
    }
    
    protected function display_tab_list($status=0)
    {
        $refunds = RefundMoneyOrderModel::where('status',0)->paginate($this->per_page);
        
        return view('home/refund.refundMoney', [
            'refunds' => $refunds,
            'tab_menu' => $this->tab_menu,
        ]);
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
