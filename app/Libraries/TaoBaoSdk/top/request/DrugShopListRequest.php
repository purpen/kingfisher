<?php
/**
 * TOP API: taobao.drug.shop.list request
 * 
 * @author auto create
 * @since 1.0, 2016.08.25
 */
class DrugShopListRequest
{
	/** 
	 * 查询关键字
	 **/
	private $keywords;
	
	/** 
	 * 页码
	 **/
	private $page;
	
	/** 
	 * 每页条数
	 **/
	private $pageSize;
	
	/** 
	 * 店铺状态，歇业：0，营业：1，所有：-1
	 **/
	private $status;
	
	private $apiParas = array();
	
	public function setKeywords($keywords)
	{
		$this->keywords = $keywords;
		$this->apiParas["keywords"] = $keywords;
	}

	public function getKeywords()
	{
		return $this->keywords;
	}

	public function setPage($page)
	{
		$this->page = $page;
		$this->apiParas["page"] = $page;
	}

	public function getPage()
	{
		return $this->page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
		$this->apiParas["page_size"] = $pageSize;
	}

	public function getPageSize()
	{
		return $this->pageSize;
	}

	public function setStatus($status)
	{
		$this->status = $status;
		$this->apiParas["status"] = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getApiMethodName()
	{
		return "taobao.drug.shop.list";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->page,"page");
		RequestCheckUtil::checkMinValue($this->page,1,"page");
		RequestCheckUtil::checkNotNull($this->pageSize,"pageSize");
		RequestCheckUtil::checkMaxValue($this->pageSize,20,"pageSize");
		RequestCheckUtil::checkMinValue($this->pageSize,1,"pageSize");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
