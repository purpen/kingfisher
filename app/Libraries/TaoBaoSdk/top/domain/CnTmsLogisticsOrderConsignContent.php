<?php

/**
 * 配送发货信息
 * @author auto create
 */
class CnTmsLogisticsOrderConsignContent
{
	
	/** 
	 * 配送要求
	 **/
	public $deliver_requirements;
	
	/** 
	 * 扩展字段 K:V;
	 **/
	public $extend_fields;
	
	/** 
	 * 发货的商品信息
	 **/
	public $items;
	
	/** 
	 * 运单号 若是自己联系物流，则必填 否则表示菜鸟自动获取运单号
	 **/
	public $mail_no;
	
	/** 
	 * ERP订单号
	 **/
	public $order_code;
	
	/** 
	 * 来源渠道（TB 淘宝，JD 京东，TM 天猫，1688 1688（阿里中文站），YHD 1号店，DD 当当，VANCL 凡客，PP 拍拍，YX 易讯，EBAY 易贝ebay，AMAZON 亚马逊，SN 苏宁在线，GM 国美在线，WPH 唯品会，JM 聚美优品，LF 乐蜂网，MGJ 蘑菇街，JS 聚尚网，YG 优购，YT 银泰，YL 邮乐，PX 拍鞋网，POS POS门店，OTHERS 其他）
	 **/
	public $order_source;
	
	/** 
	 * 货主ID
	 **/
	public $owner_user_id;
	
	/** 
	 * 此订单总的包裹数，如订单拆包裹时，传入此参数，配送时会将同一订单的包裹一配送
	 **/
	public $package_count;
	
	/** 
	 * 包裹高度（厘米）
	 **/
	public $package_height;
	
	/** 
	 * 包裹长度（厘米）
	 **/
	public $package_length;
	
	/** 
	 * 此订单的第几个包裹，如订单拆包裹时，传入此参数，配送时会将同一订单的包裹一配送
	 **/
	public $package_no;
	
	/** 
	 * 包裹体积（立方厘米）
	 **/
	public $package_volume;
	
	/** 
	 * 包裹重量（克）
	 **/
	public $package_weight;
	
	/** 
	 * 包裹宽度（厘米）
	 **/
	public $package_width;
	
	/** 
	 * 商家送货方式，1商家送货，2菜鸟揽货
	 **/
	public $pick_up_type;
	
	/** 
	 * 收件人地址信息
	 **/
	public $receiver_info;
	
	/** 
	 * 备注
	 **/
	public $remark;
	
	/** 
	 * 发件人地址信息
	 **/
	public $sender_info;
	
	/** 
	 * 店铺编码
	 **/
	public $shop_code;
	
	/** 
	 * 物流服务解决方案Code，此字段由菜鸟提供
	 **/
	public $solutions_code;
	
	/** 
	 * 物流公司编码
	 **/
	public $tms_code;
	
	/** 
	 * 要求菜鸟上门揽货服务，当pick_up_Type=2且需求指定时做揽收时，此字段需要传值
	 **/
	public $tms_got_service;
	
	/** 
	 * 交易订单id
	 **/
	public $trade_id;	
}
?>