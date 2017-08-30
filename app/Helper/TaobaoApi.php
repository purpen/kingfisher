<?php
/**
 * 淘宝api接口类
 */
namespace App\Helper;

use App\Models\OrderModel;
use Illuminate\Support\Facades\Log;

include(dirname(__FILE__) . '/../Libraries/TaoBaoSdk/TopSdk.php');

class TaobaoApi
{
    /**
     * 淘宝api初始
     * @return \TopClient
     */
    public function tbClient()
    {
        $c = new \TopClient;
        $c->appkey = config('taobao.appKey');
        $c->secretKey = config('taobao.secretKey');
        //请求地址
        $c->gatewayUrl = config('taobao.gatewayUrl');
        //数据格式
        $c->format = config('taobao.format');
        return $c;
    }

    /**
     * 获取电子面单
     * 
     * @param $order_id
     * @return mixed|\ResultSet|\SimpleXMLElement
     */
    public function getWaybill1($order_id){
        $order_info = OrderModel::find($order_id);
        
        $c = $this->tbClient();
        $req = new \WlbWaybillIGetRequest;
        $waybill_apply_new_request = new \WaybillApplyNewRequest;
        
        //物流服务商编码
        $waybill_apply_new_request->cp_code = $order_info->logistics->kdn_logistics_id;
        
        //发货人信息
        // 发货人信息
        $consignor_info = $order_info->storage->consignor;
        if (!$consignor_info) {
            return false;
        }
        $shipping_address = new \WaybillAddress;
        $shipping_address->province = $consignor_info->province->name;
        $shipping_address->address_detail = $consignor_info->address;
        $shipping_address->city = $consignor_info->district->name;
        $waybill_apply_new_request->shipping_address = $shipping_address;

        /**
         * 订单信息
         */
        $trade_order_info_cols = new \TradeOrderInfo;
        $trade_order_info_cols->consignee_name = $order_info->buyer_name;
        $trade_order_info_cols->order_channels_type = 'OTHERS';
        $trade_order_info_cols->trade_order_list = $order_info->number;
        $trade_order_info_cols->consignee_phone = $order_info->buyer_phone;
        
        //收货人地址
        $consignee_address = new \WaybillAddress;
        $consignee_address->province = $order_info->buyer_province;
        $consignee_address->address_detail = $order_info->buyer_address;
        $consignee_address->city = $order_info->buyer_city;
        $trade_order_info_cols->consignee_address = $consignee_address;
        
        $trade_order_info_cols->send_phone = $consignor_info->phone;
//        $trade_order_info_cols->weight="123";
        $trade_order_info_cols->send_name = $consignor_info->name;
        $package_items = new \PackageItem;
        $package_items->item_name ="商品";
        $package_items->count = $order_info->count;
        $trade_order_info_cols->package_items = $package_items;
        /*$logistics_service_list = new \LogisticsService;
        $logistics_service_list->service_value4_json="{ \"value\": \"100.00\",\"currency\": \"CNY\",\"ensure_type\": \"0\"}";
        $logistics_service_list->service_code="SVC-DELIVERY-ENV";
        $trade_order_info_cols->LogisticsServiceList = $logistics_service_list;*/
        $trade_order_info_cols->product_type="STANDARD_EXPRESS";
        $trade_order_info_cols->real_user_id="13123";
        /*$trade_order_info_cols->volume="123";
        $trade_order_info_cols->package_id="E12321321-1234567";*/
        $waybill_apply_new_request->trade_order_info_cols = $trade_order_info_cols;
        $req->setWaybillApplyNewRequest(json_encode($waybill_apply_new_request));

        $sessionKey = $order_info->store->access_token;
        $resp = $c->execute($req, $sessionKey);
        return $resp;
    }

