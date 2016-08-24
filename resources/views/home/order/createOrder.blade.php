@extends('home.base')

@section('title', 'console')
@section('customize_css')
    @parent
    .bnonef{
    	padding:0;
    	box-shadow:none !important; 
    	background:none;
    	color:#fff !important;
    }
    .maindata input{
        width:100px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						新增订单
					</div>
				</div>
			</div>
		</div>
        <div class="container mainwrap">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="add-order" role="form" method="post" action="{{ url('/order/store') }}">

                <div class="row ui white ptb-4r">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group vt-34">订单类型：</div>
                            <div class="form-group pr-4r mr-2r">
                                <select class="selectpicker" id="supplier_id" name="type" style="display: none;">
                                    <option value='1'>普通订单</option>
                                    <option value='2'>渠道订单</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-0 pt-3r pb-2r ui white">
                    <div class="col-md-12">
                        <h5>订单信息</h5>
                    </div>
                </div>
                <div class="row mb-0 pb-4r ui white">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">店铺名称：</div>
                            <div class="form-group pr-4r mr-2r">
                                <select class="selectpicker" id="store_id" name="store_id" style="display: none;">
                                <option value="">选择店铺</option>
                                @foreach($store_list as $store)
                                <option value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">商付款方式：</div>
                            <div class="form-group pr-4r mr-2r">
                                <select class="selectpicker" id=" " name="payment_type" style="display: none;">
                                    <option value="1">在线付款</option>
                                    <option value="2">货到付款</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-inline">
                            <div class="form-group vt-34">站外订单号：</div>
                            <div class="form-group mr-2r">
                                <input type="text" name="outside_target_id" ordertype="b2cCode" class="form-control" id="b2cCode" placeholder="未填则为系统默认单号">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-0 pb-4r ui white">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">快递公司：</div>
                            <div class="form-group pr-4r mr-2r">
                                <select class="selectpicker" id="logistic_id" name="express_id" style="display: none;">
                                    <option value="">选择快递</option>
                                    @foreach($logistic_list as $logistic)
                                    <option value="{{$logistic->id}}">{{$logistic->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{--
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">订单优惠（元）：</div>
                            <div class="form-group pr-0 mr-0" style="width: 45%;">
                                <input type="text" name="discountFee" ordertype="discountFee" class="form-control float price" id="orderFee" placeholder="输入金额,如:0" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    --}}
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">运费（元）：</div>
                            <div class="form-group pr-0 mr-0">
                                <input style="width: 120px;" type="text" name="freight" ordertype="discountFee" class="form-control float price" id="orderFee" placeholder="输入金额">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-4r ui white">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">卖家备注：</div>
                            <div class="form-group pr-0 mr-0">
                                <input type="text" name="seller_summary" ordertype="discountFee" class="form-control float" id="orderFee">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-0 pt-3r pb-2r ui white">
                    <div class="col-md-12">
                        <h5>客户信息</h5>
                    </div>
                </div>
                <div class="row mb-0 pb-4r ui white">
                    <div class="col-md-6">
                        <div class="form-inline">
                            <div class="form-group vt-34">收货人：</div>
                            <div class="form-group mr-0">
                                <input type="text" name="buyer_name" class="form-control float">
                            </div>
                            <a href="#" data-toggle="modal" id="adduser-button">选择客户</a>
                            <div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
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
                                                <input id="search_val" type="text" placeholder="收货人\手机\电话" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                </span>
                                            </div>
                                            <div class="mt-4r scrolltt">
                                                <div id="user-list"> 
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr class="gblack">
                                                                <th class="text-center">选择</th>
                                                                <th>收货人</th>
                                                                <th>手机号</th>
                                                                <th>电话</th>
                                                                <th>邮编</th>
                                                                <th>地址</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                                                                </td>
                                                                <td>伟哥</td>
                                                                <td>18923405430</td>
                                                                <td> </td>
                                                                <td>100015</td>
                                                                <td>北京北京市朝阳区马辛店</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer pb-r">
                                                <div class="form-group mb-0 sublock">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                    <button type="button" id="choose-user" class="btn btn-magenta">确定</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-0 pb-4r ui white">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">手机号：</div>
                            <div class="form-group mr-0">
                                <input type="text" name="buyer_phone" class="form-control float">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">电话号：</div>
                            <div class="form-group mr-0">
                                <input type="text" name="buyer_tel" class="form-control float">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">邮编：</div>
                            <div class="form-group mr-0">
                                <input type="text" name="buyer_zip" class="form-control float">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-4r ui white">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group vt-34">详细地址：</div>
                            <div class="form-group mr-0">
                                <input type="text" name="buyer_address" class="form-control float">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-0 pt-3r pb-2r ui white">
                    <div class="col-md-12">
                        <h5>商品信息</h5>
                    </div>
                </div>
                <div class="row mb-0 pb-4r ui white">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group vt-34">发货仓库：</div>
                            <div class="form-group pr-4r mr-0">
                                <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
                                    <option value="">选择仓库</option>
                                    @foreach($storage_list as $storage)
                                    <option value="{{$storage->id}}">{{$storage->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="#" data-toggle="modal" id="addproduct-button">+添加商品</a>
                            <div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="gridSystemModalLabel">添加商品</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="input-group">
                                                <input id="search_val" type="text" placeholder="SKU编码/商品名称" class="form-control">
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
                                                        <tbody id="sku-list">

                                                           {{-- <tr>
                                                                <td class="text-center">
                                                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                                                                </td>
                                                                <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                                <td>伟哥</td>
                                                                <td>18923405430</td>
                                                                <td>100015</td>
                                                                <td>北京北京市朝阳区马辛店</td>
                                                            </tr>--}}

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer pb-r">
                                                <div class="form-group mb-0 sublock">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                    <button type="button" id="choose-sku" class="btn btn-magenta">确定</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ui white pb-4r">
                    <div class="well-lg ptb-0">
                        <table class="table table-bordered table-striped">
                            <thead class="table-bordered">
                                <tr class="gblack">
                                    <th>图片</th>
                                    <th>SKU编码</th>
                                    <th>商品名称</th>
                                    <th>属性</th>
                                    <th>零售价</th>
                                    <th>数量</th>
                                    <th>折扣</th>
                                    <th>优惠</th>
                                    <th>应付</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody id="append-sku">

                                {{--<tr class="maindata">
                                    <td>
                                        <img src=" " alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;">
                                    </td>
                                    <td>121</td>
                                    <td>自行车</td>
                                    <td>自行车</td>
                                    <td><input type="text" class="form-control price" id="count" name="retail" placeholder="0"></td>
                                    <td><input type="text" class="form-control" name="number" placeholder="0"></td>
                                    <td><input type="text" class="form-control price" name="discount" placeholder="例：7.5"></td>
                                    <td><input type="text" class="form-control price" name="benefit" placeholder="0"></td>
                                    <td class="total">0.00</td>
                                    <td class="delete"><a href="javascript:void(0)">删除</a></td>
                                </tr>--}}

                            </tbody>
                            <tr style="background:#dcdcdc;border:1px solid #dcdcdc; ">
                                <td colspan="3" class="fb">共计 <span class="allnumber magenta-color">0</span> 件商品</td>
                                <td colspan="4" class="text-center fb allquantity">商品总金额 <span class="magenta-color allsf">0</span> 元 - 商品总优惠 <span class="magenta-color allbenefit">0</span> 元 = <span class="magenta-color alltotal">0</span> 元</td>
                                <td colspan="3" class="fb alltotal">实付 <span class="magenta-color alltotal">0</span> 元</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-4r pt-2r">
                    <button type="submit" class="btn btn-magenta mr-r save">保存</button>
                    <button type="button" class="btn btn-white cancel once" onclick="window.history.back()">取消</button>
                </div>
                {!! csrf_field() !!}
            </form>
        </div>
    </div>
@endsection
@section('customize_js')
    @parent
    {{--<script>--}}

    var sku_data = '';
    var sku_id = [];
    $('#adduser-button').click(function(){
        $("#adduser").modal('show');

        {{--$.get('Order/ajaxOrder',function (e) {
            if (e.status){
                var template = ['<table class="table table-bordered table-striped">',
                                    '<thead>',
                                        '<tr class="gblack">',
                                        '<th class="text-center">选择</th>',
                                        '<th>收货人</th>',
                                        '<th>手机号</th>',
                                        '<th>电话</th>',
                                        '<th>邮编</th>',
                                        '<th>地址</th>',
                                        '</tr>',
                                    '</thead>',
                                    '<tbody>',
                                        '<tr>',
                                            '<td class="text-center">',
                                            '<input name="Order" class="sku-order" type="checkbox" active="0" value="1">',
                                            '</td>',
                                            '<td>伟哥</td>',
                                            '<td>18923405430</td>',
                                            '<td> </td>',
                                            '<td>100015</td>',
                                            '<td>北京北京市朝阳区马辛店</td>',
                                        '</tr>',
                                        '<tr>',
                                            '<td class="text-center">',
                                            '<input name="Order" class="sku-order" type="checkbox" active="0" value="1">',
                                            '</td>',
                                            '<td>伟哥</td>',
                                            '<td>18923405430</td>',
                                            '<td> </td>',
                                            '<td>100015</td>',
                                            '<td>北京北京市朝阳区马辛店</td>',
                                        '</tr>',
                                    '</tbody>',
                                '</table>'].join("");
                    var views = Mustache.render(template, e);
                    sku_data = e.data;
                    $("#user-list").html(views);
                    $("#adduser").modal('show');
            }
        },'json');
    });--}}
    $('#addproduct-button').click(function(){
        var id = $("#storage_id").val();
        $.get('{{url('/order/ajaxSkuList')}}',{'id':id},function (e) {
            if(!e.status){
                alter('error');
            }else{
                var template = ['@{{#data}}<tr>',
                                '<td class="text-center">',
                                '<input name="Order" class="sku-order" type="checkbox" active="0" value="@{{id}}">',
                                '</td>',
                                '<td><img src="@{{path}}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>',
                                '<td>@{{ number }}</td>',
                                '<td>@{{ name }}</td>',
                                '<td>@{{ mode }}</td>',
                                '<td>@{{ count }}</td>',
                                '</tr>@{{/data}}'].join("");
                var views = Mustache.render(template, e);
                sku_data = e.data;
                $("#sku-list").html(views);
            }
        },'json');
        $("#addproduct").modal('show');
    });

    $("#choose-sku").click(function () {
        var skus = [];
        var sku_tmp = [];
        $(".sku-order").each(function () {
            if($(this).is(':checked')){
                if($.inArray(parseInt($(this).attr('value')),sku_id) == -1){
                    sku_id.push(parseInt($(this).attr('value')));
                    sku_tmp.push(parseInt($(this).attr('value')));
                }
            }
        });
        for (var i=0;i < sku_data.length;i++){
            if(jQuery.inArray(parseInt(sku_data[i].id),sku_tmp) != -1){
                skus.push(sku_data[i]);
            }
        }
        var template = ['@{{ #skus }}<tr class="maindata">',
            '<td>',
            '<img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;">',
            '</td>',
            '<input type="hidden" name="sku_id[]" value="@{{ sku_id }}">',
            '<input type="hidden" name="sku_storage_id[]" value="@{{ storage_id }}">',
            '<td>@{{ number }}</td>',
            '<td>@{{ name }}</td>',
            '<td>@{{ mode }}</td>',
            '<td><input type="text" class="form-control price" id="count" name="price[]" placeholder="0" value="@{{ price }}"></td>',
            '<td><input type="text" class="form-control price" name="quantity[]" placeholder="0" count="@{{ count }}" reserve_count="@{{ reserve_count }}" pay_count="@{{ pay_count }}" value="1"></td>',
            '<td><input type="text" class="form-control price" name="rebate" placeholder="例：7.5"></td>',
            '<td><input type="text" class="form-control price" name="discount[]" placeholder="0"></td>',
            '<td class="total">0.00</td>',
            '<td class="delete"><a href="javascript:void(0)">删除</a></td>',
            '</tr>@{{ /skus }}'].join("");
        var data = {};
        data['skus'] = skus;
        var views = Mustache.render(template, data);
        $("#append-sku").append(views);
        $("#addproduct").modal('hide');

        $(".delete").click(function () {
            $(this).parent().remove();
        });

        $("input[name='quantity[]']").blur(function () {
            var quantity = $(this).val();
            var count = $(this).attr('count');
            var reserve_count = $(this).attr('reserve_count');
            var pay_count = $(this).attr('pay_count');
            if(quantity > count - reserve_count - pay_count){
                alert('可卖库存不足');
                $(this).focus();
            }
        });

        $("#add-order").formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                outside_target_id: {
                    validators: {
                        notEmpty: {
                            message: '站外订单号不能为空！'
                        }
                    }
                },
                store_id: {
                    validators: {
                        notEmpty: {
                            message: '请选择店铺！'
                        }
                    }
                },
                type: {
                    validators: {
                        notEmpty: {
                            message: '请选择订单类型！'
                        }
                    }
                },
                payment_type: {
                    validators: {
                        notEmpty: {
                            message: '请选择付款方式！'
                        }
                    }
                },
                freight: {
                    validators: {
                        regexp: {
                            regexp: /^[0-9\.]+$/,
                            message: '格式不正确！'
                        }
                    }
                },
                express_id: {
                    validators: {
                        notEmpty: {
                            message: '请选择物流！'
                        }
                    }
                },
                buyer_name: {
                    validators: {
                        notEmpty: {
                            message: '收货人姓名 不能为空！'
                        }
                    }
                },
                buyer_tel: {
                    validators: {
                        regexp: {
                            regexp: /^[0-9-]+$/,
                            message: '格式不正确！'
                        }
                    }
                },
                buyer_phone: {
                    validators: {
                        notEmpty: {
                            message: '收货人手机不能为空！'
                        },
                        regexp: {
                            regexp: /^1[34578][0-9]{9}$/,
                            message: '格式不正确！'
                        }
                    }
                },
                buyer_zip: {
                    validators: {
                        notEmpty: {
                            message: '收货人姓名 不能为空！'
                        }
                    }
                },
                'storage_id[]': {
                    validators: {
                        notEmpty: {
                            message: '商品仓库ID不存在！'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: '商品仓库ID格式不正确！'
                        }
                    }
                },
                'sku_id[]': {
                    validators: {
                        notEmpty: {
                            message: '商品skuID不存在！'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: '商品skuID格式不正确！'
                        }
                    }
                },
                'quantity[]': {
                    validators: {
                        notEmpty: {
                            message: '购买数量不能为空！'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                                    message: '格式不正确！'
                        }
                    }
                },
                'price[]': {
                    validators: {
                        notEmpty: {
                            message: '价格不能为空！'
                        }
                    }
                },
                'discount[]': {
                    validators: {
                        regexp: {
                            regexp: /^[0-9\.]+$/,
                            message: '调拨数量格式不正确！'
                        }
                    }
                },
            }
        });


    });


    $("input[name='price[]']").livequery(function(){
        $(this)
        .keyup(function(){
            var number = $(this).parent().siblings().children("input[name='quantity[]']").val();
            var retail = $(this).val();
            var discount = $(this).parent().siblings().children("input[name='rebate']").val();
            var benefit = $(this).parent().siblings().children("input[name='discount[]']").val();
            var total = retail * number - benefit ;
            if ( benefit !== ''){
                discount = ((retail * number - benefit)/(retail * number)*10).toFixed(1);
                $(this).parent().siblings().children("input[name='rebate']").val(discount);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='quantity[]']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='discount[]']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });
    
    $("input[name='quantity[]']").livequery(function(){
        $(this)
        .keydown(function(){
            if(event.keyCode==13){
                event.keyCode=9;
            }   
        })
        .keypress(function(){  
            if ((event.keyCode<48 || event.keyCode>57)){
                event.returnValue=false ;
            }   
        })
        .keyup(function(){
            var number = $(this).val();
            var retail = $(this).parent().siblings().children("input[name='price[]']").val();
            var discount = $(this).parent().siblings().children("input[name='rebate']").val();
            var benefit = $(this).parent().siblings().children("input[name='discount[]']").val();
            var total = retail * number - benefit ;
            if ( benefit !== ''){
                discount = ((retail * number - benefit)/(retail * number)*10).toFixed(1);
                $(this).parent().siblings().children("input[name='rebate']").val(discount);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='quantity[]']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='discount[]']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });
    $("input[name='rebate']").livequery(function(){
        $(this)
        .keyup(function(){
            var number = $(this).parent().siblings().children("input[name='quantity[]']").val();
            var retail = $(this).parent().siblings().children("input[name='price[]']").val();
            var discount = $(this).val();
            //var benefit = $(this).parent().siblings().children("input[name='discount[]']").val();
            var total = retail * discount/10 ;
            if ( discount !== ''){
                benefit = number*retail - number*retail*discount/10;
                $(this).parent().siblings().children("input[name='discount[]']").val(benefit);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='quantity[]']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='discount[]']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });
    $("input[name='discount[]']").livequery(function(){
        $(this)
        .keyup(function(){
            var number = $(this).parent().siblings().children("input[name='quantity[]']").val();
            var retail = $(this).parent().siblings().children("input[name='price[]']").val();
            var discount = $(this).parent().siblings().children("input[name='rebate']").val();
            var benefit = $(this).val();
            var total = retail * number - benefit ;
            if ( benefit !== ''){
                discount = ((retail * number - benefit)/(retail * number)*10).toFixed(1);
                $(this).parent().siblings().children("input[name='rebate']").val(discount);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='quantity[]']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='discount[]']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });

    $("#add-order").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            outside_target_id: {
                validators: {
                    notEmpty: {
                        message: '站外订单号不能为空！'
                    }
                }
            },
            store_id: {
                validators: {
                    notEmpty: {
                        message: '请选择店铺！'
                    }
                }
            },
            type: {
                validators: {
                    notEmpty: {
                        message: '请选择订单类型！'
                    }
                }
            },
            payment_type: {
                validators: {
                    notEmpty: {
                        message: '请选择付款方式！'
                    }
                }
            },
            freight: {
                validators: {
                    regexp: {
                        regexp: /^[0-9\.]+$/,
                        message: '格式不正确！'
                    }
                }
            },
            express_id: {
                validators: {
                    notEmpty: {
                        message: '请选择物流！'
                    }
                }
            },
            buyer_name: {
                validators: {
                    notEmpty: {
                        message: '收货人姓名 不能为空！'
                    }
                }
            },
            buyer_tel: {
                validators: {
                    regexp: {
                        regexp: /^[0-9-]+$/,
                        message: '格式不正确！'
                    }
                }
            },
            buyer_phone: {
                validators: {
                    notEmpty: {
                        message: '收货人手机不能为空！'
                    },
                    regexp: {
                        regexp: /^1[34578][0-9]{9}$/,
                        message: '格式不正确！'
                    }
                }
            },
            buyer_zip: {
                validators: {
                    notEmpty: {
                        message: '邮编不能为空！'
                    }
                }
            },
            buyer_address: {
                validators: {
                    notEmpty: {
                        message: '地址不能为空！'
                    }
                }
            },
        }
    });
    {{--</script>--}}
@endsection