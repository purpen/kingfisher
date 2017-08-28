<script id="print-out-order-tmp" type="text-x-mustache-tmpl">
{{--打印出货单模板--}}
@{{#order}}
<div id="">

    <h3 class="text-center">太火鸟出库单</h3>
    <br>
    <div class="row">
        <div class="col-lg-4">收货人: @{{buyer_name}}</div>
        <div class="col-lg-4">手机: @{{ buyer_phone }}</div>
        <div class="col-lg-4">出货日期: @{{ order_send_time }}</div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">固定电话: @{{ buyer_tel }}</div>
        <div class="col-lg-4">订单编号: @{{ number }}</div>
    </div>
    <div class="row">
        <div class="col-lg-10">收货地址: @{{ buyer_province }} @{{ buyer_city }} @{{ buyer_address }}</div>
    </div>
    <br>
    <table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td>商品编号</td>
            <td>商品型号</td>
            <td>商品名称</td>
            <td>商品型号</td>
            <td>数量</td>
        </tr>
        @{{ #order_sku }}
        <tr>
            <td></td>
            <td>@{{ number }}</td>
            <td>@{{ sku_number }}</td>
            <td>@{{ name }}</td>
            <td>@{{ mode }}</td>
            <td>@{{ quantity }}</td>
        </tr>
        @{{ /order_sku }}
    </table>
    <br>
    <div class="row">
        <div class="col-lg-10">买家备注: @{{ buyer_summary }}</div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-10">卖家备注: @{{ seller_summary }}</div>
    </div>
</div>
 @{{ /order }}
</script>