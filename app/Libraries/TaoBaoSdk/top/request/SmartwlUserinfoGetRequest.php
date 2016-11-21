<?php
/**
 * TOP API: taobao.smartwl.userinfo.get request
 * 
 * @author auto create
 * @since 1.0, 2015.04.17
 */
class SmartwlUserinfoGetRequest
{
	/** 
	 * 预留扩展字段，格式json串
	 **/
	private $feature;
	
	private $apiParas = array();
	
	public function setFeature($feature)
	{
		$this->feature = $feature;
		$this->apiParas["feature"] = $feature;
	}

	public function getFeature()
	{
		return $this->feature;
	}

	public function getApiMethodName()
	{
		return "taobao.smartwl.userinfo.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkMaxLength($this->feature,500,"feature");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
