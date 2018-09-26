@extends('home.base')

@section('partial_css')
    @parent
    <link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection

@section('customize_css')
    @parent
    #form-user,#form-product,#form-jyi,#form-beiz {
    height: 245px;
    margin-bottom: 10px;
    overflow-x: hidden;
    overflow-y: scroll;
    padding-top: 10px;
    }
    .scrollspy{
    height:180px;
    overflow: scroll;
    margin-top: 10px;
    }
    .table{
    width: 100%;
    border-collapse:collapse;
    border-spacing:0;
    }
    .fixedThead{
    display: block;
    width: 100%;
    }
    .scrollTbody{
    display: block;
    height: 300px;
    overflow: auto;
    width: 100%;
    }
    .table td,.table th {
    width: 200px;
    border-bottom: none;
    border-left: none;
    border-right: 1px solid #CCC;
    border-top: 1px solid #DDD;
    padding: 2px 3px 3px 4px
    }
    .table tr{
    border-left: 1px solid #EB8;
    border-bottom: 1px solid #B74;
    }
    .loading{
    width:160px;
    height:56px;
    position: absolute;
    top:50%;
    left:50%;
    line-height:56px;
    color:#fff;
    padding-left:60px;
    font-size:15px;
    background: #000 url(images/loader.gif) no-repeat 10px 50%;
    opacity: 0.7;
    z-index:9999;
    -moz-border-radius:20px;
    -webkit-border-radius:20px;
    border-radius:20px;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
    }
@endsection

@section('content')
    @parent
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    订单查询
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.invoice.subnav')
            </div>
        </div>
        <div id="down-print" class="container row" style="background-color: wheat;" hidden>
            <div class="col-md-12">
                <h4> 未连接打印客户组件，请启动打印组件，刷新重试。
                    {{--href="http://www.cainiao.com/markets/cnwww/print"--}}
                    <a  style="color: red;" target="_blank" href="">点击下载打印组件</a>
                </h4>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-8">

                </div>

                <div class="col-md-4 text-right">
                       <form id="per_page_from" action="{{ url('/invoice/lists') }}" method="POST">
                                                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                                                    <div class="datatable-length">
                                                        <select class="form-control selectpicker input-sm per_page" name="per_page">
                                                            <option @if($per_page == 10) selected @endif value="10">10</option>
                                                            <option @if($per_page == 25) selected @endif value="25">25</option>
                                                            <option @if($per_page == 50) selected @endif value="50">50</option>
                                                            <option @if($per_page == 100) selected @endif value="100">100</option>
                                                        </select>
                                                    </div>
                                                    <div class="datatable-info ml-r">
                                                        条/页，显示 {{ $order_list->firstItem() }} 至 {{ $order_list->lastItem() }} 条，共 {{ $order_list->total() }} 条记录
                                                    </div>
                                                </form>
                </div>
                 </div>
            <div id="loading" class="loading" style="display: none;">Loading...</div>

            <div class="row scroll">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                             <th>
                                订单状态
                            </th>
                            <th>
                                门店名称
                            </th>
                            <th>订单号</th>
                            <th>下单时间</th>
                            <th>
                                 发票申请时间
                            </th>
                            <th>
                               发票状态
                            </th>
                            <th>
                               发票类型
                            </th>
                            <th>
                                收货人
                            </th>
                            <th>物流/运单号</th>
                            <th>商品数量</th>
                            <th>总金额</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_list as $order)
                            <tr>

                                <td>
                                    @if (in_array($order->status, array(0)))
                                        <span class="label label-default">{{$order->status_val}}</span>
                                    @endif

                                    @if (in_array($order->status, array(1,5,6,8)))
                                        <span class="label label-danger">{{$order->status_val}}</span>
                                    @endif

                                    @if (in_array($order->status, array(10,20)))
                                        <span class="label label-success">{{$order->status_val}}</span>
                                    @endif
                                </td>
                                <td>{{$order->company_name ? $order->company_name : ''}}</td>
                                <td>{{$order->number ? $order->number: ''}}</td>
                                <td >
                                    {{$order->order_start_time}}
                                </td>
                                <td>{{$order->application_time}}</td>
                                <td>
                                    @if ($order->receiving_type == 1)
                                        <span class="label label-danger">未开票</span>
                                    @endif
                                        @if ($order->receiving_type == 2)
                                            <span class="label label-success">审核中</span>
                                        @endif
                                        @if ($order->receiving_type == 3)
                                            <span class="label label-success">已开票</span>
                                        @endif
                                        @if ($order->receiving_type == 4)
                                            <span class="label label-danger">拒绝</span>
                                        @endif
                                        @if ($order->receiving_type == 5)
                                            <span class="label label-danger">已过期</span>
                                        @endif
                                </td>
                                <td>
                                    @if ($order->receiving_id == 0)
                                        <span class="label label-danger">未开票</span>
                                    @endif
                                    @if ($order->receiving_id == 1)
                                        <span class="label label-success">增值税普通发票</span>
                                    @endif
                                        @if ($order->receiving_id == 2)
                                            <span class="label label-success">增值税专用发票</span>
                                        @endif
                                </td>
                                <td>{{$order->receiving_name}}</td>
                                <td>
                                    <span>{{$order->logistics ? $order->logistics->name : ''}}</span><br>
                                    <small class="text-muted" style="font-size:13px;">{{$order->express_no}}</small>
                                </td>
                                <td>{{$order->count}}</td>
                                <td>{{$order->total_money}} / {{$order->freight}}</td>
                                <td tdr="nochect">
                                    <button class="btn btn-gray btn-sm show-order mb-2r" type="button" value="{{$order->id}} ? {{$order->invoice_id}}" active="1">
                                        <i class="glyphicon glyphicon-eye-open"></i> 查看
                                    </button>
                                    @role(['admin','director','shopkeeper'])
                                    @if ($order->type != 3)

                                    @endif
                                    @endrole

                                    @if ($status == 8)
                                        {{--<button type="button" class="btn btn-success btn-sm manual-send" value="{{$order->id}}">
                                            <i class="glyphicon glyphicon-hand-right"></i> 手动发货
                                        </button>--}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order_list)
                <div class="row">
                    <div class="col-md-12 text-center">{!! $order_list->appends([   'number' => $name,
                                                                                'per_page' => $per_page ,

                                                                                  ])->render() !!}</div>
                </div>
            @endif
        </div>
    </div>

    @include('mustache.invoice_info')

    <script language="javascript" src="{{url('assets/Lodop/LodopFuncs.js')}}"></script>
    <object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
        <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
    </object>
