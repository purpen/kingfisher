<?php

namespace App\Libraries\YunPianSdk\Lib;

use App\Libraries\YunPianSdk\Yunpian;

/**
 * Author: caowei<caoyuanlianni@foxmail.com>
 * Time: 2016.05.22
 * Use: 模板短信发送实现
 */

class TplOperator
{
    public $apikey;
    public $api_secret;
    public $yunpian_config;

    public function __construct($apikey = null, $api_secret = null)
    {
        $yunpian = new Yunpian();
        $this->yunpian_config = $yunpian->config;
        if ($api_secret == null)
            $this->api_secret = $this->yunpian_config['API_SECRET'];
        else
            $this->api_secret = $api_secret;
        if ($apikey == null)
            $this->apikey = $this->yunpian_config['APIKEY'];
        else
            $this->apikey = $apikey;
    }

    public function encrypt(&$data)
    {

    }
    
    public function get_default($data = array())
    {
        $data['apikey'] = $this->apikey;

        return HttpUtil::PostCURL($this->yunpian_config['URI_GET_DEFAULT_TEMPLATE'], $data);
    }
    
    public function get($data = array())
    {
        $data['apikey'] = $this->apikey;

        return HttpUtil::PostCURL($this->yunpian_config['URI_GET_TEMPLATE'], $data);
    }

    public function add($data = array())
    {
        if (!array_key_exists('tpl_id',$data))
            return new Result(null,$data,null,$error = 'tpl_id 为空');
        if (!array_key_exists('tpl_content',$data))
            return new Result(null,$data,null,$error = 'tpl_content 为空');
        $data['apikey'] = $this->apikey;
        return HttpUtil::PostCURL($this->yunpian_config['URI_ADD_TEMPLATE'], $data);
    }

    public function upd($data = array())
    {
        if (!array_key_exists('tpl_id',$data))
            return new Result(null,$data,null,$error = 'tpl_id 为空');
        if (!array_key_exists('tpl_content',$data))
            return new Result(null,$data,null,$error = 'tpl_content 为空');
        $data['apikey'] = $this->apikey;
        return HttpUtil::PostCURL($this->yunpian_config['URI_UPD_TEMPLATE'], $data);
    }

    public function del($data = array())
    {
        if (!array_key_exists('tpl_id',$data))
            return new Result(null,$data,null,$error = 'tpl_id 为空');
        $data['apikey'] = $this->apikey;

        return HttpUtil::PostCURL($this->yunpian_config['URI_DEL_TEMPLATE'], $data);
    }
}