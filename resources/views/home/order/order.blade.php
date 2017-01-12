@extends('home.base')

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
                @include('home.order.subnav')
            </div>
		</div>
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-8">
    				<div class="form-inline">
    					<div class="form-group">
    						<a href="{{ url('/order/create') }}" class="btn btn-white mr-2r">
    							<i class="glyphicon glyphicon-edit"></i> 创建订单
    						</a>
                            @if ($status == 5)
                            <button type="button" id="batch-verify" class="btn btn-success mr-2r">
                                <i class="glyphicon glyphicon-ok"></i> 审批
                            </button>
                            <button type="button" id="split_order" class="btn btn-warning mr-2r">
                                <i class="glyphicon glyphicon-wrench"></i> 拆单
                            </button>
                            @endif
                        
                            @if ($status == 8)
                            <button type="button" id="batch-reversed" class="btn btn-warning mr-2r">
                                <i class="glyphicon glyphicon-backward"></i> 反审
                            </button>
                            <button type="button" class="btn btn-success mr-2r" id="send-order">
                                <i class="glyphicon glyphicon-print"></i> 打印发货
                            </button>
                            @endif

    					</div>
    					<div class="form-group">
                            <button type="button" id="order-excel" class="btn btn-white mr-2r">
                                <i class="glyphicon glyphicon-arrow-up"></i> 导出
                            </button>
    						<button type="button" class="btn btn-white mr-2r">
    							<i class="glyphicon glyphicon-arrow-down"></i> 导入
    						</button>
    					</div>
    				</div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="datatable-length">
                        <select class="form-control selectpicker input-sm" name="per_page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="datatable-info ml-r">
                        条/页，显示 {{ $order_list->firstItem() }} 至 {{ $order_list->lastItem() }} 条，共 {{ $order_list->total() }} 条记录
                    </div>
                </div>
			</div>
			<div class="row scroll">
                <div class="col-md-12">
    				<table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th class="text-center"><input type="checkbox" id="checkAll"></th>
                                <th>
                                	<div class="dropdown">
                                		<button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                			<span class="title">提醒</span> 
                                			<span class="caret"></span>
                        				</button>
                        				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">提醒</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">退款</a>
                                            </li>
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">锁单</a>
                                            </li>
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">无法送达</a>
                                            </li>
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">货到付款</a>
                                            </li>
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">预售</a>
                                            </li>
                                        </ul>
                                	</div>
                                </th>
                                <th>
                                    状态
                                </th>
                                <th>
                                    店铺名
                                </th>
                                <th>订单号/下单时间</th>
                                <th>买家</th>
                                <th>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                            <span class="title">买家备注</span> 
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">有买家备注</a>
                                            </li>
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">无买家备注</a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                            <span class="title">卖家备注</span>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">有卖家备注</a>
                                            </li>
                                            <li role="lichoose">
                                                <a role="menuitem" tabindex="-1" href="javascript:void(0);">无卖家备注</a>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                                <th>
                                    物流/运单号
                                </th>
                                <th>
                                    数量
                                </th>
                                <th>实付/运费</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_list as $order)
                            <tr>
                                <td class="text-center">
                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="{{ $order->id }}">
                                </td>
                                <td></td>
                                <td>
                                    @if (in_array($order->status, array(0)))
                                    <span class="label label-default">{{$order->status_val}}</span>
                                    @endif
                                
                                    @if (in_array($order->status, array(1,5,8)))
                                    <span class="label label-danger">{{$order->status_val}}</span>
                                    @endif
                                
                                    @if (in_array($order->status, array(10,20)))
                                    <span class="label label-success">{{$order->status_val}}</span>
                                    @endif
                                </td>
                                <td>{{$order->store->name}}</td>
                                <td class="magenta-color">
                                    <span>{{$order->number}}</span><br>
                                    <small class="text-muted">{{$order->order_start_time}}</small>
                                </td>
                                <td>{{$order->buyer_name}}</td>
                                <td>{{$order->buyer_summary}}</td>
                                <td>{{$order->seller_summary}}</td>
                                <td>
                                    <span>{{$order->logistics->name}}</span><br>
                                    <small class="text-muted">{{$order->express_no}}</small>
                                </td>
                                <td>{{$order->count}}</td>
                                <td>{{$order->pay_money}} / {{$order->freight}}</td>
                                <td tdr="nochect">
                                    <button class="btn btn-gray btn-sm show-order mb-2r" type="button" value="{{$order->id}}" active="1">
                                        <i class="glyphicon glyphicon-eye-open"></i> 查看
                                    </button>
                                    @role(['admin','director','shopkeeper'])
                                        @if ($order->type != 3)
                                        <button value="{{$order->id}}" class="btn btn-default btn-sm delete-order mb-2r">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                        @endif
                                    @endrole

                                    @if ($status == 8)
                                        <button type="button" class="btn btn-success btn-sm manual-send" value="{{$order->id}}">
                                            <i class="glyphicon glyphicon-hand-right"></i> 手动发货
                                        </button>
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
                <div class="col-md-12 text-center">{!! $order_list->appends(['number' => $name])->render() !!}</div>
            </div>
            @endif
		</div>
	</div>

    {{--手动发货弹出框--}}
    @include('modal.add_manual_send_modal')

    @include('mustache.order_info')
    {{--拆单弹出框--}}
    @include('modal.add_split_order')
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
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
    // 发货
    {{--$('#send-order1').click(function() {
        if (!$("input[name='Order']:checked").size()) {
            alert('请选择需发货的订单!');
            return false;
        }
        $("input[name='Order']:checked").each(function() {
            var order_id = $(this).val();
            var obj = $(this).parent().parent();
            
            $.post('{{url('/order/ajaxSendOrder')}}', {'_token': _token, 'order_id': order_id}, function(e) {
                if (e.status) {
                    PrintTemplate = e.data;

                    console.log(PrintTemplate);
                    
                    startPrint();
                    
                    obj.remove();
                } else {
                    alert(e.data);
                }
            }, 'json');
        });
    });
    
    function preview(){
        CreateOneFormPage();
        LODOP.PREVIEW();
    }
    function startPrint() {
        CreateOneFormPage();
        LODOP.PRINT();
    }
    function manage() {
        CreateTwoFormPage();
        LODOP.PRINT_SETUP();
    }

    function CreateOneFormPage() {
        LODOP = getLodop();
        LODOP.PRINT_INIT("太火鸟发货单");
        
        LODOP.SET_PRINT_STYLE("FontSize", 18);
        LODOP.SET_PRINT_STYLE("Bold", 1);
        LODOP.SET_PRINT_PAGESIZE(3, 1000, 1000, "");//动态纸张
        LODOP.ADD_PRINT_TEXT(50, 231, 260, 39, "打印页面部分内容");
        LODOP.ADD_PRINT_HTM(0, 0, "100%", "100%", PrintTemplate);
    };--}}

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
    }




            {{--表示webSocket是否连接成功--}}
    var isConnect = 0;
            {{--webSocket 连接实例--}}
    var socket = null;
    {{--连接打印机--}}
    function doConnect()
    {
        var printer_address = '127.0.0.1:13528';
        socket = new WebSocket('ws://' + printer_address);
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
        };
    }

    {{--网页加载就绪 连接本地打印机--}}
    $(doConnect());

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
    }


