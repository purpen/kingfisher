<?php
/**
 * TOP API: taobao.smartwl.package.create request
 * 
 * @author auto create
 * @since 1.0, 2015.04.22
 */
class SmartwlPackageCreateRequest
{
	/** 
	 * 物流服务商Id
	 **/
	private $cpId;
	
	/** 
	 * 预留扩展字段，格式json
	 **/
	private $feature;
	
	/** 
	 * 包裹高度，单位cm
	 **/
	private $height;
	
	/** 
	 * 包裹长度，单位cm
	 **/
	private $length;
	
	/** 
	 * 运单号，cp_id+ mail_no唯一
	 **/
	private $mailNo;
	
	/** 
	 * 订单来源，淘宝(TB)、天猫(TM)、京东(JD)、当当(DD)、拍拍(PP)、易讯(YX)、ebay(EBAY)、QQ网购(QQ)、亚马逊(AMAZON)、苏宁(SN)、国美(GM)、唯品会(WPH)、聚美(JM)、乐蜂(LF)、蘑菇街(MGJ)、聚尚(JS)、拍鞋(PX)、银泰(YT)、1号店(YHD)、凡客(VANCL)、邮乐(YL)、优购(YG)、其他(OTHERS)
	 **/
	private $orderSrc;
	
	/** 
	 * 交易流水号，淘外订单号或者商家内部交易流水号，ISV保证其唯一性
	 **/
	private $tradeOrder;
	
	/** 
	 * 包裹体积，单位cm3
	 **/
	private $volumn;
	
	/** 
	 * 包裹重量，单位克
	 **/
	private $weight;
	
	/** 
	 * 包裹宽度，单位cm
	 **/
	private $width;
	
	private $apiParas = array();
	
	public function setCpId($cpId)
	{
		$this->cpId = $cpId;
		$this->apiParas["cp_id"] = $cpId;
	}

	public function getCpId()
	{
		return $this->cpId;
	}

	public function setFeature($feature)
	{
		$this->feature = $feature;
		$this->apiParas["feature"] = $feature;
	}

	public function getFeature()
	{
		return $this->feature;
	}

	public function setHeight($height)
	{
		$this->height = $height;
		$this->apiParas["height"] = $height;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function setLength($length)
	{
		$this->length = $length;
		$this->apiParas["length"] = $length;
	}

	public function getLength()
	{
		return $this->length;
	}

	public function setMailNo($mailNo)
	{
		$this->mailNo = $mailNo;
		$this->apiParas["mail_no"] = $mailNo;
	}

	public function getMailNo()
	{
		return $this->mailNo;
	}

	public function setOrderSrc($orderSrc)
	{
		$this->orderSrc = $orderSrc;
		$this->apiParas["order_src"] = $orderSrc;
	}

	public function getOrderSrc()
	{
		return $this->orderSrc;
	}

	public function setTradeOrder($tradeOrder)
	{
		$this->tradeOrder = $tradeOrder;
		$this->apiParas["trade_order"] = $tradeOrder;
	}

	public function getTradeOrder()
	{
		return $this->tradeOrder;
	}

	public function setVolumn($volumn)
	{
		$this->volumn = $volumn;
		$this->apiParas["volumn"] = $volumn;
	}

	public function getVolumn()
	{
		return $this->volumn;
	}

	public function setWeight($weight)
	{
		$this->weight = $weight;
		$this->apiParas["weight"] = $weight;
	}

	public function getWeight()
	{
		return $this->weight;
	}

	public function setWidth($width)
	{
		$this->width = $width;
		$this->apiParas["width"] = $width;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function getApiMethodName()
	{
		return "taobao.smartwl.package.create";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->cpId,"cpId");
		RequestCheckUtil::checkMaxLength($this->feature,1024,"feature");
		RequestCheckUtil::checkNotNull($this->mailNo,"mailNo");
		RequestCheckUtil::checkMaxLength($this->mailNo,20,"mailNo");
		RequestCheckUtil::checkNotNull($this->orderSrc,"orderSrc");
		RequestCheckUtil::checkMaxLength($this->orderSrc,64,"orderSrc");
		RequestCheckUtil::checkNotNull($this->tradeOrder,"tradeOrder");
		RequestCheckUtil::checkMaxLength($this->tradeOrder,30,"tradeOrder");
		RequestCheckUtil::checkNotNull($this->weight,"weight");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
