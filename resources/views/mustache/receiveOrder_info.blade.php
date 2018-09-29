<script id="order-info-form" type="text-x-mustache-tmpl">
@{{ #order }}
<tr class="order-list">
    <td colspan="14" class="plr-0 pb-0">
        <div class="btn-group ptb-2r pl-2r" data-toggle="buttons">
            <label class="btn btn-default active" id="label-user">
                <input type="radio" id="user">收款单信息
            </label>
        </div>
        <form id="form-user" role="form" class="form-horizontal mt-2r">
            <input type="hidden" id="order_id" value="@{{id}}">

            <div class="form-group">
                <label class="col-sm-1 control-label">企业全称</label>
                <div class="col-sm-2">
                    <input validate="" showname="企业全称" type="text" class="form-control order" id="full_name" name="full_name" value="@{{full_name}}">
                </div>
                <label class="col-sm-1 control-label">统一社会信用代码</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="business_license_number" name="business_license_number" value="@{{ business_license_number }}">
                </div>
                <label class="col-sm-1 control-label">银行账号</label>
                <div class="col-sm-2">
                    <input validate="" type="text" class="form-control order" id="bank_number" name="bank_number" value="@{{ bank_number }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label">门店名称</label>
                <div class="col-sm-2">
                    <input validate="" type="text" class="form-control order" id="store_name" name="store_name" value="@{{store_name}}">
                </div>
                <label class="col-sm-1 control-label">门店联系人手机号</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="phone" name="phone" value="@{{ phone }}">
                </div>
                <label class="col-sm-1 control-label">门店联系人姓名</label>
                <div class="col-sm-2">
                    <input validate="" showname="" type="text" class="form-control order" id="name" name="name" value="@{{ name }}">
                </div>
            </div>

            <div class="form-group">

                <label class="col-sm-1 control-label">订单号</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="number" name="number" value="@{{ number }}">
                </div>

                <label class="col-sm-1 control-label">订单时间</label>
                <div class="col-sm-2">
                    <input validate="" showname="" type="text" class="form-control order" id="order_start_time" name="order_start_time" value="@{{ order_start_time }}">
                </div>

                <label class="col-sm-1 control-label">支付方式</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="payment_type" name="payment_type" value="@{{ payment_type }}">
                </div>

            </div>

             <div class="form-group">
                <label class="col-sm-1 control-label">支付时间</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="payment_time" name="payment_time" value="@{{ payment_time }}">
                </div>
                <label class="col-sm-1 control-label">订单金额</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control order mobile" id="total_money" name="total_money" value="@{{ total_money }}">
                </div>

                <label class="col-sm-1 control-label">支付凭证</label>
                 <a href="@{{img}}" target="_blank">
                 <img src="@{{image}}" alt="" class="img-thumbnail" style="width:150px">
                 </a>
     </div>
</form>


<div class="ptb-2r plr-2r bg-black">
  @{{#change_status}}<button type="submit" class="btn btn-magenta btn-sm mr-2r" id="ok">确认提交</button>@{{ /change_status }}
            <button type="submit" class="btn btn-magenta btn-sm" id="fold">
            <i class="glyphicon glyphicon-open"></i> 收起
            </button>
        </div>

    </td>
</tr>
@{{ /order }}
</script>