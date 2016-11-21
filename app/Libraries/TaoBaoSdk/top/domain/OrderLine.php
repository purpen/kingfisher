<?php

/**
 * 订单信息
 * @author auto create
 */
class OrderLine
{
	
	/** 
	 * 实收数量
	 **/
	public $actual_qty;
	
	/** 
	 * 批次编码
	 **/
	public $batch_code;
	
	/** 
	 * 批次信息
	 **/
	public $batchs;
	
	/** 
	 * 商品过期日期(YYYY-MM-DD)
	 **/
	public $expire_date;
	
	/** 
	 * 库存类型(ZP=正品;CC=残次;JS=机损;XS=箱损;默认为ZP)
	 **/
	public $inventory_type;
	
	/** 
	 * 商品编码
	 **/
	public $item_code;
	
	/** 
	 * 仓储系统商品ID
	 **/
	public $item_id;
	
	/** 
	 * 商品名称
	 **/
	public $item_name;
	
	/** 
	 * 入库单的行号
	 **/
	public $order_line_no;
	
	/** 
	 * 外部业务编码(消息ID;用于去重;当单据需要分批次发送时使用)
	 **/
	public $out_biz_code;
	
	/** 
	 * 货主编码
	 **/
	public $owner_code;
	
	/** 
	 * 应收商品数量
	 **/
	public $plan_qty;
	
	/** 
	 * 生产批号
	 **/
	public $produce_code;
	
	/** 
	 * 商品生产日期(YYYY-MM-DD)
	 **/
	public $product_date;	
}
?>