<?php

namespace App\Libraries\YunPianSdk\Lib;

use App\Libraries\YunPianSdk\Yunpian;

/**
 * Author: caowei<caoyuanlianni@foxmail.com>
 * Time: 2016.05.22
 * Use: 短信发送实现
 */

class SmsOperator
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

    public function single_send($data = array())
    {
        if (!array_key_exists('mobile', $data))
            return new Result(null, $data, null, 'mobile 为空');
        if (!array_key_exists('text', $data))
            return new Result(null, $data, null, 'text 为空');
        $data['apikey'] = $this->apikey;

        return HttpUtil::PostCURL($this->yunpian_config['URI_SEND_SINGLE_SMS'], $data);
    }

    public function batch_send($data = array())
    {
        if (!array_key_exists('mobile', $data))
            return new Result(null, $data, null, $error = 'mobile 为空');
        if (!array_key_exists('text', $data))
            return new Result(null, $data, null, $error = 'text 为空');
        $data['apikey'] = $this->apikey;

        return HttpUtil::PostCURL($this->yunpian_config['URI_SEND_BATCH_SMS'], $data);
    }

    public function multi_send($data = array())
    {
        if (!array_key_exists('mobile', $data))
            return new Result(null, $data, null, $error = 'mobile 为空');
        if (!array_key_exists('text', $data))
            return new Result(null, $data, null, $error = 'text 为空');
        if (count(explode(',', $data['mobile'])) != count(explode(',', $data['text'])))
            return new Result(null, $data, null, $error = 'mobile 与 text 个数不匹配');
        $data['apikey'] = $this->apikey;
        $text_array = explode(',', $data['text']);
        $data['text'] = '';
        for ($index = 0; $index < count($text_array); $index++) {
            $data['text'] .= urlencode($text_array[$index]) . ',';
        }
        $data['text'] = substr($data['text'],0,-1);
        return HttpUtil::PostCURL($this->yunpian_config['URI_SEND_MULTI_SMS'], $data);
    }
    
    // 模板发送方式[不推荐]
    public function tpl_send($data = array())
    {
        if (!array_key_exists('mobile', $data))
            return new Result(null, $data, null, 'mobile 为空');
        if (!array_key_exists('tpl_id', $data))
            return new Result(null, $data, null, 'tpl_id 为空');
        if (!array_key_exists('tpl_value', $data))
            return new Result(null, $data, null, 'tpl_value 为空');

        $data['apikey'] = $this->apikey;

        return HttpUtil::PostCURL($this->yunpian_config['URI_SEND_TPL_SMS'], $data);
    }
}
