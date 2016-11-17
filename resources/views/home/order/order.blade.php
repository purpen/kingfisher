@extends('home.base')

@section('customize_css')
    @parent
    .bnonef {
    	padding:0;
    	box-shadow:none !important; 
    	background:none;
    	color:#fff !important;
    }
    #form-user,#form-product,#form-jyi,#form-beiz {
        height: 225px;
        overflow: scroll;
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
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						订单查询
					</div>
				</div>
                <div class="navbar-collapse collapse">
                    @include('home.order.subnav')
                </div>
			</div>
		</div>
		<div class="container mainwrap">
			<div class="row">
				<div class="form-inline">
					<div class="form-group mr-2r">
						<a href="{{ url('/order/create') }}" class="btn btn-white">
							<i class="glyphicon glyphicon-edit"></i> 创建订单
						</a>
                        @if ($status == 5)
                        <button type="button" id="batch-verify" class="btn btn-white mlr-2r">
                            <i class="glyphicon glyphicon-ok"></i> 批量审批
                        </button>
                        @endif
                        
                        @if ($status == 8)
                        <button type="button" id="batch-reversed" class="btn btn-white mlr-2r">
                            <i class="glyphicon glyphicon-arrow-left"></i> 批量反审
                        </button>
                        <button type="button" class="btn btn-success" id="send-order">
                            <i class="glyphicon glyphicon-print"></i> 打印发货
                        </button>
                        @endif
                        
                        @if ($status <= 5)
                        <button type="button" id="batch-closed" class="btn btn-white">
                            <i class="glyphicon glyphicon-ban-circle"></i> 关闭订单
                        </button>
                        @endif
					</div>
					<div class="form-group mr-2r">
                        <button type="button" id="order-excel" class="btn btn-white">
                            <i class="glyphicon glyphicon-ban-circle"></i> 导出
                        </button>
                        {{--@if($status == 1)
                            <a href="{{ url('/excel') }}?status=1" class="btn btn-white">
                                <i class="glyphicon glyphicon-edit"></i> 导出
                            </a>
                        @endif
                        @if($status == 5)
                                <a href="{{ url('/excel') }}?status=5" class="btn btn-white">
                                    <i class="glyphicon glyphicon-edit"></i> 导出
                            </a>
                        @endif
                        @if($status == 8)
                            <a href="{{ url('/excel') }}?status=8" class="btn btn-white">
                                <i class="glyphicon glyphicon-edit"></i> 导出
                            </a>
                        @endif
                        @if($status == 10)
                            <a href="{{ url('/excel') }}?status=10" class="btn btn-white">
                                <i class="glyphicon glyphicon-edit"></i> 导出
                            </a>
                        @endif--}}
						<button type="button" class="btn btn-white">
							<i class="glyphicon glyphicon-arrow-down"></i> 导入
						</button>
					</div>
				</div>
			</div>
			<div class="row scroll">
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
                            <td>
                                <span>{{$order->logistics->name}}</span><br>
                                <small class="text-muted">{{$order->express_no}}</small>
                            </td>
                            <td>{{$order->count}}</td>
                            <td>{{$order->pay_money}} / {{$order->freight}}</td>
                            <td tdr="nochect">
                                <button class="btn btn-gray btn-sm show-order" type="button" value="{{$order->id}}" active="1">查看</button>
                                @if ($order->status == 1 || $order->status == 5)
                                <button value="{{$order->id}}" class="btn btn-default btn-sm delete-order">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
            @if ($order_list)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">{!! $order_list->render() !!}</div>
            </div>
            @endif
		</div>
	</div>
    
    @include('mustache.order_info')
    
@endsection

@section('customize_js')
    {{--<script>--}}
    @parent
    var _token = $('#_token').val();
    var PrintTemplate;
    var LODOP; // 声明为全局变量

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
        var order_id = $(this).attr('value');
        var delete_obj = $(this).parent().parent();
        $.post('{{url('/order/ajaxDestroy')}}',{'_token': _token, 'order_id': order_id},function (e) {
            if(e.status){
                delete_obj.remove();
            }else{
                alert(e.message);
            }
        },'json');
    });
    
    // 批量反审
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
    
    // 批量审单
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

    // 批量发货
    $('#send-order').click(function() {
        if (!$("input[name='Order']:checked").size()) {
            alert('请选择需发货的订单!');
            return;
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
        
        {{--LODOP.SET_PRINT_STYLE("FontSize", 18);
        LODOP.SET_PRINT_STYLE("Bold", 1);--}}
        {{--LODOP.SET_PRINT_PAGESIZE(3, 1000, 1000, "");//动态纸张--}}
        {{--LODOP.ADD_PRINT_TEXT(50, 231, 260, 39, "打印页面部分内容");--}}
        LODOP.ADD_PRINT_HTM(0, 0, "100%", "100%", PrintTemplate);
    };


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

    $("#order-excel").click(function () {
        var id_array = [];
        $("input[name='Order']").each(function() {
            if($(this).is(':checked')){
                id_array.push($(this).attr('value'));
            }
        });
        post('{{url('/excel')}}',id_array);
    });
@endsection