@extends('home.base')

@section('title', '新增订单模版')

@section('customize_css')
    @parent
	.maindata input{
		width:100px;
	}

  .red {
    color: red;
  }
  .item-title {
    text-align: center;
    font-size: 18px;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
    padding-bottom: 10px;
  }
  .item-box {
    border: 1px dashed #ccc;
    padding: 10px 5px;
  }
@endsection

@section('content')
    @parent
	<div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					新增订单模版
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		@include('block.form-errors')
		<div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
            		<form id="orderMouldForm" role="form" method="post" class="form-horizontal" action="{{ url('/orderMould/store') }}">
                      <input type="hidden" name="id" value="{{ $orderMould->id }}" />
                      <h5>基本信息</h5>
                      <hr>

                        <div class="form-group">
                          <label for="invoice_info" class="col-sm-1 control-label">名称</label>
                          <div class="col-sm-4">
                            <input type="text" name="name" value="{{ $orderMould->name }}" class="form-control">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="type" class="col-sm-1 control-label">类型</label>
                          <div class="col-sm-2">
                            <select class="selectpicker" id="supplier_type" name="type" value="{{ $orderMould->type }}" style="display: none;">
                              <option value="1" @if($orderMould->type == 1) selected @endif>渠道</option>
                              <option value="2" @if($orderMould->type == 2) selected @endif>品牌</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="type" class="col-sm-1 control-label">状态</label>
                            <div class="col-sm-2">
                                <div class="radio-inline">
                                    <label class="mr-3r">
                                        <input name="status" value="1" @if($orderMould->status == 1) checked @endif type="radio"> 启用
                                    </label>
                                    <label class="ml-3r">
                                        <input name="status" value="0" @if($orderMould->status == 0) checked @endif type="radio"> 禁用
                                    </label>
                                </div>
                            </div>
                        </div>

                      <h5>配置信息 <span style="color: red;font-size: 12px;">* 以下请添写当前Excel模版对应的列序号</span></h5>
                      <hr>

                      <div class="row">
                        <div class="col-md-2">
                          <p class="item-title">订单信息</p>

                          <div class="item-box">
                            <div class="form-group">
                              <label for="outside_target_id" class="col-sm-6 control-label"><span class="red">* </span>站外订单号</label>
                              <div class="col-sm-6">
                                <input type="text" name="outside_target_id" value="{{ $orderMould->outside_target_id }}" class="form-control">
                              </div>
                            </div>

                              <div class="form-group">
                                  <label for="outside_target_id" class="col-sm-6 control-label"><span class="red"> </span>订单号</label>
                                  <div class="col-sm-6">
                                      <input type="text" name="order_no" value="{{ $orderMould->order_no }}" class="form-control">
                                  </div>
                              </div>

                            <div class="form-group">
                              <label for="order_start_time" class="col-sm-6 control-label">下单时间</label>
                              <div class="col-sm-6">
                                <input type="text" name="order_start_time" value="{{ $orderMould->order_start_time }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="summary" class="col-sm-6 control-label">备注</label>
                              <div class="col-sm-6">
                                <input type="text" name="summary" value="{{ $orderMould->summary }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_summary" class="col-sm-6 control-label">买家备注</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_summary" value="{{ $orderMould->buyer_summary }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="seller_summary" class="col-sm-6 control-label">卖家备注</label>
                              <div class="col-sm-6">
                                <input type="text" name="seller_summary" value="{{ $orderMould->seller_summary }}" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <p class="item-title">产品信息</p>
                          <div class="item-box">

                              <div class="form-group">
                                  <label for="sku_number" class="col-sm-6 control-label"><span class="red"> </span>站外sku编号</label>
                                  <div class="col-sm-6">
                                      <input type="text" name="outside_sku_number" value="{{ $orderMould->outside_sku_number }}" class="form-control">
                                  </div>
                              </div>

                            <div class="form-group">
                              <label for="sku_number" class="col-sm-6 control-label"><span class="red">* </span>sku编号</label>
                              <div class="col-sm-6">
                                <input type="text" name="sku_number" value="{{ $orderMould->sku_number }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="sku_count" class="col-sm-6 control-label">sku数量</label>
                              <div class="col-sm-6">
                                <input type="text" name="sku_count" value="{{ $orderMould->sku_count }}" class="form-control">
                              </div>
                            </div>

                              <div class="form-group">
                                  <label for="sku_name" class="col-sm-6 control-label">sku名称</label>
                                  <div class="col-sm-6">
                                      <input type="text" name="sku_name" value="{{ $orderMould->sku_name }}" class="form-control">
                                  </div>
                              </div>
                          </div>

                        </div>
                        <div class="col-md-2">
                          <p class="item-title">收货人信息</p>
                          <div class="item-box">
                            <div class="form-group">
                              <label for="buyer_name" class="col-sm-6 control-label"><span class="red">* </span>姓名</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_name" value="{{ $orderMould->buyer_name }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_phone" class="col-sm-6 control-label"><span class="red">* </span>手机号</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_phone" value="{{ $orderMould->buyer_phone }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_tel" class="col-sm-6 control-label">电话</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_tel" value="{{ $orderMould->buyer_tel }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_zip" class="col-sm-6 control-label">邮编</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_zip" value="{{ $orderMould->buyer_zip }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_province" class="col-sm-6 control-label">省/自治区</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_province" value="{{ $orderMould->buyer_province }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_city" class="col-sm-6 control-label">城市</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_city" value="{{ $orderMould->buyer_city }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_county" class="col-sm-6 control-label">区/县</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_county" value="{{ $orderMould->buyer_county }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_township" class="col-sm-6 control-label">城镇/乡</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_township" value="{{ $orderMould->buyer_township }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="buyer_address" class="col-sm-6 control-label"><span class="red">* </span>详细地址</label>
                              <div class="col-sm-6">
                                <input type="text" name="buyer_address" value="{{ $orderMould->buyer_address }}" class="form-control">
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-2">
                          <p class="item-title">物流信息</p>
                          <div class="item-box">
                            <div class="form-group">
                              <label for="express_name" class="col-sm-6 control-label">快递名称</label>
                              <div class="col-sm-6">
                                <input type="text" name="express_name" value="{{ $orderMould->express_name }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="express_no" class="col-sm-6 control-label">快递单号</label>
                              <div class="col-sm-6">
                                <input type="text" name="express_no" value="{{ $orderMould->express_no }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="express_content" class="col-sm-6 control-label">快递备注</label>
                              <div class="col-sm-6">
                                <input type="text" name="express_content" value="{{ $orderMould->express_content }}" class="form-control">
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-2">
                          <p class="item-title">发票信息</p>
                          <div class="item-box">
                            <div class="form-group">
                              <label for="invoice_type" class="col-sm-6 control-label">发票类型</label>
                              <div class="col-sm-6">
                                <input type="text" name="invoice_type" value="{{ $orderMould->invoice_type }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="invoice_header" class="col-sm-6 control-label">发票抬头</label>
                              <div class="col-sm-6">
                                <input type="text" name="invoice_header" value="{{ $orderMould->invoice_header }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="invoice_info" class="col-sm-6 control-label">内容</label>
                              <div class="col-sm-6">
                                <input type="text" name="invoice_info" value="{{ $orderMould->invoice_info }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="invoice_added_value_tax" class="col-sm-6 control-label">增值税发票</label>
                              <div class="col-sm-6">
                                <input type="text" name="invoice_added_value_tax" value="{{ $orderMould->invoice_added_value_tax }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="invoice_ordinary_number" class="col-sm-6 control-label">税号</label>
                              <div class="col-sm-6">
                                <input type="text" name="invoice_ordinary_number" value="{{ $orderMould->invoice_ordinary_number }}" class="form-control">
                              </div>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-2">
                          <p class="item-title">费用信息</p>
                          <div class="item-box">
                            <div class="form-group">
                              <label for="freight" class="col-sm-6 control-label">快递费</label>
                              <div class="col-sm-6">
                                <input type="text" name="freight" value="{{ $orderMould->freight }}" class="form-control">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="discount_money" class="col-sm-6 control-label">优惠金额</label>
                              <div class="col-sm-6">
                                <input type="text" name="discount_money" value="{{ $orderMould->discount_money }}" class="form-control">
                              </div>
                            </div>
                          </div>

                        </div>

                      </div>


                        <div class="form-group">
                            <div class="col-sm-12 col-sm-offset-10">
                				      <button type="submit" class="btn btn-magenta btn-lg save">提交</button>
                				      <button type="button" class="btn btn-white cancel btn-lg once"  onclick="window.history.back()">取消</button>
                            </div>
                        </div>
            			{!! csrf_field() !!}
            		</form>
                </div>
            </div>
        </div>
	</div>
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
    
@endsection

@section('load_private')
	@parent
	{{--<script>--}}

		$("#orderMouldForm").formValidation({
		framework: 'bootstrap',
		icon: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			name: {
				validators: {
					notEmpty: {
						message: '请输入名称！'
					}
				}
			},
      type: {
          validators: {
              notEmpty: {
                  message: '请选择类型！'
              }
          }
      },
			outside_target_id: {
				validators: {
					notEmpty: {
						message: '请输入站外单号序号！'
					}
				}
      },
			sku_number: {
				validators: {
					notEmpty: {
						message: '请输入SKU编码序号！'
					}
				}
			},
			buyer_name: {
				validators: {
					notEmpty: {
						message: '请输入收货人姓名序号！'
					}
				}
      },
			buyer_phone: {
				validators: {
					notEmpty: {
						message: '请输入收货人手机序号！'
					}
				}
			},
			buyer_address: {
				validators: {
					notEmpty: {
						message: '请输入收货详细地址序号！'
					}
				}
			}
		}
	});

@endsection
