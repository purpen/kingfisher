<?php
/**
 * TOP API: taobao.wlb.waybill.i.distributeinfo request
 * 
 * @author auto create
 * @since 1.0, 2016.02.17
 */
class WlbWaybillIDistributeinfoRequest
{
	/** 
	 * 查询分拣信息请求
	 **/
	private $waybillDistributeInfoRequest;
	
	private $apiParas = array();
	
	public function setWaybillDistributeInfoRequest($waybillDistributeInfoRequest)
	{
		$this->waybillDistributeInfoRequest = $waybillDistributeInfoRequest;
		$this->apiParas["waybill_distribute_info_request"] = $waybillDistributeInfoRequest;
	}

	public function getWaybillDistributeInfoRequest()
	{
		return $this->waybillDistributeInfoRequest;
	}

	public function getApiMethodName()
	{
		return "taobao.wlb.waybill.i.distributeinfo";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