@endsection

@section('customize_js')
    @parent

    function myFunction() {
    layer.open({
    type: 1 //Page层类型
    ,area: ['500px', '280px']
    ,title: '拒绝理由'
    ,shade: 0.2 //遮罩透明度
    ,maxmin: false //允许全屏最小化
    ,anim: 2 //0-6的动画形式，-1不开启
    ,content: "<form style='margin-left:20px;margin-top:20px;'><textarea id='invoiceTextarea' rows='8' cols='60' name='reason'></textarea><br><input style='margin-top:10px;' type='submit' value='提交' class='btn btn-magenta btn-sm mr-3r' onclick='invoiceFunction()'></form>"
    });
    }
    function invoiceFunction(){

    var textarea = $('#invoiceTextarea').val();
    if(!textarea){
    layer.alert('驳回理由为空');
    return false;
    }
    var order_id = $('#hiddenOrder_id').val();
    var invoice_id = $('#hiddenInvoice_id').val();

    $.get("/invoice/rejected?reason="+textarea+"&id="+order_id+"&invoice_id="+invoice_id, function(data){
    if(data == 200){
    layer.alert('修改成功');
    }else if(data == 500){
    layer.alert('修改失败');
    location=location;
    }
    });

    }
    $('.active').removeClass('active');
    var _token = $('#_token').val();

    var PrintTemplate;
    var LODOP; // 声明为全局变量

    {{--父订单信息--}}
    var order_data = '';
    {{--子订单信息--}}
    var new_data = [];
    {{--子订单排序--}}
    var count = 1;
    {{--是否可以提交订单 0：否 1：可以--}}
    var split_status = 0;

    {{--post请求--}}
    function post(URL, PARAMS) {
    var temp = document.createElement("form");
    temp.action = URL;
    temp.method = "post";
    temp.style.display = "none";
    var opt = document.createElement("textarea");
    opt.name = '_token';
    opt.value = _token;
    temp.appendChild(opt);
    for (var x in PARAMS) {
    var opt = document.createElement("textarea");
    opt.name = x;
    opt.value = PARAMS[x];
    // alert(opt.name)
    temp.appendChild(opt);
    }
    document.body.appendChild(temp);
    temp.submit();
    return temp;
    };

    {{--表示webSocket是否连接成功--}}
    var isConnect = 0;
    {{--webSocket 连接实例--}}
    var socket = null;

    {{--连接打印机--}}
    function doConnect()
    {
    var printer_address = '127.0.0.1:13528';
    socket = new WebSocket('ws://' + printer_address);
    {{--if (socket.readyState == 0) {--}}
    {{--return false;--}}
    {{--alert('WebSocket连接中...');--}}
    {{--}--}}
    {{--打开Socket--}}
    socket.onopen = function(event)
    {
    isConnect = 1;
    console.log("Websocket准备就绪,连接到客户端成功");
    };
    {{--监听消息--}}
    socket.onmessage = function(event)
    {
    console.log('Client received a message',event);
    var data = JSON.parse(event.data);
    if("print" == data.cmd && "success" != data.status){
    console.log('打印信息发送至打印机出错');
    }
    };

    {{--监听Socket的关闭--}}
    socket.onclose = function(event)
    {
    isConnect = 0;
    console.log('Client notified socket has closed',event);
    };

    socket.onerror = function(event) {
    isConnect = 0;
    console.log('onerror',event);
    };
    };

    {{--传输电子面单数据至打印组件--}}
    function doPrint(waybillNO,data)
    {
    var printTaskId = parseInt(1000*Math.random());

    request  = {
    cmd : "print",
    requestID : ''+waybillNO,
    version : "1.0",
    task : {
    taskID : ''+printTaskId,
    preview : false,
    printer : '',
    documents : [
    {
    "documentID": ''+waybillNO,
    contents : [
    $.parseJSON( data )
    ]
    }
    ]
    }
    };
    console.log(request);
    socket.send(JSON.stringify(request));
    };

    /*搜索下拉框*/
    $(".chosen-select").chosen({
    no_results_text: "未找到：",
    search_contains: true,
    width: "100%",
    });
