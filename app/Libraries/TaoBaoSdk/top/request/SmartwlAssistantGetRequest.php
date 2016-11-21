<?php
/**
 * TOP API: taobao.smartwl.assistant.get request
 * 
 * @author auto create
 * @since 1.0, 2015.04.22
 */
class SmartwlAssistantGetRequest
{
	/** 
	 * 物流公司id列表，可以从接口taobao.logistics.companies.get获取所有物流公司id，可以传入多个值，以英文逗号分隔
	 **/
	private $cpidList;
	
	/** 
	 * 预留扩展字段，json格式
	 **/
	private $feature;
	
	/** 
	 * 订单来源，淘宝(TB)、天猫(TM)、京东(JD)、当当(DD)、拍拍(PP)、易讯(YX)、ebay(EBAY)、QQ网购(QQ)、亚马逊(AMAZON)、苏宁(SN)、国美(GM)、唯品会(WPH)、聚美(JM)、乐蜂(LF)、蘑菇街(MGJ)、聚尚(JS)、拍鞋(PX)、银泰(YT)、1号店(YHD)、凡客(VANCL)、邮乐(YL)、优购(YG)、其他(OTHERS)
	 **/
	private $orderSource;
	
	/** 
	 * 收货地详细地址
	 **/
	private $receiveAddress;
	
	/** 
	 * 发货地，至少三级行政地址
	 **/
	private $sendAddress;
	
	/** 
	 * 物流服务类型
	 **/
	private $serviceType;
	
	/** 
	 * 交易流水号，淘外订单号或者商家内部交易流水号，ISV保证其唯一性
	 **/
	private $tradeOrder;
	
	private $apiParas = array();
	
	public function setCpidList($cpidList)
	{
		$this->cpidList = $cpidList;
		$this->apiParas["cpid_list"] = $cpidList;
	}

	public function getCpidList()
	{
		return $this->cpidList;
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

	public function setOrderSource($orderSource)
	{
		$this->orderSource = $orderSource;
		$this->apiParas["order_source"] = $orderSource;
	}

	public function getOrderSource()
	{
		return $this->orderSource;
	}

	public function setReceiveAddress($receiveAddress)
	{
		$this->receiveAddress = $receiveAddress;
		$this->apiParas["receive_address"] = $receiveAddress;
	}

	public function getReceiveAddress()
	{
		return $this->receiveAddress;
	}

	public function setSendAddress($sendAddress)
	{
		$this->sendAddress = $sendAddress;
		$this->apiParas["send_address"] = $sendAddress;
	}

	public function getSendAddress()
	{
		return $this->sendAddress;
	}

	public function setServiceType($serviceType)
	{
		$this->serviceType = $serviceType;
		$this->apiParas["service_type"] = $serviceType;
	}

	public function getServiceType()
	{
		return $this->serviceType;
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

	public function getApiMethodName()
	{
		return "taobao.smartwl.assistant.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkMaxLength($this->cpidList,100,"cpidList");
		RequestCheckUtil::checkMaxLength($this->feature,1024,"feature");
		RequestCheckUtil::checkNotNull($this->orderSource,"orderSource");
		RequestCheckUtil::checkMaxLength($this->orderSource,64,"orderSource");
		RequestCheckUtil::checkNotNull($this->receiveAddress,"receiveAddress");
		RequestCheckUtil::checkMaxLength($this->receiveAddress,300,"receiveAddress");
		RequestCheckUtil::checkMaxLength($this->sendAddress,200,"sendAddress");
		RequestCheckUtil::checkNotNull($this->serviceType,"serviceType");
		RequestCheckUtil::checkNotNull($this->tradeOrder,"tradeOrder");
		RequestCheckUtil::checkMaxLength($this->tradeOrder,50,"tradeOrder");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
