<?php
/**
 * TOP API: taobao.trade.drug.get request
 * 
 * @author auto create
 * @since 1.0, 2016.03.21
 */
class TradeDrugGetRequest
{
	/** 
	 * true-商家下所有店铺的待确认订单, false—指定店铺的订单
	 **/
	private $isAll;
	
	/** 
	 * 返回记录数，超过20按20条返回数据
	 **/
	private $maxSize;
	
	/** 
	 * 店铺id
	 **/
	private $storeId;
	
	private $apiParas = array();
	
	public function setIsAll($isAll)
	{
		$this->isAll = $isAll;
		$this->apiParas["is_all"] = $isAll;
	}

	public function getIsAll()
	{
		return $this->isAll;
	}

	public function setMaxSize($maxSize)
	{
		$this->maxSize = $maxSize;
		$this->apiParas["max_size"] = $maxSize;
	}

	public function getMaxSize()
	{
		return $this->maxSize;
	}

	public function setStoreId($storeId)
	{
		$this->storeId = $storeId;
		$this->apiParas["store_id"] = $storeId;
	}

	public function getStoreId()
	{
		return $this->storeId;
	}

	public function getApiMethodName()
	{
		return "taobao.trade.drug.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->maxSize,"maxSize");
		RequestCheckUtil::checkMaxValue($this->maxSize,20,"maxSize");
		RequestCheckUtil::checkMinValue($this->maxSize,1,"maxSize");
		RequestCheckUtil::checkNotNull($this->storeId,"storeId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
