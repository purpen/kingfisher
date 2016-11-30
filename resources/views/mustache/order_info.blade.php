<script id="order-info-form" type="text-x-mustache-tmpl">
@{{ #order }}
<tr class="order-list">
    <td colspan="14" class="plr-0 pb-0">
        <div class="btn-group ptb-2r pl-2r" data-toggle="buttons">
            <label class="btn btn-default active" id="label-user">
                <input type="radio" id="user"> 客户信息
            </label>
            <label class="btn btn-default" id="label-product">
                <input type="radio" id="product"> 商品信息
            </label>
            <label class="btn btn-default" id="label-jyi">
                <input type="radio" id="jyi"> 交易信息
            </label>
            <label class="btn btn-default" id="label-beiz" style="width: 82px;">
                <input type="radio" id="beiz"> 备注
            </label>
        </div>
        <form id="form-user" role="form" class="form-horizontal mt-2r">
            <input type="hidden" id="order_id" value="@{{id}}">
            
            <div class="form-group">
                <label class="col-sm-1 control-label">物流公司</label>
                <div class="col-sm-3">
                    <select class="selectpicker" id="express_id" name="logistic_id" style="display: none;">
                        @{{ #logistic_list }}
                        <option value="@{{ id }}" @{{ selected }}>@{{ name }}</option>
                        @{{ /logistic_list }}
                    </select>
                </div>
    
                <label class="col-sm-1 control-label">发货仓库</label>
                <div class="col-sm-3">
                    <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
                        @{{ #storage_list }}
                        <option value="@{{ id }}" @{{ selected }}>@{{ name }}</option>
                        @{{ /storage_list }}
                    </select>
                </div>
            </div>
            
            <div class="form-group">                
                <label class="col-sm-1 control-label">收货人</label>
                <div class="col-sm-2">
                    <input validate="" showname="收货人" type="text" class="form-control order" id="buyer_name" name="buyer_name" value="@{{buyer_name}}">
                </div>
                <label class="col-sm-1 control-label">手机号</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="buyer_phone" name="buyer_phone" value="@{{ buyer_phone }}">
                </div>
                <label class="col-sm-1 control-label">电话号码</label>
                <div class="col-sm-2">
                    <input validate="" showname="收货人" type="text" class="form-control order" id="buyer_tel" name="buyer_tel" value="@{{ buyer_tel }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label">省份</label>
                <div class="col-sm-2">
                    <input validate="" showname="省份" type="text" class="form-control order" id="buyer_province" name="buyer_province" value="@{{buyer_province}}">
                </div>
                <label class="col-sm-1 control-label">市</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="buyer_city" name="buyer_city" value="@{{ buyer_city }}">
                </div>
                <label class="col-sm-1 control-label">区/县</label>
                <div class="col-sm-2">
                    <input validate="" showname="" type="text" class="form-control order" id="buyer_county" name="buyer_county" value="@{{ buyer_county }}">
                </div>
                <label class="col-sm-1 control-label">镇</label>
                <div class="col-sm-2">
                    <input validate="" showname="" type="text" class="form-control order" id="buyer_township" name="buyer_township" value="@{{ buyer_township }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label">详细地址</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control order mobile" id="buyer_address" name="buyer_address" value="@{{ buyer_address }}">
                </div>
                
                <label class="col-sm-1 control-label">邮政编码</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="buyer_zip" name="buyer_zip" value="@{{ buyer_zip }}">
                </div>
                
            </div>
        </form>
        
        
        <form id="form-product" role="form" class="form-horizontal mt-2r" style="display:none;">
            <div class="form-group">
                <div class="col-sm-2">
                    <div class="ml-4r">
                        <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addproduct" id="addproduct-button">
                            <i class="glyphicon glyphicon-plus"></i> 添加赠品
                        </a>
                    </div>
                </div>
                <div class="col-sm-10 text-right">
                    <div class="mr-3r">
                        <span class="mr-4r">共计<b class="magenta-color"> @{{ count }} </b>件商品，总重量 <b class="magenta-color">0.00</b> kg</span>
                        <span class="mr-4r">商品总金额：@{{ total_money }} - 商品优惠：@{{ discount_money }} + 运费: @{{ freight }} = @{{pay_money}}</span>
                        <span class="mr-2r">实付：<b class="magenta-color">@{{pay_money}}</b></span>
                    </div>
                </div>
            </div>
            <div class="scrollspy">
                <div class="col-sm-12">    
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>商品图</th>
                                <th>SKU编码</th>
                                <th>商品名称</th>
                                <th>属性</th>
                                <th>平台商品名 属性</th>
                                <th>零售价</th>
                                <th>数量</th>
                                <th>优惠</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody id="order_sku">
                            @{{ #order_sku }}
                            <tr>
                                <td>
                                    <img src="@{{path}}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;">
                                </td>
                                <td>@{{ sku_number }}</td>
                                <td>
                                    @{{#status}}[赠品]@{{/status}}@{{ name }}
                                </td>
                                <td>@{{ mode }}</td>
                                <td>@{{ sku_name }}</td>
                                <td>@{{ price }}</td>
                                <td>@{{ quantity }}</td>
                                <td>-@{{ discount }}</td>
                                <td>
                                    {{--<a href="#" data-toggle="modal" data-target="#addproduct" id="addproduct-button" value="@{{ sku_id }}">换货</a>--}}
                                </td>
                            </tr>
                            @{{ /order_sku }}
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
            
        <div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="gridSystemModalLabel">添加客户</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input id="sku_search_val" type="text" placeholder="SKU编码/商品名称" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                        <div class="mt-4r scrollt">
                            <div id="user-list"> 
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="gblack">
                                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                                            <th>商品图</th>
                                            <th>SKU编码</th>
                                            <th>商品名称</th>
                                            <th>属性</th>
                                            <th>库存</th>
                                        </tr>
                                    </thead>
                                    <tbody id="gift">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer pb-r">
                            <div class="form-group mb-0 sublock">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" id="choose-gift" class="btn btn-magenta">确定</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                  
        <form id="form-jyi" role="form" class="form-horizontal mt-2r" style="display:none;">
            <div class="form-group">
                <label class="col-sm-1 control-label">付款方式</label>
                <div class="col-sm-3">
                    <span class="form-text text-danger">@{{ payment_type }}</span>
                </div>
                
                <label class="col-sm-1 control-label">付款类型</label>
                <div class="col-sm-3">
                    <span class="form-text text-danger">网银</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-1 control-label">支付账号</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" disabled="disabled">
                </div>
                
                <label class="col-sm-1 control-label">付款时间</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" disabled="disabled">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-1 control-label">发票信息</label>
                <div class="col-sm-3">
                    <span class="form-text text-info">@{{ invoice_info }}</span>
                </div>
            </div>
        </form>
        
        <form id="form-beiz" role="form" class="form-horizontal mt-2r" style="display:none;">
            <div class="form-group">
                <label class="col-sm-1 control-label">买家备注</label>
                <div class="col-sm-9">
                    <textarea rows="3" class="form-control" disabled="disabled" id="buyer_summary">@{{ buyer_summary }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label">卖家备注</label>
                <div class="col-sm-9">
                    <textarea rows="3" class="form-control" id="seller_summary">@{{ seller_summary }}</textarea>
                </div>
            </div>
        </form>
        
        <div class="ptb-2r plr-2r bg-black">
            @{{#change_status}}<button type="submit" class="btn btn-magenta btn-sm mr-2r" id="ok">确认提交</button>@{{ /change_status }}
            <button type="submit" class="btn btn-default btn-sm" id="fold">收起</button>
        </div>
        
    </td>
</tr>
@{{ /order }}
</script>