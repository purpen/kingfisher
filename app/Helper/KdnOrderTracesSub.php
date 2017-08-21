<?php

namespace App\Helper;

/**
 * 快递鸟物流订阅
 * Class KdnOrderTracesSub
 *
 * @package App\Helper
 */
class KdnOrderTracesSub
{
    protected $parter_id = null;
    protected $app_key = null;
    protected $dist_url = null;

    public function __construct()
    {
        $this->parter_id = config('express.parter_id');
        $this->app_key = config('express.api_key');
        $this->dist_url = config('express.dist_url');
    }

    /**
     * @param string $ShipperCode 快递公司码
     * @param  string $LogisticCode 快递单号
     * @param int $order_id  订单号
     * Json方式  物流信息订阅
     */
    function orderTracesSubByJson($ShipperCode, $LogisticCode,$order_id)
    {
        $requestData = "{" .
            "'ShipperCode':'$ShipperCode'," .
            "'LogisticCode':'$LogisticCode'" .
            "'CallBack':'$order_id'" .
            "}";


        $datas = array(
            'EBusinessID' => $this->parter_id,
            'RequestType' => '1008',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, $this->app_key);
        $result = $this->sendPost($this->dist_url, $datas);

        return $result;
    }

    /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
    function sendPost($url, $datas)
    {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if (empty($url_info['port'])) {
            $url_info['port'] = 80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
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
            $gets .= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
    function encrypt($data, $appkey)
    {
        return urlencode(base64_encode(md5($data . $appkey)));
    }
}