<?php
/**
 * 自营商城接口处理类
 *
 * @user llh
 */
namespace App\Helper;

use App\Models\OrderModel;
use Log;

class KdniaoApi
{
    /**
     * 批量获取订单快递单号，电子面单
     */
    public function pullLogisticsNO($order_id)
    {
        $order_info = OrderModel::find($order_id);
        
        // 构造电子面单提交信息
        $eorder = [];
        
        $eorder["ShipperCode"] = $order_info->logistics->kdn_logistics_id;
        
        // 获取对应快递公司电子面单账号，密码
        switch ($eorder["ShipperCode"]) {
            case 'STO':
                $eorder['CustomerName'] = config('express.sto_key');
                $eorder['CustomerPwd'] = config('express.sto_secret');
                $eorder['SendSite'] = config('express.sto_SendSite');
                break;
        }

        // $eorder["OrderCode"] = $order_info->number;
        $eorder["OrderCode"] = $order_info->number;

        //邮费支付方式:1-现付，2-到付，3-月结，4-第三方支付
        $eorder["PayType"] = 1;
        //快递类型：1-标准快件
        $eorder["ExpType"] = 1;
        //是否通知快递员上门揽件：0-通知；1-不通知；不填则默认为0
        $eorder["IsNotice"] = 1;
        
        Log::debug('Kdniao validate express type!!!');
        
        // 发货人信息
        $consignor_info = $order_info->storage->consignor;
        if (!$consignor_info) {
            return false;
        }
        
        Log::debug('Kdniao validate consignor info!!!');
        
        // 收件人信息
        $receiver = [];
        $receiver["Name"] = $order_info->buyer_name;
        $receiver["Mobile"] = $order_info->buyer_phone;
        $receiver["ProvinceName"] = $order_info->buyer_province || '北京';
        $receiver["CityName"] = $order_info->buyer_city || '朝阳区';
        $receiver["ExpAreaName"] = $order_info->buyer_county;
        $receiver["Address"] = $order_info->buyer_address;
//        dd($consignor_info);
        // 发件人信息
        $sender = [];
        $sender["Name"] = $consignor_info->name;
        $sender["Mobile"] = $consignor_info->phone;
        $sender["ProvinceName"] = $consignor_info->province;
        $sender["CityName"] = $consignor_info->district;
        $sender["ExpAreaName"] = "";
        $sender["Address"] = $consignor_info->address;
        
        // 发货的商品
        $commoditys = [];
        $commodity = [
            'GoodsName' => '其他',
            'GoodsCode' => '',
            'Goodsquantity' => $order_info->count,
        ];
        $commoditys[] = $commodity;
        
        $eorder["Sender"] = $sender;
        $eorder["Receiver"] = $receiver;
        $eorder["Commodity"] = $commoditys;
        
        // 是否返回电子打印模板 0:否 1：是
        $eorder['IsReturnPrintTemplate'] = 1;
        
        Log::debug('Kdniao set eorder info!!!');

        // 调用电子面单
        $jsonParam = json_encode($eorder, JSON_UNESCAPED_UNICODE);

        //$jsonParam = JSON($eorder);//兼容php5.2（含）以下

        $jsonResult = $this->submitEOrder($jsonParam);
        
        Log::debug('Kdniao submit result !!!');
        
        // 解析电子面单返回结果
        $result = json_decode($jsonResult, true);
        
        return $result;
    }
    
    /**
     *  post提交数据 
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据 
     * @return url响应返回的html
     */
    public function sendPost($url, $datas)
    {
        $temps = array();	
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);		
        }	
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
    	if (!isset($url_info['port']) || $url_info['port'] == '') {
    		$url_info['port'] = 80;	
    	}
    	//echo $url_info['port'];
        $httpheader  = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        $httpheader .= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
    	$headerFlag = true;
    	while (!feof($fd)) {
    		if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
    			break;
    		}
    	}
        while (!feof($fd)) {
    		$gets.= fread($fd, 128);
        }
        fclose($fd);  
    
        return $gets;
    }
    
    /**
     * Json方式 查询订单物流轨迹
     */
    public function submitEOrder($requestData)
    {
    	$datas = array(
            'EBusinessID' => config('express')['parter_id'],
            'RequestType' => '1007',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        
        $datas['DataSign'] = $this->encrypt($requestData, config('express')['api_key']);
        
    	$result = $this->sendPost(config('express')['request_url'], $datas);	
	
    	// 根据公司业务处理返回的信息......
	
    	return $result;
    }
    
    /**
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    public function encrypt($data, $appkey)
    {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
    
    /************************************************************** 
     * 
     *  使用特定function对数组中所有元素做处理 
     *  @param  string  &$array     要处理的字符串 
     *  @param  string  $function   要执行的函数 
     *  @return boolean $apply_to_keys_also     是否也应用到key上 
     *  @access public 
     * 
     *************************************************************/  
    public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
    {  
        static $recursive_counter = 0;  
        if (++$recursive_counter > 1000) {  
            die('possible deep recursion attack');  
        }
        
        foreach ($array as $key => $value) {  
            if (is_array($value)) {  
                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);  
            } else {  
                $array[$key] = $function($value);  
            }  
   
            if ($apply_to_keys_also && is_string($key)) {  
                $new_key = $function($key);  
                if ($new_key != $key) {  
                    $array[$new_key] = $array[$key];  
                    unset($array[$key]);  
                }  
            }  
        }
        
        $recursive_counter--;  
    }  


    /************************************************************** 
     * 
     *  将数组转换为JSON字符串（兼容中文） 
     *  @param  array   $array      要转换的数组 
     *  @return string      转换得到的json字符串 
     *  @access public 
     * 
     *************************************************************/  
    public function JSON($array) 
    {  
        $this->arrayRecursive($array, 'urlencode', true);  
        $json = json_encode($array);  
        
        return urldecode($json);  
    }
}