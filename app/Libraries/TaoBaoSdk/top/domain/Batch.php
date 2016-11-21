<?php

/**
 * 批次信息
 * @author auto create
 */
class Batch
{
	
	/** 
	 * 实收数量(要求batchs节点下所有的实收数量之和等于orderline中的实收数量)
	 **/
	public $actual_qty;
	
	/** 
	 * 批次编号
	 **/
	public $batch_code;
	
	/** 
	 * 过期日期(YYYY-MM-DD)
	 **/
	public $expire_date;
	
	/** 
	 * 库存类型(ZP=正品;CC=残次;JS=机损;XS= 箱损;默认为ZP;)
	 **/
	public $inventory_type;
	
	/** 
	 * 生产批号
	 **/
	public $produce_code;
	
	/** 
	 * 生产日期(YYYY-MM-DD)
	 **/
	public $product_date;	
}
?>