<?php
/**
 * Created by PhpStorm.
 * User: llh
 * Date: 16-9-27
 * Time: 下午2:00
 */

namespace App\Helper;


use App\Http\Requests;

include(dirname(__FILE__) . '/../Libraries/JosSdk/JdSdk.php');

class JdApi
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
     * @param string $token  授权token
     * @param string $startDate  'Y-m-d H:i:s'
     * @param string $endDate  'Y-m-d H:i:s'
     * @return mixed|\SimpleXMLElement|\stdClass
     */
    public  function pullOrder($token,$startDate,$endDate,$page = 1)
    {
        $c = $this->JDClient($token);
        $req = new \OrderSearchRequest();

        $req->setStartDate( $startDate );
        $req->setEndDate( $endDate );
        $req->setOrderState('WAIT_SELLER_STOCK_OUT');
        $req->setPage( $page );
        $req->setPageSize( 100 );

        $resp = $c->execute($req, $c->accessToken);

        return $resp;
    }

    /**
     * 京东订单列表获取接口
     *
     * @param $token
     * @param $startDate
     * @param $endDate
     * @return array|bool
     */
    public function pullOrderList($token,$startDate,$endDate){

        $resp = $this->pullOrder($token,$startDate,$endDate);
        $resp = objectToArray($resp);

        if($resp['code'] != 0){
            return false;
        }
        $order_total = $resp['order_search']['order_total'];
        $count = ($order_total%100) + 1;

        $order_info_list = $resp['order_search']['order_info_list'];

        for ($i = 2;$i <= $count;$i++){
            $resp = $this->pullOrder($token,$startDate,$endDate,$i);
            $resp = objectToArray($resp);
            $order_info_list = array_merge($order_info_list,$resp['order_search']['order_info_list']);
        }
        return $order_info_list;
    }
    
    /**
     * @param $token
     * @param $applyTimeStart
     * @param $applyTimeEnd
     * @return mixed|\SimpleXMLElement|\stdClass
     */
    public function pullRefund($token,$applyTimeStart,$applyTimeEnd,$page=1){
        $c = $this->JDClient($token);
        $req = new \PopAfsSoaRefundapplyQueryPageListRequest();
        $req->setStatus( 0 );
        $req->setApplyTimeStart(  $applyTimeStart );
        $req->setApplyTimeEnd( $applyTimeEnd );
        $req->setPageIndex( $page );
        $req->setPageSize( 50 );
        $resp = $c->execute($req, $c->accessToken);

        return $resp;
    }

    /**
     * 京东退款订单获取接口
     *
     * @param $token
     * @param $applyTimeStart
     * @param $applyTimeEnd
     * @return array|bool
     */
    public function pullRefundList($token,$applyTimeStart,$applyTimeEnd){
        $resp = $this->pullRefund($token, $applyTimeStart, $applyTimeEnd);
        $resp = objectToArray($resp);

        if($resp['code'] != 0){
            return false;
        }
        if(!$resp['queryResult']['success']){
            return false;
        }
        $totalCount = $resp['queryResult']['totalCount'];
        $count = ($totalCount%50) + 1;

        $result = $resp['queryResult']['result'];
        for ($i = 2;$i <= $count;$i++){
            $resp = $this->pullRefund($token, $applyTimeStart, $applyTimeEnd,$i);
            $resp = objectToArray($resp);
            $result = array_merge($result,$resp['queryResult']['result']);
        }

        return $result;
    }

}