@endsection


@section('load_private')
    @parent

    {{--拆单弹出框--}}
    $("#split_order").click(function () {
        var id;
        $("input[name='Order']").each(function() {
            if($(this).is(':checked')){
                id = $(this).attr('value');
                return false;
            }
        });

        $.get("{{url('/order/ajaxEdit')}}",{'id': id},function (e) {
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
        },'json');
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
    $.get('{{url('/order/ajaxEdit')}}',{'id':id},function (e) {
    if(e.status){
    var template = $('#order-info-form').html();
    var views = Mustache.render(template, e.data);

    order.after(views);

    obj.attr("active", 0);

    // 选择赠品列表
    $("#addproduct-button").click(function(){
        var storage_id = $('#storage_id').val();
        $.get('{{url('/order/ajaxSkuList')}}',{'id':storage_id},function(e) {
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
                for(i in e.responseText){
                    var message = e.responseText[i][0];
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
        var order = [];
        $("input[name='Order']").each(function() {
            if($(this).is(':checked')){
                order.push($(this).attr('value'));
            }
        });
        $.post('{{url('/order/ajaxVerifyOrder')}}',{'_token': _token,'order': order}, function(e) {
            if(e.status){
                location.reload();
            }else{
                alert(e.message);
            }
        },'json');
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

    $('#send-order').click(function () {
        if (!$("input[name='Order']:checked").size()) {
            alert('请选择需发货的订单!');
            return false;
        }
        if(isConnect == 0){
            alert('未连接打印客户端，请刷新重试');
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

        {{--location.reload();--}}
    });

@endsection