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
            <form id="add-order" role="form" method="post" action="{{ url('/order/store') }}">
                <div class="row ui white ptb-4r">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group vt-34">订单类型：</div>
                            <div class="form-group pr-4r mr-2r">
                                <select class="selectpicker" id="supplier_id" name="supplier_id" style="display: none;">
                                    <option value=''>选择供应商</option>
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
                                <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
                                    <option value="">选择仓库</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">商付款方式：</div>
                            <div class="form-group pr-4r mr-2r">
                                <select class="selectpicker" id=" " name=" " style="display: none;">
                                    <option value="0">先付款</option>
                                    <option value="1">货到付款</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-inline">
                            <div class="form-group vt-34">订单号：</div>
                            <div class="form-group pr-4r mr-2r">
                                <input type="text" name="price" ordertype="b2cCode" class="form-control" id="b2cCode" placeholder="未填则为系统默认单号">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-0 pb-4r ui white">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">快递公司：</div>
                            <div class="form-group pr-4r mr-2r">
                                <select class="selectpicker" id="storage_id" name="storage_id" style="display: none;">
                                    <option value="">选择仓库</option>
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
                                <input style="width: 120px;" type="text" name="freight" ordertype="discountFee" class="form-control float price" id="orderFee" placeholder="输入金额,如:0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-4r ui white">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">卖家备注：</div>
                            <div class="form-group pr-0 mr-0">
                                <input type="text" name="discountFee" ordertype="discountFee" class="form-control float" id="orderFee">
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
                            <div class="form-group pr-4r mr-0">
                                <input type="text" name="" class="form-control float">
                            </div>
                            {{-- 
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
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="row mb-0 pb-4r ui white">
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">手机号：</div>
                            <div class="form-group pr-4r mr-0">
                                <input type="text" name="" class="form-control float">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">电话号：</div>
                            <div class="form-group pr-4r mr-0">
                                <input type="text" name="" class="form-control float">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline">
                            <div class="form-group vt-34">邮编：</div>
                            <div class="form-group pr-4r mr-0">
                                <input type="text" name="" class="form-control float">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-4r ui white">
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group vt-34">详细地址：</div>
                            <div class="form-group pr-4r mr-0">
                                <input type="text" name="" class="form-control float">
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
                                    <option value="">默认仓库</option>
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
                                            <h4 class="modal-title" id="gridSystemModalLabel">添加客户</h4>
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
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                                                                </td>
                                                                <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                                <td>伟哥</td>
                                                                <td>18923405430</td>
                                                                <td>100015</td>
                                                                <td>北京北京市朝阳区马辛店</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                                                                </td>
                                                                <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                                <td>伟哥</td>
                                                                <td>18923405430</td>
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
                                <tr class="maindata">
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
                                </tr>
                                <tr class="maindata">
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
                                </tr>
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
                    <button type="button" class="btn btn-white cancel once">取消</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('customize_js')
    @parent
    {{--<script>--}}
     
    {{--$('#adduser-button').click(function(){
        $("#adduser").modal('show');
        
        $.get('Order/ajaxOrder',function (e) {
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
        $("#addproduct").modal('show');
    });
    $("input[name='retail']").livequery(function(){
        $(this)
        .keyup(function(){
            var number = $(this).parent().siblings().children("input[name='number']").val();
            var retail = $(this).val();
            var discount = $(this).parent().siblings().children("input[name='discount']").val();
            var benefit = $(this).parent().siblings().children("input[name='benefit']").val();
            var total = retail * number - benefit ;
            if ( benefit !== ''){
                discount = ((retail * number - benefit)/(retail * number)*10).toFixed(1);
                $(this).parent().siblings().children("input[name='discount']").val(discount);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='number']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='benefit']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });
    
    $("input[name='number']").livequery(function(){
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
            var retail = $(this).parent().siblings().children("input[name='retail']").val();
            var discount = $(this).parent().siblings().children("input[name='discount']").val();
            var benefit = $(this).parent().siblings().children("input[name='benefit']").val();
            var total = retail * number - benefit ;
            if ( benefit !== ''){
                discount = ((retail * number - benefit)/(retail * number)*10).toFixed(1);
                $(this).parent().siblings().children("input[name='discount']").val(discount);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='number']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='benefit']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });
    $("input[name='discount']").livequery(function(){
        $(this)
        .keyup(function(){
            var number = $(this).parent().siblings().children("input[name='number']").val();
            var retail = $(this).parent().siblings().children("input[name='retail']").val();
            var discount = $(this).val();
            //var benefit = $(this).parent().siblings().children("input[name='benefit']").val();
            var total = retail * discount/10 ;
            if ( discount !== ''){
                benefit = number*retail - number*retail*discount/10;
                $(this).parent().siblings().children("input[name='benefit']").val(benefit);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='number']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='benefit']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });
    $("input[name='benefit']").livequery(function(){
        $(this)
        .keyup(function(){
            var number = $(this).parent().siblings().children("input[name='number']").val();
            var retail = $(this).parent().siblings().children("input[name='retail']").val();
            var discount = $(this).parent().siblings().children("input[name='discount']").val();
            var benefit = $(this).val();
            var total = retail * number - benefit ;
            if ( benefit !== ''){
                discount = ((retail * number - benefit)/(retail * number)*10).toFixed(1);
                $(this).parent().siblings().children("input[name='discount']").val(discount);
            }
            //var freight = $("input[name='freight']").val();
            $(this).parent().siblings(".total").html(total.toFixed(2));
            var allnumber=0;
            var allbenefit=0;
            var alltotal = 0;
            for(i=0;i<$('.maindata').length;i++){
                allnumber = allnumber + Number($('.maindata').eq(i).find("input[name='number']").val());
                allbenefit = allbenefit + Number($('.maindata').eq(i).find("input[name='benefit']").val());
                alltotal = alltotal + Number($('.maindata').eq(i).find(".total").text());
            }
            $('span.allnumber').html(allnumber);
            $('span.allsf').html(allbenefit+alltotal);
            $('span.allbenefit').html(allbenefit);
            $('span.alltotal').html(alltotal);
        })
    });

    
    {{--</script>--}}
@endsection