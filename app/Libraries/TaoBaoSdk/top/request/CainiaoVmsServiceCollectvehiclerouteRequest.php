<?php
/**
 * TOP API: cainiao.vms.service.collectvehicleroute request
 * 
 * @author auto create
 * @since 1.0, 2016.10.10
 */
class CainiaoVmsServiceCollectvehiclerouteRequest
{
	/** 
	 * 数据 采集时间
	 **/
	private $colDate;
	
	/** 
	 * cp编码
	 **/
	private $cpCode;
	
	/** 
	 * 车辆唯一标识号
	 **/
	private $deviceId;
	
	/** 
	 * 纬度
	 **/
	private $latitude;
	
	/** 
	 * 经度
	 **/
	private $longitude;
	
	/** 
	 * 车牌号
	 **/
	private $vechileNumber;
	
	private $apiParas = array();
	
	public function setColDate($colDate)
	{
		$this->colDate = $colDate;
		$this->apiParas["col_date"] = $colDate;
	}

	public function getColDate()
	{
		return $this->colDate;
	}

	public function setCpCode($cpCode)
	{
		$this->cpCode = $cpCode;
		$this->apiParas["cp_code"] = $cpCode;
	}

	public function getCpCode()
	{
		return $this->cpCode;
	}

	public function setDeviceId($deviceId)
	{
		$this->deviceId = $deviceId;
		$this->apiParas["device_id"] = $deviceId;
	}

	public function getDeviceId()
	{
		return $this->deviceId;
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

	public function setVechileNumber($vechileNumber)
	{
		$this->vechileNumber = $vechileNumber;
		$this->apiParas["vechile_number"] = $vechileNumber;
	}

	public function getVechileNumber()
	{
		return $this->vechileNumber;
	}

	public function getApiMethodName()
	{
		return "cainiao.vms.service.collectvehicleroute";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->colDate,"colDate");
		RequestCheckUtil::checkNotNull($this->cpCode,"cpCode");
		RequestCheckUtil::checkNotNull($this->latitude,"latitude");
		RequestCheckUtil::checkNotNull($this->longitude,"longitude");
		RequestCheckUtil::checkNotNull($this->vechileNumber,"vechileNumber");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
