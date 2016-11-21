<?php

/**
 * 入库单信息
 * @author auto create
 */
class EntryOrder
{
	
	/** 
	 * 支持出入库单多次收货(多次收货后确认时:0:表示入库单最终状态确认;1:表示入库单中间状态确认;每次入库传入的数量为增 量;特殊情况;同一入库单;如果先收到0;后又收到1;允许修改收货的数量)
	 **/
	public $confirm_type;
	
	/** 
	 * 入库单号
	 **/
	public $entry_order_code;
	
	/** 
	 * 仓储系统入库单ID
	 **/
	public $entry_order_id;
	
	/** 
	 * 入库单类型(SCRK=生产入库;LYRK=领用入库;CCRK=残次品入库;CGRK=采购入库;DBRK=调拨入库;QTRK=其他入 库;B2BRK=B2B入库)
	 **/
	public $entry_order_type;
	
	/** 
	 * 操作时间(YYYY-MM-DD HH:MM:SS;当status=FULFILLED;operateTime为入库时间)
	 **/
	public $operate_time;
	
	/** 
	 * 外部业务编码(消息ID;用于去重;ISV对于同一请求;分配一个唯一性的编码。用来保证因为网络等原因导致重复传输;请求 不会被重复处理)
	 **/
	public $out_biz_code;
	
	/** 
	 * 货主编码
	 **/
	public $owner_code;
	
	/** 
	 * 采购单号(当orderType=CGRK时使用)
	 **/
	public $purchase_order_code;
	
	/** 
	 * 备注
	 **/
	public $remark;
	
	/** 
	 * 入库单状态(NEW-未开始处理;ACCEPT-仓库接单;PARTFULFILLED-部分收货完成;FULFILLED-收货完成;EXCEPTION-异 常;CANCELED-取消;CLOSED-关闭;REJECT-拒单;CANCELEDFAIL-取消失败;只传英文编码)
	 **/
	public $status;
	
	/** 
	 * 单据总行数(当单据需要分多个请求发送时;发送方需要将totalOrderLines填入;接收方收到后;根据实际接收到的 条数和 totalOrderLines进行比对;如果小于;则继续等待接收请求。如果等于;则表示该单据的所有请求发送完 成)
	 **/
	public $total_order_lines;
	
	/** 
	 * 仓库编码(统仓统配等无需ERP指定仓储编码的情况填OTHER)
	 **/
	public $warehouse_code;	
}
?>