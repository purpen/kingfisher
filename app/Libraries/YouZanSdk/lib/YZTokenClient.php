<?php
require_once __DIR__ . '/YZApiProtocol.php';
require_once __DIR__ . '/YZHttpClient.php';

class YZTokenClient {
    private static $request_url = 'https://open.youzan.com/api/oauthentry/';

    public function __construct($access_token) {
        if ('' == $access_token) throw new Exception('access_token不能为空');
        $this->access_token = $access_token;
    }

    public function get($method, $api_version, $params = array()) {
        return $this->parse_response(
            YZHttpClient::get($this->url($method,$api_version), $this->build_request_params($method, $params))
        );
    }

    public function post($method, $api_version, $params = array(), $files = array()) {
        return $this->parse_response(
            YZHttpClient::post($this->url($method,$api_version), $this->build_request_params($method, $params), $files)
        );
    }

    public function url($method, $api_version){
        $method_array=explode(".", $method);
        $method='/'.$api_version.'/'.$method_array[count($method_array)-1];
        array_pop($method_array);
        $method=implode(".", $method_array).$method;
        $url=self::$request_url.$method;
        return $url;
    }

    private function parse_response($response_data) {
        $data = json_decode($response_data, true);
        if (null === $data) throw new Exception('response invalid, data: ' . $response_data);
        return $data;
    }

    private function build_request_params($method, $api_params) {
        if (!is_array($api_params)) $api_params = array();
        $pairs = $this->get_common_params($this->access_token, $method);
        foreach ($api_params as $k => $v) {
            if (isset($pairs[$k])) throw new Exception('参数名冲突');
            $pairs[$k] = $v;
        }

        return $pairs;
    }

    private function get_common_params($access_token, $method) {
        $params = array();
        $params[YZApiProtocol::TOKEN_KEY] = $access_token;
        $params[YZApiProtocol::METHOD_KEY] = $method;
        return $params;
    }
}