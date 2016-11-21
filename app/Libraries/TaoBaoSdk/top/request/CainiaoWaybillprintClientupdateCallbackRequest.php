<?php
/**
 * TOP API: cainiao.waybillprint.clientupdate.callback request
 * 
 * @author auto create
 * @since 1.0, 2016.10.14
 */
class CainiaoWaybillprintClientupdateCallbackRequest
{
	/** 
	 * 客户端mac
	 **/
	private $mac;
	
	/** 
	 * 更新类型
	 **/
	private $updateTypaName;
	
	/** 
	 * 最新的、需要更新的版本
	 **/
	private $version;
	
	private $apiParas = array();
	
	public function setMac($mac)
	{
		$this->mac = $mac;
		$this->apiParas["mac"] = $mac;
	}

	public function getMac()
	{
		return $this->mac;
	}

	public function setUpdateTypaName($updateTypaName)
	{
		$this->updateTypaName = $updateTypaName;
		$this->apiParas["update_typa_name"] = $updateTypaName;
	}

	public function getUpdateTypaName()
	{
		return $this->updateTypaName;
	}

	public function setVersion($version)
	{
		$this->version = $version;
		$this->apiParas["version"] = $version;
	}

	public function getVersion()
	{
		return $this->version;
	}

	public function getApiMethodName()
	{
		return "cainiao.waybillprint.clientupdate.callback";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->mac,"mac");
		RequestCheckUtil::checkNotNull($this->updateTypaName,"updateTypaName");
		RequestCheckUtil::checkNotNull($this->version,"version");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
