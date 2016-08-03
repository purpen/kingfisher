<?php

namespace App\Libraries\YunPianSdk\Lib;

use App\Libraries\YunPianSdk\Yunpian;

/**
 * Author: caowei<caoyuanlianni@foxmail.com>
 * Time: 2016.05.22
 * Use: 获取用户信息
 */

class UserOperator
{
    public $apikey;
    public $api_secret;
    public $yunpian_config;
    
    public function __construct($apikey=null,$api_secret=null)
    {
        $yunpian = new Yunpian();
        $this->yunpian_config = $yunpian->config;
        if($api_secret == null)
            $this->api_secret = $this->yunpian_config['API_SECRET'];
        else
            $this->api_secret = $api_secret;
        if($apikey == null)
            $this->apikey = $this->yunpian_config['APIKEY'];
        else
            $this->apikey = $apikey;
    }
    
    public function encrypt(&$data){

    }
    
    public function get($data=array()){
        $data['apikey'] = $this->apikey;
        return HttpUtil::PostCURL($this->yunpian_config['URI_GET_USER_INFO'],$data);
    }
    
    public function set($data=array()){
        $data['apikey'] = $this->apikey;
        return HttpUtil::PostCURL($this->yunpian_config['URI_SET_USER_INFO'],$data);
    }
}
?>