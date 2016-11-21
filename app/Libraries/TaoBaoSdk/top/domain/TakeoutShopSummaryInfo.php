<?php

/**
 * 外卖店信息
 * @author auto create
 */
class TakeoutShopSummaryInfo
{
	
	/** 
	 * 店铺地址
	 **/
	public $address;
	
	/** 
	 * 城市
	 **/
	public $city;
	
	/** 
	 * 等待确认的兑换券的订单笔数
	 **/
	public $digital_wait_confirm;
	
	/** 
	 * 店铺营业状态，歇业：0，营业：1
	 **/
	public $is_open;
	
	/** 
	 * 外卖店铺名称
	 **/
	public $name;
	
	/** 
	 * 电话号码
	 **/
	public $phone;
	
	/** 
	 * 外卖店铺id
	 **/
	public $shopid;
	
	/** 
	 * 店铺与ISV的关联ID
	 **/
	public $shopoutid;
	
	/** 
	 * 店铺分店名
	 **/
	public $sub_name;
	
	/** 
	 * 等待确认配送的订单笔数
	 **/
	public $wait_confirm;
	
	/** 
	 * 等待退款的订单笔数
	 **/
	public $wait_refund;	
}
?>