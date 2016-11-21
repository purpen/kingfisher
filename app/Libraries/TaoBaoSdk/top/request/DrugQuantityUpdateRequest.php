<?php
/**
 * TOP API: taobao.drug.quantity.update request
 * 
 * @author auto create
 * @since 1.0, 2016.11.03
 */
class DrugQuantityUpdateRequest
{
	/** 
	 * 外部商品ID
	 **/
	private $outItemId;
	
	/** 
	 * 外部店铺ID
	 **/
	private $outStoreId;
	
	/** 
	 * 库存数量
	 **/
	private $quantity;
	
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

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		$this->apiParas["quantity"] = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}

	public function getApiMethodName()
	{
		return "taobao.drug.quantity.update";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->outItemId,"outItemId");
		RequestCheckUtil::checkNotNull($this->outStoreId,"outStoreId");
		RequestCheckUtil::checkNotNull($this->quantity,"quantity");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
