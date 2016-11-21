<?php
/**
 * TOP API: taobao.delivery.drug.pickup request
 * 
 * @author auto create
 * @since 1.0, 2016.03.21
 */
class DeliveryDrugPickupRequest
{
	/** 
	 * 物流订单号
	 **/
	private $deliveryOrderNo;
	
	/** 
	 * 地图坐标：维度
	 **/
	private $latitude;
	
	/** 
	 * 地图坐标：经度
	 **/
	private $longitude;
	
	private $apiParas = array();
	
	public function setDeliveryOrderNo($deliveryOrderNo)
	{
		$this->deliveryOrderNo = $deliveryOrderNo;
		$this->apiParas["delivery_order_no"] = $deliveryOrderNo;
	}

	public function getDeliveryOrderNo()
	{
		return $this->deliveryOrderNo;
	}

	public function setLatitude($latitude)
	{
		$this->latitude = $latitude;
		$this->apiParas["latitude"] = $latitude;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}

	public function setLongitude($longitude)
	{
		$this->longitude = $longitude;
		$this->apiParas["longitude"] = $longitude;
	}

	public function getLongitude()
	{
		return $this->longitude;
	}

	public function getApiMethodName()
	{
		return "taobao.delivery.drug.pickup";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->deliveryOrderNo,"deliveryOrderNo");
		RequestCheckUtil::checkNotNull($this->latitude,"latitude");
		RequestCheckUtil::checkNotNull($this->longitude,"longitude");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
