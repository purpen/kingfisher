<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class KdniaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //构造电子面单提交信息
        $eorder = [];
        $eorder["ShipperCode"] = "SF";
        $eorder["OrderCode"] = "PM201604062341";
        $eorder["PayType"] = 1;
        $eorder["ExpType"] = 1;

        $sender = [];
        $sender["Name"] = "李先生";
        $sender["Mobile"] = "18888888888";
        $sender["ProvinceName"] = "李先生";
        $sender["CityName"] = "深圳市";
        $sender["ExpAreaName"] = "福田区";
        $sender["Address"] = "赛格广场5401AB";

        $receiver = [];
        $receiver["Name"] = "李先生";
        $receiver["Mobile"] = "18888888888";
        $receiver["ProvinceName"] = "李先生";
        $receiver["CityName"] = "深圳市";
        $receiver["ExpAreaName"] = "福田区";
        $receiver["Address"] = "赛格广场5401AB";

        $commodityOne = [];
        $commodityOne["GoodsName"] = "其他";
        $commodity = [];
        $commodity[] = $commodityOne;

        $eorder["Sender"] = $sender;
        $eorder["Receiver"] = $receiver;
        $eorder["Commodity"] = $commodity;
        
        //调用电子面单
        $jsonParam = json_encode($eorder, JSON_UNESCAPED_UNICODE);

        //$jsonParam = JSON($eorder);//兼容php5.2（含）以下

        $jsonResult = $this->submitEOrder($jsonParam);

        //解析电子面单返回结果
        $result = json_decode($jsonResult, true);  
        
        return view('express', ['result' => $result]);
    }
    
    /**
     * 扫描器
     */
    public function scanner()
    {
        return view('scanner');
    }
    
    /**
     *  post提交数据 
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据 
     * @return url响应返回的html
     */
    public function sendPost($url, $datas) {
        $temps = array();	
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);		
        }	
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
    	if($url_info['port']=='')
    	{
    		$url_info['port']=80;	
    	}
    	//echo $url_info['port'];
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
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
    public function submitEOrder($requestData) {
    	$datas = array(
            'EBusinessID' => config('express')['parter_id'],
            'RequestType' => '1007',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, config('express')['api_key']);
    	$result = $this->sendPost(config('express')['request_url'], $datas);	
	
    	//根据公司业务处理返回的信息......
	
    	return $result;
    }
    
    /**
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    public function encrypt($data, $appkey) {
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
    public function JSON($array) {  
        $this->arrayRecursive($array, 'urlencode', true);  
        $json = json_encode($array);  
        return urldecode($json);  
    }  
}