    /**
     * 云打印获取电子面单
     *
     * @param $order_id
     * @return mixed|\ResultSet|\SimpleXMLElement
     */
    public function getWaybill($order_id)
    {
        $order_model = OrderModel::find($order_id);

        //服务商代码
        $cp_code = $order_model->logistics->kdn_logistics_id;

        //拥有电子面单授权的店铺token
//        $sessionKey = $order_model->store->access_token;
        $sessionKey = config('taobao.cp_sessionKey');

        //店铺平台ID
        $out_store_id = $order_model->store->target_id;

        $consignor_info = $order_model->storage->consignor;
        if (!$consignor_info) {
            Log::error('获取发货人信息出错');
            return false;
        }

        $c  = $this->tbClient();
        $req = new \CainiaoWaybillIiGetRequest;
        $param_waybill_cloud_print_apply_new_request = new \WaybillCloudPrintApplyNewRequest;
        $param_waybill_cloud_print_apply_new_request->cp_code = $cp_code;
//        $param_waybill_cloud_print_apply_new_request->product_code="COD";

        $sender = new \UserInfoDto;
        $address = new \AddressDto;
        $address->city = $consignor_info->city;
        $address->detail = $consignor_info->address;
        $address->district=$consignor_info->district;
        $address->province = $consignor_info->province;
        $sender->address = $address;
        $sender->mobile = $consignor_info->phone;
        $sender->name = $consignor_info->name;
//        dd($sender);
        $param_waybill_cloud_print_apply_new_request->sender = $sender;

        $trade_order_info_dtos = new \TradeOrderInfoDto;
//        $trade_order_info_dtos->logistics_services="{     \"SVC-COD\": {         \"value\": \"100\"     } }";
        $trade_order_info_dtos->object_id = $order_id;
        $order_info = new \OrderInfoDto;
        $order_info->order_channels_type="OTHERS";
        $order_info->trade_order_list = $order_model->number;
        $trade_order_info_dtos->order_info = $order_info;
        $package_info = new \PackageInfoDto;
        $package_info->id = "1";
        $items = new \Item;
        $items->count = $order_model->count;
        $items->name = '其他';
        $package_info->items = $items;
        /*$package_info->volume="1";
        $package_info->weight="1";*/
        $trade_order_info_dtos->package_info = $package_info;
        $recipient = new \UserInfoDto;
        $address = new \AddressDto;

        $address->city = $order_model->buyer_city;
        $address->detail = $order_model->buyer_address;
        $address->district = $order_model->buyer_county;
        $address->province = $order_model->buyer_province;
        $address->town = $order_model->buyer_township;
        $recipient->address = $address;
        $recipient->mobile = $order_model->buyer_phone;
        $recipient->name= $order_model->buyer_name;
        $recipient->phone=$order_model->buyer_tel;
        $trade_order_info_dtos->recipient = $recipient;
        $trade_order_info_dtos->template_url = $this->printTemplateUrl($cp_code,$sessionKey);
        $trade_order_info_dtos->user_id = $out_store_id;
        $param_waybill_cloud_print_apply_new_request->trade_order_info_dtos = $trade_order_info_dtos;
        $req->setParamWaybillCloudPrintApplyNewRequest(json_encode($param_waybill_cloud_print_apply_new_request));
        $resp = $c->execute($req, $sessionKey);
        return [$resp,$cp_code];
    }

    /**
     * 获取发货地&CP开通状态&账户的使用情况
     */
    public function waybillIiSearch($cpCode,$sessionKey)
    {
        $c = $this->tbClient();
        $req = new \CainiaoWaybillIiSearchRequest;
        $req->setCpCode($cpCode);
        $resp = $c->execute($req, $sessionKey);
        return $resp;
    }

    /**
     * 获取所有的菜鸟标准电子面单模板
     *
     * @param $sessionKey
     * @return mixed|\ResultSet|\SimpleXMLElement
     */
    public function printTemplatesGet($sessionKey)
    {
        $c = $this->tbClient();
        $req = new \CainiaoCloudprintStdtemplatesGetRequest;
        $resp = $c->execute($req, $sessionKey);
        Log::error((string)$resp);
        return $resp;
    }

    /**
     * 服务商对应的标准电子面单模板
     */
    public function printTemplateUrl ($cp_code, $sessionKey)
    {
        $templateAll = $this->printTemplatesGet($sessionKey)->result->datas->standard_template_result;
        foreach ($templateAll as $template){
            if($template->cp_code == $cp_code){
                $templateUrl = $template->standard_templates->standard_template_do[0]->standard_template_url;
                return $templateUrl;
            }
        }
    }

}