@endsection


@section('load_private')
    @parent
    {{--<script>--}}
    {{--拆单弹出框--}}
    $("#split_order").click(function () {
    var id;
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    id = $(this).attr('value');
    return false;
    }
    });

    $.get("{{url('/invoice/ajaxEdit')}}",{'id': id},function (e) {
    if(e.status == -1){
    alert(e.msg);
    }else if(e.status == 0){
    alert(e.message);
    }else if(e.status == 1){
    var template = $('#split_order_list').html();
    var views = Mustache.render(template, e.data);
    $("#append_split_order").html(views);
    order_data = e.data;
    new_data = [];
    count = 1;
    }
    }, 'json');

    $("#new_order").html('');

    $("#add_split_order").modal('show');
    });

    {{--拆单按钮--}}
    $("#split_button").click(function () {
    var arr_id = [];

    if($("input[name='split_order']:checked").length == $("input[name='split_order']").length){
    alert('原订单不能为空');
    return false;
    }

    $("input[name='split_order']").each(function() {
    if($(this).is(':checked')){
    arr_id.push(parseInt($(this).attr('value')));
    $(this).parent().parent().remove();
    }
    });
    if(arr_id.length == 0){
    return false;
    }

    new_data.push({'order_id':order_data.order.id, 'number':order_data.order.number+'-'+count, 'arr_id':arr_id});

    var split_data = {'number':'', 'order_sku':[]};
    split_data.number = order_data.order.number+'-'+count;
    for (var i=0;i < order_data.order_sku.length;i++){
    console.log(order_data.order_sku[i].id);
    if(jQuery.inArray(parseInt(order_data.order_sku[i].id),arr_id) != -1){
    split_data.order_sku.push(order_data.order_sku[i]);
    }
    }
    console.log(split_data);
    var template = $('#new_order_list').html();
    var views = Mustache.render(template, split_data);
    $("#new_order").append(views);

    count = count+1;
    split_status = 1;
    });


    {{--拆单提交--}}
    $("#split_order_true").click(function () {
    if(split_status != 1){
    alert('未拆单，不能提交');
    return false;
    }

    $.post('{{url('/order/splitOrder')}}',{'_token': _token,'data':new_data},function (e) {
    if(e.status == 0){
    alert(e.message);
    }else if(e.status == 1){
    location.reload();
    }else if(e.status == -1){
    alert(e.msg);
    }
    },'json');
    });

    {{--显示手动发货弹窗--}}
    $(".manual-send").click(function () {
    var order_id = $(this).attr('value');
    $("#manual-send-order-id").val(order_id);
    $("#add-manual-send").modal('show');
    });

    {{--提交手动发货--}}
    $("#manual-send-goods").click(function () {
    var order_id = $("#manual-send-order-id").val();
    var logistics_id = $("#logistics_id").val();
    var logistics_no = $("#logistics_no").val();
    if(order_id == ''){
    alert('订单ID获取异常');
    return false;
    }
    if(logistics_id == ''){
    alert('请选择物流');
    return false;
    }
    var regobj = new RegExp("^[0-9]*$");
    if(logistics_no == '' || !regobj.test(logistics_no)){
    alert('物流单号格式不正确');
    return false;
    }
    $.post('{{url('/order/ajaxSendOrder')}}',{'_token': _token,'order_id': order_id,'logistics_id': logistics_id, 'logistics_no': logistics_no, 'logistics_type': 'true'}, function (e) {

    if(e.status){
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    });


    $(".show-order").click(function() {
    var skus = [];
    $(".order-list").remove();
    var order = $(this).parent().parent();
    var obj = $(this);
    if ($(this).attr("active") == 1) {
    var id = $(this).attr("value");
    var ids = id.split("?");
    var order_id = ids[0];
    var invoice_id = ids[1];
    console.log(order_id)
    console.log(invoice_id)
    $.get('{{url('/invoice/ajaxEdit')}}',{'id':order_id,'invoice_id':invoice_id},function (e) {

    if(e.status){
    var template = $('#order-info-form').html();
    var views = Mustache.render(template, e.data);

    order.after(views);

    obj.attr("active", 0);

    // 选择赠品列表
    $("#addproduct-button").click(function(){
    var storage_id = $('#storage_id').val();
    var user_id_sales = $('#user_id_sales').val();
    $.get('{{url('/order/ajaxSkuList')}}',{'id':storage_id, 'user_id_sales':user_id_sales},function(e) {
    if(e.data){
    template = ['@{{#data}}<tr>',
        '<td class="text-center">',
            '<input name="Order" class="sku-order" type="checkbox" active="0" value="1" id="@{{id}}">',
            '</td>',
        '<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
        '<td>@{{ number }}</td>',
        '<td>@{{ name }}</td>',
        '<td>@{{ mode }}</td>',
        '<td>@{{ count }}</td>',
        '</tr>@{{/data}}'].join("");
    var views = Mustache.render(template, e);
    $('#gift').html(views);
    sku_data = e.data;
    }else{
    alert('参数错误');
    }
    },'json');

    $("#sku_search").click(function () {
    var where = $("#sku_search_val").val();
    if(where == '' || where == undefined ||where == null){
    alert('未输入内容');
    return false;
    }
    $.get('{{url('/order/ajaxSkuSearch')}}',{'storage_id':storage_id, 'where':where},function (e) {
    if (e.status){
    template = ['@{{#data}}<tr>',
        '<td class="text-center">',
            '<input name="Order" class="sku-order" type="checkbox" active="0" value="1" id="@{{id}}">',
            '</td>',
        '<td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
        '<td>@{{ number }}</td>',
        '<td>@{{ name }}</td>',
        '<td>@{{ mode }}</td>',
        '<td>@{{ count }}</td>',
        '</tr>@{{/data}}'].join("");
    var views = Mustache.render(template, e);
    sku_data = e.data;
    $("#gift").html(views);
    console.log(e);
    }
    },'json');
    });
    });

    $("#choose-gift").click(function () {
    skus = [];
    var sku_tmp = [];
    $(".sku-order").each(function () {
    if($(this).is(':checked')){
    sku_tmp.push(parseInt($(this).attr('id')));
    }
    });
    for (var i=0;i < sku_data.length;i++){
    if(jQuery.inArray(parseInt(sku_data[i].id),sku_tmp) != -1){
    skus.push(sku_data[i]);
    }
    }
    var template = ['@{{ #skus }}<tr>',
        '<td><img src="@{{path}}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
        '<td>@{{ number }}</td>',
        '<td>@{{ name }}</td>',
        '<td>@{{ mode }}</td>',
        '<td>@{{ price }}</td>',
        '<td>1</td>',
        '<td>-@{{ price }}</td>',
        '<td><a href="#" id="delete_gift" value="@{{ sku_id }}">删除</a></td>',
        '</tr>@{{ /skus }}'].join("");
    var data = {};
    data['skus'] = skus;
    var views = Mustache.render(template, data);
    console.log(views);
    $("#order_sku").append(views);
    $("#addproduct").modal('hide');

    $("#delete_gift").click(function () {
    $(this).parent().parent().remove();
    });
    });

    {{--收回详情--}}
    $("#fold").click(function () {
    $(".order-list").remove();
    obj.attr("active",1);
    });

    {{--更改订单信息--}}
    $("#ok").click(function () {
    var order_id = $("#order_id").val();
    var buyer_name = $("#buyer_name").val();
    var buyer_tel = $("#buyer_tel").val();
    var buyer_phone = $("#buyer_phone").val();
    var express_id = $("#express_id").val();
    var storage_id = $("#storage_id").val();
    var buyer_address = $("#buyer_address").val();
    var buyer_zip = $("#buyer_zip").val();
    var seller_summary = $("#seller_summary").val();
    var buyer_summary = $("#buyer_summary").val();
    var buyer_province = $("#buyer_province").val();
    var buyer_city = $("#buyer_city").val();
    var buyer_county = $("#buyer_county").val();
    $.ajax({
    type: "POST",
    url: "{{url('/order/ajaxUpdate')}}",
    data:{'_token': _token, 'order_id': order_id, 'buyer_name': buyer_name, 'buyer_tel': buyer_tel,'buyer_phone': buyer_phone,'express_id': express_id,'storage_id': storage_id,'buyer_address': buyer_address,'buyer_zip': buyer_zip,'seller_summary': seller_summary,'buyer_summary': buyer_summary,'buyer_province':buyer_province,'buyer_city':buyer_city,'buyer_county':buyer_county},
    dataType: "json",
    success: function (e) {
    if(!e.status){
    alert(e.message);
    }else{
    $(".order-list").remove();
    obj.attr("active",1);
    location.reload();
    }
    },
    error: function (e) {
    console.log(e);
    for(i in e.responseJSON){
    var message = e.responseJSON[i][0];
    break;
    }
    alert(message);
    }
    });
    });

    }else{
    alert(e.message);
    return false;
    }
    },'json');
    }else{
    $(".order-list").remove();
    $(this).attr("active",1);
    }

    });


    $('.delete-order').click(function () {
    if(confirm('确认删除该订单？')){
    var order_id = $(this).attr('value');
    var delete_obj = $(this).parent().parent();
    $.post('{{url('/order/ajaxDestroy')}}',{'_token': _token, 'order_id': order_id},function (e) {
    if(e.status){
    delete_obj.remove();
    }else if(e.status == -1){
    alert(e.msg);
    }else{
    alert(e.message);
    }
    },'json');
    }
    });

    // 反审
    $('#batch-reversed').click(function() {
    var order = [];
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    order.push($(this).attr('value'));
    }
    });
    $.post('{{url('/order/ajaxReversedOrder')}}',{'_token': _token,'order': order}, function(e) {
    if(e.status){
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    });

    // 审单
    $('#batch-verify').click(function () {
    layer.confirm('确认要通过审批吗？',function(index){
    var order = [];
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    order.push($(this).attr('value'));
    }
    });
    $.post('{{url('/order/ajaxVerifyOrder')}}',{'_token': _token,'order': order}, function(e) {
    if(e.status){
    layer.msg('操作成功！');
    location.reload();
    }else{
    alert(e.message);
    }
    },'json');
    });
    });

    {{--打印订单excel--}}
    $("#order-excel").click(function () {
    var id_array = [];
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    id_array.push($(this).attr('value'));
    }
    });
    post('{{url('/excel')}}',id_array);
    });

    $('#send-order1').click(function () {
    if (!$("input[name='Order']:checked").size()) {
    alert('请选择需发货的订单!');
    return false;
    }
    if(isConnect == 0){
    $('#down-print').show();
    return false;
    }
    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    var order_id = $(this).val();
    var obj = $(this).parent().parent();
    $.post('{{url('/order/ajaxSendOrder')}}',{'_token': _token,'order_id': order_id}, function (e) {

    if(e.status){
    var waybillNO = e.data.waybillNO;
    var data = e.data.printData;
    console.log(data);
    doPrint(waybillNO,data);
    obj.remove();
    }else{
    alert(e.message);
    }
    },'json');
    }

    });
    });

    $('.per_page').change(function () {
    $("#per_page_from").submit();
    });
    $("#in_order").click(function () {
    $("#addfile").modal('show');
    });
    {{--$("#zc_order").click(function () {--}}
    {{--$("#addzcfile").modal('show');--}}
    {{--$('#ajax_test2').click(function(){--}}
    {{--var loading=document.getElementById("loading");--}}
    {{--if (loading.style.display=='none') {--}}
    {{--$("#addzcfile").modal('hide');--}}
    {{--loading.style.display='block';--}}
    {{--}--}}

    {{--});--}}
    {{--});--}}
    $("#contacts_order").click(function () {
    $("#addcontactsfile").modal('show');
    });
    {{--高级搜索显示--}}
    var showSeniorSearch=document.getElementById("showSeniorSearch");
    $("#seniorSearch").click(function () {
    if (showSeniorSearch.style.display=='none') {
    showSeniorSearch.style.display='block';
    }
    });

    {{--网页加载就绪 连接本地打印机--}}





    {{--快递鸟打印--}}
    function doConnectKdn() {
    {{--try{--}}
    {{--var LODOP=getLodop();--}}
    {{--if (LODOP.VERSION) {--}}
    {{--isConnect = 1;--}}
    {{--console.log('快递鸟打印控件已安装');--}}
    {{--};--}}
    {{--}catch(err){--}}
    {{--console.log('快递鸟打印控件连接失败' + err);--}}
    {{--}--}}
{{--=======--}}
        try{

            doConnect();
            var LODOP=getLodop();
            if (LODOP.VERSION) {
                isConnect = 1;
                console.log('快递鸟打印控件已安装');
            };
        }catch(err){
            {{--console.log('快递鸟打印控件连接失败' + err);--}}
        }
    };

    $('#send-order').click(function () {
    {{--加载本地lodop打印控件--}}
    doConnectKdn();
    if(isConnect == 0){
    $('#down-print').show();
    return false;
    }

    if (!$("input[name='Order']:checked").size()) {
    alert('请选择需发货的订单!');
    return false;
    }

    $("input[name='Order']").each(function () {
    if($(this).is(':checked')){
    var order_id = $(this).val();
    var obj = $(this).parent().parent();
    $.post('{{url('/order/ajaxSendOrder')}}',{'_token': _token,'order_id': order_id}, function (e) {

    if(e.status){
    var waybillNO = e.data.waybillNO;
    var data = e.data.printData;
    console.log(data);
    LODOP.PRINT_INIT("快递单");
    LODOP.ADD_PRINT_HTM(0,0,"100%","100%",data);
    LODOP.PRINT();
    obj.remove();
    }else{
    alert(e.message);
    }
    },'json');
    }

    });
    });

    {{--单机物流订单导入事件--}}
    $("#logistics_order").click(function () {
    $("#add_logistics_file").modal('show');
    });

    $("#supplier-order-excel").click(function () {
    $("#supplierOrderOutModal").modal('show');
    });

    $("#supplierOrderOutSubmit").click(function () {
    var formData = new FormData($('#supplierOrderOutForm')[0]);
    if(formData.get('supplier_id') == ''){
    alert("供应商不能为空");
    return;
    }
    if(formData.get('start_date') == ''){
    alert("开始时间不能为空");
    return;
    }
    if(formData.get('end_date') == ''){
    alert("结束时间不能为空");
    return;
    }
    formData.append('request_type', 'get');
    $.ajax({
    url : "{{ url('/getDaiFaSupplierData') }}",
    type : 'POST',
    dataType : 'json',
    data : formData,
    // 告诉jQuery不要去处理发送的数据
    processData : false,
    // 告诉jQuery不要去设置Content-Type请求头
    contentType : false,
    success : function(e) {
    loading.style.display = 'none';
    var data = e.data;
    if(e.status == 1){
    $('#supplierOrderOutForm').submit();
    {{--$("#supplierOrderOutModal").modal('hide');--}}
    }else if(e.status == -1){
    alert(e.msg);
    }else{
    console.log(e.message);
    alert(e.message);
    }
    },
    error : function(e) {
    alert('网络请求出错');
    }
    });
    });

    $('#supplier-order-excel-input').click(function () {
    $("#daiFaSupplierInputSuccess").text(0);
    $("#daiFaSupplierInputError").text(0);
    $("#daiFaSupplierInputMessage").val('');
    $('#daiFaSupplierInputReturn').hide();
    $("#supplierOrderInput").modal('show');
    });

    $("#supplierOrderInputSubmit").click(function () {
    var formData = new FormData($("#daiFaSupplierInput")[0]);

    var daiFaSupplierInputSuccess = $("#daiFaSupplierInputSuccess");
    var daiFaSupplierInputError = $("#daiFaSupplierInputError");
    var daiFaSupplierInputMessage = $("#daiFaSupplierInputMessage");

    $.ajax({
    url : "{{ url('/daiFaSupplierInput') }}",
    type : 'POST',
    dataType : 'json',
    data : formData,
    // 告诉jQuery不要去处理发送的数据
    processData : false,
    // 告诉jQuery不要去设置Content-Type请求头
    contentType : false,
    beforeSend:function(){
    var loading=document.getElementById("loading");
    loading.style.display = 'block';
    console.log("正在进行，请稍候");
    },
    success : function(e) {
    loading.style.display = 'none';
    var data = e.data;
    if(e.status == 1){
    daiFaSupplierInputSuccess.text(data.success_count);
    daiFaSupplierInputError.text(data.error_count);
    daiFaSupplierInputMessage.val(data.error_message);
    $('#daiFaSupplierInputReturn').show();
    }else if(e.status == -1){
    alert(e.msg);
    }else{
    console.log(e.message);
    alert(e.message);
    }
    },
    error : function(e) {
    alert('导入文件错误');
    }
    });
    });


    $("#distributor-order-excel").click(function () {
    $("#distributorOrderOutModal").modal('show');
    });

    $("#distributorOrderOutSubmit").click(function () {
    $("#distributorOrderOutModal").modal('hide');
    });

    $("#distributor-order-excel-input").click(function () {
    $("#quDaoDistributorInputSuccess").text(0);
    $("#quDaoDistributorInputError").text(0);
    $("#quDaoDistributorInputMessage").val('');
    $('#quDaoDistributorReturn').hide();
    $("#distributorOrderInputModal").modal('show');
    });

    $("#distributorExcelSubmit").click(function () {
    {{--var loading=document.getElementById("loading");--}}
    {{--if (loading.style.display=='none') {--}}
    {{--$("#distributorOrderInputModal").modal('hide');--}}
    {{--loading.style.display='block';--}}
    {{--}--}}
    var formData = new FormData($("#distributorInput")[0]);

    var quDaoDistributorInputSuccess = $("#quDaoDistributorInputSuccess");
    var quDaoDistributorInputError = $("#quDaoDistributorInputError");
    var quDaoDistributorInputMessage = $("#quDaoDistributorInputMessage");

    $.ajax({
    url : "{{ url('/quDaoDistributorInput') }}",
    type : 'POST',
    dataType : 'json',
    data : formData,
    // 告诉jQuery不要去处理发送的数据
    processData : false,
    // 告诉jQuery不要去设置Content-Type请求头
    contentType : false,
    beforeSend:function(){
    var loading=document.getElementById("loading");
    loading.style.display = 'block';
    console.log("正在进行，请稍候");
    },
    success : function(e) {
    loading.style.display = 'none';
    var data = e.data;
    if(e.status == 1){
    quDaoDistributorInputSuccess.text(data.success_count);
    quDaoDistributorInputError.text(data.error_count);
    quDaoDistributorInputMessage.val(data.error_message);
    $('#quDaoDistributorReturn').show();
    }else if(e.status == -1){
    alert(e.msg);
    }else{
    console.log(e.message);
    alert(e.message);
    }
    },
    error : function(e) {
    alert('导入文件错误');
    }
    });
    });


@endsection