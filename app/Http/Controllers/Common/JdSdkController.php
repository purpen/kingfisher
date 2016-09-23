<?php

namespace App\Http\Controllers\Common;

use App\Models\CountersModel;
use App\Models\OrderModel;
use App\Models\RefundMoneyOrderModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

include(dirname(__FILE__) . '/../../../Libraries/JosSdk/JdSdk.php');

class JdSdkController extends Controller
{
    /**
     * 京东 SDK初始化
     * @return \JdClient
     */
    public function JDClient($token)
    {
        $c = new \JdClient();
        $c->appKey = config('jdsdk.app_key');
        $c->appSecret = config('jdsdk.app_secret');
        $c->accessToken = $token;
        $c->serverUrl = config('jdsdk.https_url');
        return $c;
    }
    
    /**
     * 京东订单列表获取接口
     * 
     * @param string $token  授权token
     * @param string $startDate  'Y-m-d H:i:s'
     * @param string $endDate  'Y-m-d H:i:s'
     * @return mixed|\SimpleXMLElement|\stdClass
     */
    public  function pullOrder($token,$startDate,$endDate){
        $c = $this->JDClient($token);
        $req = new \OrderSearchRequest();

        $req->setStartDate( $startDate );
        $req->setEndDate( $endDate ); 
        $req->setOrderState('WAIT_SELLER_STOCK_OUT');
        $req->setPage( 1 );
        $req->setPageSize( 100 );

        $resp = $c->execute($req, $c->accessToken);
        return $resp;
    }

    /**
     * 京东退款单获取接口
     * 
     * @param $token
     * @param $applyTimeStart
     * @param $applyTimeEnd
     * @return mixed|\SimpleXMLElement|\stdClass
     */
    public function pullRefund($token,$applyTimeStart,$applyTimeEnd){
        $c = $this->JDClient($token);
        $req = new \PopAfsSoaRefundapplyQueryPageListRequest();
        $req->setStatus( 0 );
        $req->setApplyTimeStart(  $applyTimeStart );
        $req->setApplyTimeEnd( $applyTimeEnd );
        $req->setPageIndex( 1 );
        $req->setPageSize( 50 );
        $resp = $c->execute($req, $c->accessToken);

        return $resp;
    }



    /**
     * 从京东api拉取退款单列表,同步到本地
     *
     * @param $token
     * @param $storeId
     * @return bool
     */
    public function pullRefundList($token,$storeId)
    {
        $applyTimeEndRefund = 'applyTimeEndRefund' . $storeId;
        if(Cache::has($applyTimeEndRefund)){
            $applyTimeStart = Cache::get($applyTimeEndRefund);
        }else{
            $applyTimeStart = date("Y-m-d H:i:s",time() - 24*3600);
        }
        $applyTimeEnd = date("Y-m-d H:i:s");

        $c = $this->JDClient($token);
        $req = new \PopAfsSoaRefundapplyQueryPageListRequest();
        $req->setStatus( 0 );
        $req->setApplyTimeStart(  $applyTimeStart );
        $req->setApplyTimeEnd( $applyTimeEnd );
        $req->setPageIndex( 1 );
        $req->setPageSize( 50 );
        $resp = $c->execute($req, $c->accessToken);
        $resp = json_decode($resp,true);
        $queryResult = $resp['jingdong_pop_afs_soa_refundapply_queryPageList_response']['queryResult'];
        if(!$queryResult['success']){
            return false;
        }
        
        foreach ($queryResult['result'] as $refund){
            //判断退款单是否已同步，同步则跳过
            $count = RefundMoneyOrderModel::where(['out_refund_money_id' => $refund['refundApplyVo']['id'],'store_id' => $storeId])->count();
            if(0 < $count){
                continue;
            }

            $refund_arr = [];
            $refund_arr['number'] = CountersModel::get_number('DDTK');

            if(!$orderModel = OrderModel::where('outside_target_id',$refund['refundApplyVo']['orderId'])->first()){
                return false;
            }
            $refund_arr['order_id'] = $orderModel->id;
            $refund_arr['out_refund_money_id'] = $refund['refundApplyVo']['id'];
            $refund_arr['amount'] = ($refund['refundApplyVo']['applyRefundSum'])/100;
            $refund_arr['status'] = $refund['refundApplyVo']['status'];
            $refund_arr['apply_time'] = $refund['refundApplyVo']['applyTime'];
            $refund_arr['check_time'] = $refund['refundApplyVo']['checkTime'];
            $refund_arr['buyer_id'] = '';
            $refund_arr['store_id'] = $storeId;

            $refundMoney = new RefundMoneyOrderModel();
            if(!$refundMoney->store($refund_arr)){
                return false;
            }
        }

        Cache::forever($applyTimeEndRefund,$applyTimeEnd);
        return true;
    }
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
