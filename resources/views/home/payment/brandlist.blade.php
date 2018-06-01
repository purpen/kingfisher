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

    $(".delete").click(function () {
    if(confirm('确认删除该付款单？')){
    var id = $(this).attr('value');
    var de = $(this);
    $.post('{{url('/payment/Destroy')}}',{'_token':_token,'id':id},function (e) {
    if(e.status){
    de.parent().parent().remove();
    }
    },'json');
    }
    });

    {{--导出execl--}}
    {{--$("#payment-excel").click(function () {--}}
    {{--var id_array = [];--}}
    {{--$("input[name='Order']").each(function() {--}}
    {{--if($(this).is(':checked')){--}}
    {{--id_array.push($(this).attr('value'));--}}
    {{--}--}}
    {{--});--}}
    {{--post('{{url('/paymentExcel')}}',id_array);--}}
    {{--});--}}

    {{--按时时间、类型导出--}}
    {{--$("#payment-excel-1").click(function () {--}}
    {{--var payment_type = $("#payment_type").val();--}}
    {{--var start_date = $("#start_date").val();--}}
    {{--var end_date = $("#end_date").val();--}}
    {{--var subnav = $("#subnav").val();--}}
    {{--if(start_date == '' || end_date == ''){--}}
    {{--alert('请选择时间');--}}
    {{--}else{--}}
    {{--post('{{url('/dateGetPaymentExcel')}}',{'payment_type':payment_type,'start_date':start_date,'end_date':end_date,'subnav':subnav});--}}
    {{--}--}}

    {{--});--}}

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
                    品牌付款单列表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li @if($tab_menu == 'default')class="active"@endif><a href="{{url('/payment/brandIndex')}}">全部</a></li>
                    {{--<li @if($tab_menu == 'guanlianlish')class="active"@endif><a href="{{url('/payment/guanlianrenList')}}">待关联人确认</a></li>--}}
                    <li @if($tab_menu == 'unpublish')class="active"@endif><a href="{{url('/payment/unpublishList')}}">待采购确认</a></li>
                    {{--<li @if($tab_menu == 'saled')class="active"@endif><a href="{{url('/payment/saleList')}}">待供应商确认</a></li>--}}
                    <li @if($tab_menu == 'canceled')class="active"@endif><a href="{{url('/payment/cancList')}}">待确认付款</a></li>
                    <li @if($tab_menu == 'overled')class="active"@endif><a href="{{url('/payment/overList')}}">完成</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/payment/brand') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 创建品牌付款单
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="row scroll">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>单号</th>
                        <th>状态</th>
                        <th>品牌商</th>
                        <th>总金额</th>
                        <th>操作人</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>




                    @foreach($brandlist as $v)
                        <tr>
                            <td class="text-center"><input name="Order" type="checkbox" value="{{$v->id}}"></td>
                            <td class="magenta-color">{{$v->number}}</td>
                            <td>
                                @if ($v->status == 0)
                                    {{--待关联人确认--}}
                                    <span class="label label-danger">默认</span>
                                @endif
                                    @if ($v->status == 1)
                                    <span class="label label-danger">待采购确认</span>
                                @endif
                                    @if ($v->status == 2)
                                    <span class="label label-danger">待供应商确认</span>
                                @endif

                                @if ($v->status == 3)
                                    <span class="label label-success">待确认付款</span>
                                @endif

                                @if ($v->status == 4)
                                    <span class="label label-default">完成</span>
                                @endif

                            </td>
                            <td>

                 {{ $v->name }}
                            </td>
                            <td>{{$v->total_price}}</td>
                            <td>{{ \Illuminate\Support\Facades\Auth::user()->realname}}</td>
                            <td>{{ $v->created_at }}</td>
                            <td>
                                <a href="{{url('/payment/show')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">查看详情</a>
                                @if($v->status !=4)
                                <a href="{{url('/payment/edit')}}?id={{$v->id}}" class="magenta-color mr-r">编辑</a>
                                <a href="javascript:void(0)" value="{{$v->id}}" class="magenta-color delete">删除</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection
