@extends('home.base')

@section('customize_js')
    @parent
    var _token = $("#_token").val();
@endsection


@section('load_private')
    @parent
    {{--<script>--}}
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
    });

    $('#confirm-pay').click(function () {
    var arr_id = [];
    $("input[name='Order']").each(function () {
    if ($(this).is(':checked')) {
    arr_id.push($(this).val());
    }
    });
    $.post('/payment/ajaxConfirmPay', {'_token': _token, 'arr_id': arr_id}, function (e) {
    if (e.status) {
    location.reload();
    } else if (e.status == 0) {
    alert(e.message);
    }
    }, 'json');
    });

    $("#payment").click(function () {
    var arr_id = [];
    $("input[name='Order']").each(function () {
    if ($(this).is(':checked')) {
    arr_id.push($(this).val());
    }
    });

    $.post('/payment/ajaxConfirmPay', {'_token': _token, 'arr_id': arr_id}, function (e) {
    if (e.status) {
    location.reload();
    } else if (e.status == 0) {
    alert(e.message);
    }
    }, 'json');
    });

    $('#charge').click(function () {
    layer.confirm('确认要通过审核吗？',function(index){
    var arr_id = [];
    $("input[name='Order']").each(function () {
    if ($(this).is(':checked')) {
    arr_id.push($(this).val());
    }
    });
    $.post('/payment/ajaxCharge',{'_token':_token,'id':arr_id},function (e) {
    if(e.status){
    layer.msg('操作成功！');
    location.reload();
    }else if(e.status == 0){
    alert(e.message);
    }
    },'json');
    });
    });
    {{--导出execl--}}
    $("#payment-excel").click(function () {
    var id_array = [];
    $("input[name='Order']").each(function() {
    if($(this).is(':checked')){
    id_array.push($(this).attr('value'));
    }
    });
    post('{{url('/paymentExcel')}}',id_array);
    });

    {{--按时时间、类型导出--}}
    $("#payment-excel-1").click(function () {
    var payment_type = $("#payment_type").val();
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var subnav = $("#subnav").val();
    if(start_date == '' || end_date == ''){
    alert('请选择时间');
    }else{
    post('{{url('/dateGetPaymentExcel')}}',{'payment_type':payment_type,'start_date':start_date,'end_date':end_date,'subnav':subnav});
    }

    });

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

@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    付款单列表
                </div>
            </div>

            <div class="navbar-collapse collapse">
                @include('home.payment.subnav')

                <div class="navbar-header">
                    <div class="navbar-brand">
                        <a href="{{ url('/payment/brandlist') }}">品牌付款单列表</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="container mainwrap">
        <div class="row fz-0">
            <div class="col-md-12">
                <button type="button" class="btn btn-success mr-2r" id="charge">
                    <i class="glyphicon glyphicon-check"></i>审核
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/payment/create') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 创建付款单
                        </a>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<a href="{{ url('/payment/brand') }}" class="btn btn-white mr-2r">--}}
                            {{--<i class="glyphicon glyphicon-edit"></i> 创建品牌付款单--}}
                        {{--</a>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <button type="button" id="payment-excel" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-arrow-up"></i> 导出选中
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="button" id="payment-excel-1" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-arrow-up"></i> 条件导出
                        </button>
                    </div>
                    @if($subnav == 'waitpay')
                        <div class="form-group">
                            <button type="button" class="btn btn-success mr-2r" id="payment">
                                <i class="glyphicon glyphicon-check"></i>付款
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4 text-right">
                <span>付款金额：<span class="text-danger">{{ $money or 0 }}</span> 元</span>
            </div>
        </div>
        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>采购单编号</th>
                        <th>类型</th>
                        <th>供应商</th>
                        <th>仓库</th>
                        <th>部门</th>
                        <th>采购数量</th>
                        <th>已入库数量</th>
                        <th>采购总额</th>
                        <th>创建时间</th>
                        <th>制单人</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $v)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox" value="{{$v->id}}"></td>
                            <td class="magenta-color">{{$v->number}}</td>
                            <td>{{$v->supplier_type_val}}</td>
                            <td>{{$v->supplier_name}}</td>
                            <td>{{$v->storage}}</td>
                            <td>{{ $v->department_val }}</td>
                            <td>{{$v->count}}</td>
                            <td>{{$v->in_count}}</td>
                            <td>{{$v->price}}元</td>
                            <td>{{$v->created_at_val}}</td>
                            <td>{{$v->user}}</td>
                            <td>{{$v->summary}}</td>
                            <td>
                                <a href="{{url('/purchase/show')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">查看详情</a>
                                {{--<button type="button" id="charge" value="{{$purchase->id}}" class="btn btn-success btn-sm mr-r">记账</button>--}}
                                <button type="button" id="reject" value="{{$v->id}}" class="btn btn-warning btn-sm mr-r reject">驳回</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($purchases)
            <div class="row">
                <div class="col-md-6 col-md-offset-6">{!! $purchases->render() !!}</div>
            </div>
        @endif
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection