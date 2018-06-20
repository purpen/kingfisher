@extends('home.base')

@section('title', '渠道收款单')

@section('customize_css')
    @parent
    .maindata input{
    width:100px;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    创建渠道收款单
                </div>
            </div>
        </div>

        <div class="container mainwrap">
            @include('block.form-errors')
            <div class="row">
                <div class="col-md-12">
                    <div class="formwrapper">
                        <form id="add-brand" role="form" method="post" class="form-horizontal" action="{{ url('/receive/storeChannel') }}">

                            <h5>收款单信息</h5>
                            <hr>

                            <div class="form-group" style="position: relative;width: 100%">
                                <label for="distributor_user_id" class="col-sm-1 control-label">分销商</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <select class="selectpicker" id="distributor_user_id" name="distributor_user_id" style="display: none;">
                                            <option value="">请选择分销商</option>
                                            @foreach($distributor as $value)
                                                <option value='{{ $value->id }}'>{{ $value->realname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <label for="inputStartTime" class="col-sm-2 control-label">开始时间</label>
                                <div class="col-sm-3" style="width: 200px">
                                    <input type="text" class="form-control datetimepicker start" name="start_times" value="" placeholder="开始时间" autocomplete="off">
                                </div>
                                @if ($errors->has('start_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('start_time') }}</strong>
                                </span>
                                @endif
                                <label for="inputEndTime" class="col-sm-2 control-label">结束时间</label>
                                <div class="col-sm-3" style="width: 200px">
                                    <input type="text" class="form-control datetimepicker end" name="end_times" value="" placeholder="结束时间" autocomplete="off">
                                </div>
                                @if ($errors->has('end_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('end_time') }}</strong>
                                </span>
                                @endif
                                <div class="col-sm-2" style="margin: 0 auto;position: absolute;margin-left: 1373px">
                                    <a href="#" class="btn btn-magenta" data-toggle="modal" id="query-button">
                                        <i class="glyphicon glyphicon-search"></i> 确认
                                    </a>
                                </div>
                            </div>

                            @include('modal.create_channel')


                            <h5>详细信息 <a id="appendsku" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>添加促销</a></h5>
                            <hr>

                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr class="gblack">
                                    <th>商品名称</th>
                                    <th>销售价格</th>
                                    <th>商品数量</th>
                                    <th>商品金额</th>
                                    <th>促销开始时间</th>
                                    <th>促销结束时间</th>
                                    <th>促销价格</th>
                                    <th>促销数量</th>
                                    <th>促销金额</th>
                                    <th>总金额小计</th>
                                </tr>
                                </thead>
                                <tbody id="append-sku">

                                </tbody>
                                <tfoot>
                                <tr style="background:#dcdcdc;border:1px solid #dcdcdc;text-align: center">
                                    <td colspan="4" class="fb"></td>
                                    <td colspan="2" class="fb allquantity"><span class="red" id="skuTotalQuantity"></span></td>
                                    <td colspan="5" class="fb alltotal"><strong>所有订单总价：</strong><input type="text" name="skuTotalFee" value="" id="skuTotalFee" readonly></td>
                                </tr>
                                </tfoot>

                            </table>

                            <div class="form-group mt-3r">
                                <div class="col-sm-6 mt-4r">
                                    <button type="submit" class="btn btn-magenta btn-lg save mr-2r" id="tijiao">生成收款单</button>
                                    {{--<button type="submit" class="btn btn-magenta btn-lg mr-2r" id="save">保存</button>--}}
                                    <button type="button" class="btn btn-white cancel btn-lg once" id="suan">重新计算</button>
                                </div>
                            </div>
                            {!! csrf_field() !!}
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();
    var sku_data = '';
    var sku_id = [];
{{--    <!--{{&#45;&#45;1可提交 0:阻止提交&#45;&#45;}}-->--}}
    var submit_status = 1;

@endsection

@section('load_private')


{{--    <!--{{&#45;&#45;根据供应商及时间显示商品明细列表&#45;&#45;}}-->--}}
    $("#query-button").click(function () {
    var distributor_user_id = $("select[name='distributor_user_id']").val();
    var start_times = $("input[name='start_times']").val();
    var end_times = $("input[name='end_times']").val();

    var all_skuid = $("input[name='all_skuid']").val();
    if(!all_skuid || all_skuid == 0){
     all_skuid = 0;
    }else{
    $("input[name='all_skuid']").val(all_skuid);
    }

    if(distributor_user_id == 0){
    layer.msg('请选择分销商！');
    return false;
    }

    if(start_times =='' || end_times ==''){
    layer.msg('请选择时间！');
    return false;
    }

    var start = $(".start").val();
    var end = $(".end").val();
    if(start > end){
    layer.msg('时间选择有误！');
    return false;
    }

    {{--$.get('/receive/ajaxAdd',{'distributor_user_id':distributor_user_id,'start_times':start_times,'end_times':end_times,'oid':all_skuid},function (e) {--}}
    $.get('/receive/ajaxAdd',{'distributor_user_id':distributor_user_id,'start_times':start_times,'end_times':end_times,'sku_id':all_skuid},function (e) {
if (e.status){
    var template = ['<table class="table table-bordered table-striped">',
        '<thead>',
        '<tr class="gblack">',
            '<th class="text-center"><input type="checkbox" id="checkAll"></th>',
            '<th>商品名称</th>',
            '<th>销售价格</th>',
            '<th>商品数量</th>',
            '</tr>',
        '</thead>',
        '<tbody>',

        '@{{#data}}<tr>',
            '<input type="hidden" name="length" value="@{{data.length}}">',
            '<input type="hidden" name="oid[]" value="@{{id}}">',
            '<input type="hidden" name="all_sku_id"  value="@{{sku_id}}">',
            '<input type="hidden" name="all_skuid"  value="@{{sku_ids}}">',
            '<td class="text-center"><input name="Order" class="sku-order" orderId="@{{order_id }}" type="checkbox" sku-id="@{{sku_id}}" active="0" value="@{{ order_id }}"></td>',
            '<td> @{{ sku_name }}</td>',
            '<input type="hidden" name="distributor_user_id" value="@{{distributor_id}}">',
            '<td class="fb"><input type="text" name="price[@{{ids}}]" value="@{{price}}" style="border: none" readonly></td>',
            '<td class="fc"><input type="text" name="quantity[@{{ids}}]" value="@{{quantity}}" style="border: none" readonly></td>',
            '</tr>@{{/data}}',
        '</tbody>',
        '</table>',
    ].join("");

    var views = Mustache.render(template, e);
    sku_data = e.data;

    $("#sku-list").html(views);
    $("#addsku").modal('show');
    } else if(e.status == 0){
        layer.msg("暂无数据！");
        return false;
      }
    },'json');
    });


    $("#choose-sku").click(function () {

    var skus = [];
    var sku_tmp = [];
    var sku_orderId_tmp=[];

    var sku_all_id = "";
    var all_skuid = $("input[name='all_skuid']").val() +  sku_all_id;

    $(".sku-order").each(function () {
    if($(this).is(':checked')){
    if($.inArray(parseInt($(this).attr('templatevalue')),sku_id) == -1){
    sku_all_id += $(this).attr("sku-id")+",";

    sku_id.push(parseInt($(this).attr('value')));
    sku_tmp.push(parseInt($(this).attr('value')));
    sku_orderId_tmp.push(parseInt($(this).attr('orderId')));

    }
    }
    });

    $("input[name='all_skuid']").val(sku_all_id+all_skuid);

    for (var i=0;i < sku_data.length;i++){
    if(jQuery.inArray(parseInt(sku_data[i].order_id),sku_orderId_tmp) != -1){
    skus.push(sku_data[i]);
    }

    }

    var template = ['@{{#skus}}<tr class="maindata">',
        '<input type="hidden" name="oid[@{{ids}}]" value="@{{id}}">',
        '<td>@{{sku_name}}</td>',
        '<td class="fb"><input type="text" name="price[@{{ids}}]" value="@{{price}}" style="border: none" readonly class="price"></td>',
        '<input type="hidden" class="sku_id" name="sku_id[@{{ids}}]" value="@{{sku_id}}">',
        '<input type="hidden" name="sku_name[]" value="@{{sku_name}}">',
        '<input type="hidden" name="sku_number[]" value="@{{sku_number}}">',
        '<td class="fc"><input type="text" name="quantity[]" value="@{{quantity}}" style="border: none" readonly></td>',
        '<td><input type="text" class="form-control integer operate-caigou-blur xiaoji" name="xiaoji[@{{sku_id}}]" style="border: none" readonly value="@{{goods_money}}"></td>',
        '<td><label for="inputStartTime" class="col-sm-2 control-label"></label><div class="col-sm-6"><input type="text" class="form-control datetimepickers starts" dataId="@{{ids}}" name="start_time[@{{sku_id}}]" placeholder="促销开始时间"  autocomplete="off"></div></td>',
        '<td><label for="inputEndTime" class="col-sm-2 control-label"></label><div class="col-sm-6"><input type="text" class="form-control datetimepickers ends" dataId="@{{ids}}" name="end_time[@{{sku_id}}]" placeholder="促销结束时间" autocomplete="off"></div></td>',
        '<td><input type="text" name="prices[@{{sku_id}}]" class="form-control operate-caigou-blur prices" id="prices" placeholder=""></td>',
        '<td><input type="text" class="form-control integer operate-caigou-blur count" id="number_@{{ids}}"  name="number[]" value="0" placeholder="促销数量" readonly></td>',
        '<td><input type="text" class="form-control integer operate-caigou-blur" name="jine[]" readonly></td>',
{{--        '<td class="total" name="total[@{{ids}}]">0.00</td>',--}}
        '<td class="total" name="total[]">0.00</td>',
        '</tr>@{{/skus}}'].join("");

    var data = {};
    data['skus'] = skus;
    var views = Mustache.render(template, data);
    $("#append-sku").append(views);
    $("#addsku").modal('hide');
    });



{{--    <!--{{&#45;&#45;选择时间&#45;&#45;}}-->--}}
    $('.datetimepicker').datetimepicker({
    language:  'zh',
    minView: "month",
    format : "yyyy-mm-dd",
    autoclose:true,
    todayBtn: true,
    todayHighlight: true,
    });


    $(".starts").livequery(function(){
    $(this)
    .css("ime-mode", "disabled")
    .keypress(function(){
    if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
    event.returnValue=false;
    }
    })

    $('.datetimepickers').datetimepicker({
    language:  'zh',
    minView: "month",
    format : "yyyy-mm-dd",
    autoclose:true,
    todayBtn: true,
    todayHighlight: true,
    });
    })

{{--添加/追加时获取促销数量--}}
    $(".ends").livequery(function(){
        var thisData= $(this);
        thisData.change(function(){
            var dataId = thisData.attr("dataId");
            var sku_id=$(this).parent().parent().parent().find("input[name^='sku_id["+dataId+"]']").val();
            var end_time = $(this).val();
            var start_time = $(this).parent().parent().prev().find(".starts").val();
                if(start_time){
                    $.get('/receive/ajaxNum',{'id':dataId,'end_time':end_time,'start_time':start_time,'sku_id':sku_id},function (e) {
                        if (e.status){
                        $("#number_"+dataId).val(e.data);
                        }
                    },'json');
                }
        })
    })


    $(".prices").livequery(function(){
        $(this)
        .css("ime-mode", "disabled")
        .keypress(function(){
            if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
            event.returnValue=false;
            }
        })

    .keyup(function(){
        var alltotal = 0;
        var price = $(this).parent().parent().find($(".price")).val();
        var prices = $(this).val();
        var number = $(this).parent().next().find($("input[name^='number']")).val();
        var jine = (price - prices) * number;
        $(this).parent().next().next().find($("input[name^='jine[]']")).val(jine);
        var xiaoji = $(this).parent().parent().find(".xiaoji").val();

        var quantity = $(this).parent().parent().find($(".quantity")).val();
        {{--$(this).parent().parent().find(".total").html(xiaoji-jine);--}}
        $(this).parent().parent().find(".total").html(xiaoji - (price - prices) * number);

            var price = $(this).parent().parent().find($(".price")).val();
            var time1 = $(this).parent().parent().find($("input[name^='start_time']")).val();
            var time2 = $(this).parent().parent().find($("input[name^='end_time']")).val();
            var prices = $(this).val();
            var start = $("input[name='start_times']").val();
            var end = $("input[name='end_times']").val();
            if(eval(prices) > eval(price)){
            layer.msg("价格填写有误！");
            return false;
            }
            if(time2 > end || time2 < start){
            layer.msg("促销结束时间选择有误");
            return false;
            }
            if(time1 > end || time1 < start){
            layer.msg("促销开始时间选择有误");
            return false;
            }
            if(time2 < time1){
            layer.msg("时间区间选择有误");
            return false;
            }

            for(i=0;i<$('.maindata').length;i++){
                alltotal = alltotal + Number($('.maindata').eq(i).find('.total').text());
            }
                $('#skuTotalFee').val(alltotal +'元');
        })

        $('.datetimepickers').datetimepicker({
            language:  'zh',
            minView: "month",
            format : "yyyy-mm-dd",
            autoclose:true,
            todayBtn: true,
            todayHighlight: true,
        });
    });

        {{--//点击清除按钮时，将input的值清空--}}
        $("#suan").click(function(){
        $(".prices").val("");
        $('#skuTotalFee').val("");
        });


    {{--提交之前判断价格有没有小于成本价--}}
        $("#tijiao").click(function(){
        var price={};
        var prices={};
        var time1={};
        var time2={};

        var all_skuid = $("input[name='all_skuid']").val();

        all_skuid = all_skuid.substr(0,all_skuid.length-1,1);
        all_skuid_arr = all_skuid.split(",");

        for(x in all_skuid_arr){

        var start_time = $("input[name='start_time["+all_skuid_arr[x]+"]']").val();
        var end_time = $("input[name='end_time["+all_skuid_arr[x]+"]']").val();
        var prices = $("input[name='prices["+all_skuid_arr[x]+"]']").val();
        var xiaoji = $("input[name='xiaoji["+all_skuid_arr[x]+"]']").val();
        if(start_time && end_time && !prices){
        layer.msg("促销价格需要填写！");
        return false;
        }
        if(!start_time && !end_time && !prices){

        var skuTotalFee=0;
        $("input[name^='xiaoji']").each(function(){
        skuTotalFee=skuTotalFee + parseInt($(this).val());
        }
        )
        $('#skuTotalFee').val(skuTotalFee + ' 元');
        }

        }

        });

@endsection