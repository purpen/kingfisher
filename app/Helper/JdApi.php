<?php
/**
 * Created by PhpStorm.
 * User: llh
 * Date: 16-9-27
 * Time: 下午2:00
 */

namespace App\Helper;


use App\Http\Requests;
use App\Models\LogisticsModel;
use App\Models\OrderModel;
use App\Models\RefundMoneyOrderModel;
use App\Models\StoreModel;
use Illuminate\Support\Facades\Auth;

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
    protected function pullOrder($token,$startDate,$endDate,$page = 1)
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
    public function pullOrderList($token,$startDate,$endDate)
    {

        $resp = $this->pullOrder($token,$startDate,$endDate);
        $resp = objectToArray($resp);
        if($resp['code'] != 0){
            return false;
        }

        $order_total = $resp['order_search']['order_total'];
        $count = intval($order_total/100) + 1;

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
    protected function pullRefund($token,$applyTimeStart,$applyTimeEnd,$page=1)
    {
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
    public function pullRefundList($token,$applyTimeStart,$applyTimeEnd)
    {
        $resp = $this->pullRefund($token, $applyTimeStart, $applyTimeEnd);
        $resp = objectToArray($resp);

        if($resp['code'] != 0){
            return false;
        }
        if(!$resp['queryResult']['success']){
            return false;
        }
        $totalCount = $resp['queryResult']['totalCount'];
        $count = intval($totalCount/50) + 1;

        $result = $resp['queryResult']['result'];
        for ($i = 2;$i <= $count;$i++){
            $resp = $this->pullRefund($token, $applyTimeStart, $applyTimeEnd,$i);
            $resp = objectToArray($resp);
            $result = array_merge($result,$resp['queryResult']['result']);
        }

        return $result;
    }

    /**
     * 京东订单出库接口
     *
     * @param $order_id
     * @param $logistics_id 快递编号
     * @param $waybill
     * @return bool
     */
    public function outStorage($order_id,$logistics_id,$waybill)
    {
        if(empty($logistics_id) || empty($waybill)){
            return false;
        }
        //通过订单号查询请求token
        if(!$orderModel = OrderModel::find($order_id)){
            return false;
        }

        //判断订单是否拆单
        if($orderModel->split_status == 0){
            $logistics_id = [$logistics_id];
            $waybill = [$waybill];
        }else{
            $orders = OrderModel::where(['outside_target_id' => $orderModel->outside_target_id,'store_id' => $orderModel->store_id])->get();
            //判断子订单是否都已发货
            foreach ($orders as $v){
                if($v->status < 10){
                    return true;
                }
                $logistics_id[] = $v->express_id;
                $waybill[] = $v->express_no;
            }
        }

        $token = $orderModel->store->access_token;
        $c = $this->JDClient($token);
        $req = new \OrderSopOutstorageRequest();

        //将物流ID转换为京东平台物流代码
        $logistics_id_arr = [];
        foreach ($logistics_id as $v){
            $logistics_id_arr[] = LogisticsModel::find($v)->jd_logistics_id;
        }

        $logistics_id = explode('|',$logistics_id_arr);
        $waybill = explode('|',$waybill);
        $outside_target_id = $orderModel->outside_target_id;

        $req->setLogisticsId( $logistics_id );
        $req->setWaybill( $waybill );
        $req->setOrderId( $outside_target_id );
        $resp = $c->execute($req, $c->accessToken);
        if($resp->code != 0){
            return false;
        }
        return true;
    }

    /**
     * 京东退款订单处理接口
     *
     * @param $refund_id
     * @param $status
     * @return bool
     */
    public function replyRefund($refund_id,$status)
    {
        if(!$refundModel = RefundMoneyOrderModel::find($refund_id)){
            return false;
        }
        $out_refund_money_id = $refundModel->out_refund_money_id;
        $checkUser = Auth::user()->realname;
        $token = $refundModel->store->access_token;


        $c = $this->JDClient($token);
        $req = new \PopAfsSoaRefundapplyReplyRefundRequest();

        $req->setStatus( $status );
        $req->setId( $out_refund_money_id );
        $req->setCheckUserName( $checkUser );
        switch ($status){
            case 1:
                $req->setRemark( "同意退款" );
                $req->setOutWareStatus( 2 );
                break;
            case 2:
                $req->setRemark( "拒绝退款" );
                $req->setRejectType( 1 );
                $req->setOutWareStatus( 1 );
                break;
        }
        $resp = $c->execute($req, $c->accessToken);
        return $resp->replyResult->success;
    }


    /**
     * 获取京东平台订单的状态
     *
     * @param $order_id
     * @return bool|mixed|\SimpleXMLElement|\stdClass
     */
    public function pullOrderStatus($order_id)
    {
        if(!$orderModel = OrderModel::find($order_id)){
            return false;
        }
        $token = $orderModel->store->access_token;
        $c = $this->JDClient($token);

        $req = new \OrderGetRequest();

        $req->setOrderId( $orderModel->outside_target_id );
        $req->setOptionalFields( "order_state" );

        $resp = $c->execute($req, $c->accessToken);
        return $resp;
    }

    /**
     * 京东平台同步商品SKU 库存接口
     */
    public function skuStockUpdate($token,$sku_number,$quantity)
    {
        $c = $this->JDClient($token);

        $req = new \SkuStockUpdateRequest();

        $req->setOuterId( $sku_number );
        $req->setQuantity( $quantity );

        $resp = $c->execute($req, $c->accessToken);

        if($resp->code !== 0){
            return false;
        }
        return true;
    }

    /**
     * 京东平台所有店铺商品SKU库存同步
     * @param string $number sku编码
     * @param integer $quantity 可卖库存
     */
    public function shopSkuStockUpdate($number,$quantity)
    {
        $store_model = new StoreModel();
        $tokens = $store_model->getToken(2);

        foreach ($tokens as $token){
            $this->skuStockUpdate($token,$number,$quantity);
        }
    }

    /**
     * 获取京东店铺售后单
     *
     * @param $refund
     * @return mixed|\SimpleXMLElement|\stdClass
     */
    public function getRefundShow($refund)
    {
        //获取对应商店token
        $token = $refund->store->access_token;
        $c = $this->JDClient($token);

        $req = new \PopAfsSoaRefundapplyQueryByIdRequest();

        $req->setId( $refund->out_refund_money_id );

        $resp = $c->execute($req, $c->accessToken);
        return $resp;
    }


    /*//京东店铺添加物流公司信息
    public function addLogistics($token,$logistics_id,$name,$sort,$remark)
    {
        $c = $this->JDClient($token);

        $req = new \AddVenderDeliveryCompanyRequest();

        $req->setDeliveryCompanyId( $logistics_id );
        $req->setName( $name ); 
        $req->setSort( $sort ); 
        $req->setRemark( $remark );

        $resp = $c->execute($req, $c->accessToken);
        if($resp->code == 0){
            return true;
        }else{
            return false;
        }
    }
    
    //京东平台所有店铺添加物流信息
    public function addLogisticList($logistics_id,$name,$sort,$remark)
    {
        $stores = StoreModel::where('platform',2)->get();
        foreach($stores as $store){
            $token = $store->access_token;
            $this->addLogistics($token, $logistics_id, $name, $sort, $remark);
        }
    }*/

    /**
     *向京东平台添加商品信息
     */
    /*public function addProduct($token,$data)
    {
        $c = $this->JDClient($token);

        $req = new \WareAddRequest();

        $req->setTradeNo( "jingdong" );
        $req->setWareLocation( "jingdong" );
        $req->setCid( "jingdong" );
        $req->setShopCategory( "jingdong" );
        $req->setTitle( "jingdong" );
        $req->setUpcCode( "jingdong" );
        $req->setOptionType( "jingdong" );
        $req->setItemNum( "jingdong" );
        $req->setStockNum( "jingdong" );
        $req->setProducter( "jingdong" );
        $req->setWrap( "jingdong" );
        $req->setLength( "jingdong" );
        $req->setWide( "jingdong" );
        $req->setHigh( "jingdong" );
        $req->setWeight( "jingdong" );
        $req->setCostPrice( "jingdong" );
        $req->setMarketPrice( "jingdong" );
        $req->setJdPrice( "jingdong" );
        $req->setNotes( "jingdong" );
        $req->setWareImage( "txt" );
        $req->setPackListing( "jingdong" );
        $req->setService( "jingdong" );
        $req->setSkuProperties( "jingdong" );
        $req->setAttributes( "jingdong" );
        $req->setSkuPrices( "jingdong" );
        $req->setSkuStocks( "jingdong" );
        $req->setPropertyAlias( "jingdong" );
        $req->setOuterId( "jingdong" );
        $req->setIsPayFirst( "jingdong" );
        $req->setIsCanVat( "jingdong" );
        $req->setIsImported( "jingdong" );
        $req->setIsHealthProduct( "jingdong" );
        $req->setIsShelfLife( "jingdong" );
        $req->setShelfLifeDays( "jingdong" );
        $req->setIsSerialNo( "jingdong" );
        $req->setIsAppliancesCard( "jingdong" );
        $req->setIsSpecialWet( "jingdong" );
        $req->setWareBigSmallModel( "jingdong" );
        $req->setWarePackType( "jingdong" );
        $req->setInputPids( "jingdong" );
        $req->setInputStrs( "jingdong" );
        $req->setHasCheckCode( "jingdong" );
        $req->setAdContent( "jingdong" );
        $req->setListTime( "jingdong" );

        $resp = $c->execute($req, $c->accessToken);
    }*/
}