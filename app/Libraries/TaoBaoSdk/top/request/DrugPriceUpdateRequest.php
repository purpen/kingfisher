<?php
/**
 * TOP API: taobao.drug.price.update request
 * 
 * @author auto create
 * @since 1.0, 2016.04.08
 */
class DrugPriceUpdateRequest
{
	/** 
	 * 对应的外部商品编码
	 **/
	private $outItemId;
	
	/** 
	 * 对应的外部店铺ID
	 **/
	private $outStoreId;
	
	/** 
	 * 商品价格
	 **/
	private $price;
	
	private $apiParas = array();
	
	public function setOutItemId($outItemId)
	{
		$this->outItemId = $outItemId;
		$this->apiParas["out_item_id"] = $outItemId;
	}

	public function getOutItemId()
	{
		return $this->outItemId;
	}

	public function setOutStoreId($outStoreId)
	{
		$this->outStoreId = $outStoreId;
		$this->apiParas["out_store_id"] = $outStoreId;
	}

	public function getOutStoreId()
	{
		return $this->outStoreId;
	}

	public function setPrice($price)
	{
		$this->price = $price;
		$this->apiParas["price"] = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getApiMethodName()
	{
		return "taobao.drug.price.update";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->outItemId,"outItemId");
		RequestCheckUtil::checkNotNull($this->outStoreId,"outStoreId");
		RequestCheckUtil::checkNotNull($this->price,"price");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
