<?php
/**
 * TOP API: tmall.marketing.tmallcoupon.coupon.apply request
 * 
 * @author auto create
 * @since 1.0, 2015.11.30
 */
class TmallMarketingTmallcouponCouponApplyRequest
{
	/** 
	 * 面额，单位（分）
	 **/
	private $faceAmount;
	
	/** 
	 * 混淆昵称
	 **/
	private $nick;
	
	private $apiParas = array();
	
	public function setFaceAmount($faceAmount)
	{
		$this->faceAmount = $faceAmount;
		$this->apiParas["face_amount"] = $faceAmount;
	}

	public function getFaceAmount()
	{
		return $this->faceAmount;
	}

	public function setNick($nick)
	{
		$this->nick = $nick;
		$this->apiParas["nick"] = $nick;
	}

	public function getNick()
	{
		return $this->nick;
	}

	public function getApiMethodName()
	{
		return "tmall.marketing.tmallcoupon.coupon.apply";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->faceAmount,"faceAmount");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
