<?php
/**
 * TOP API: taobao.trade.drug.confirmorder request
 * 
 * @author auto create
 * @since 1.0, 2016.03.21
 */
class TradeDrugConfirmorderRequest
{
	/** 
	 * public static int NORMAL_TYPE=0; 普通发货 默认 public static int DD_DAI_SONG=2; 代送宝	public static int DD_SONG_TYPE_V2=3; 点点送发货
	 **/
	private $confirmType;
	
	/** 
	 * 代送宝 代送商ID
	 **/
	private $deliveryId;
	
	/** 
	 * 订单ID
	 **/
	private $orderId;
	
	private $apiParas = array();
	
	public function setConfirmType($confirmType)
	{
		$this->confirmType = $confirmType;
		$this->apiParas["confirm_type"] = $confirmType;
	}

	public function getConfirmType()
	{
		return $this->confirmType;
	}

	public function setDeliveryId($deliveryId)
	{
		$this->deliveryId = $deliveryId;
		$this->apiParas["delivery_id"] = $deliveryId;
	}

	public function getDeliveryId()
	{
		return $this->deliveryId;
	}

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
		$this->apiParas["order_id"] = $orderId;
	}

	public function getOrderId()
	{
		return $this->orderId;
	}

	public function getApiMethodName()
	{
		return "taobao.trade.drug.confirmorder";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->orderId,"orderId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
