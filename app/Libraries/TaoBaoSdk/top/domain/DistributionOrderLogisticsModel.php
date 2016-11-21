<?php

/**
 * 物流信息
 * @author auto create
 */
class DistributionOrderLogisticsModel
{
	
	/** 
	 * 需要变更的订购状态, NOT_ORDER(1, "未订购"), 未订购； ORDER_AUDIT(2, "订购中"), 无订购接口，提交给供应商，线下受理中； ON_ORDER(3, "订购中"), 有订购接口，线上受理中； FAILURE(4, "订购失败")，订购失败； SUCCESS(5, "订购成功")，订购成功； CANCEL(6, "订购取消")，订购取消
	 **/
	public $contract_order_status;
	
	/** 
	 * 分销商编号
	 **/
	public $distributor_id;
	
	/** 
	 * 快递公司编码
	 **/
	public $express_code;
	
	/** 
	 * 快递名称
	 **/
	public $express_name;
	
	/** 
	 * 快递单号
	 **/
	public $express_number;
	
	/** 
	 * iccid
	 **/
	public $iccid;
	
	/** 
	 * 身份证相关信息
	 **/
	public $id_card_model;
	
	/** 
	 * 商品编码
	 **/
	public $item_serial_no;
	
	/** 
	 * 操作时间
	 **/
	public $operate_time;
	
	/** 
	 * 淘宝交易订单号
	 **/
	public $order_no;
	
	/** 
	 * 产品编码，如ICCID
	 **/
	public $product_serial_no;
	
	/** 
	 * 失败原因
	 **/
	public $reason;	
}
?>