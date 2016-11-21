<?php
/**
 * TOP API: alibaba.alitj.order.realnamecard.info.submit request
 * 
 * @author auto create
 * @since 1.0, 2016.08.05
 */
class AlibabaAlitjOrderRealnamecardInfoSubmitRequest
{
	/** 
	 * sim卡iccid（一般为18位到20位）
	 **/
	private $iccid;
	
	/** 
	 * 淘宝订单号
	 **/
	private $orderNo;
	
	private $apiParas = array();
	
	public function setIccid($iccid)
	{
		$this->iccid = $iccid;
		$this->apiParas["iccid"] = $iccid;
	}

	public function getIccid()
	{
		return $this->iccid;
	}

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
		$this->apiParas["order_no"] = $orderNo;
	}

	public function getOrderNo()
	{
		return $this->orderNo;
	}

	public function getApiMethodName()
	{
		return "alibaba.alitj.order.realnamecard.info.submit";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->iccid,"iccid");
		RequestCheckUtil::checkMaxLength($this->iccid,32,"iccid");
		RequestCheckUtil::checkNotNull($this->orderNo,"orderNo");
		RequestCheckUtil::checkMinValue($this->orderNo,1000,"orderNo");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
