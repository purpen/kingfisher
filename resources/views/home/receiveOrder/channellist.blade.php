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
                    渠道收款单列表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li @if($tab_menu == 'default')class="active"@endif><a href="{{url('/receive/receiveIndex')}}">全部</a></li>
                    {{--                    <li @if($tab_menu == 'saled')class="active"@endif><a href="{{url('/receive/saleList')}}">待负责人确认</a></li>--}}
                    <li @if($tab_menu == 'unpublish')class="active"@endif><a href="{{url('/receive/unpublishList')}}">待分销商确认 </a></li>
                    <li @if($tab_menu == 'canceled')class="active"@endif><a href="{{url('/receive/cancList')}}">待确认付款</a></li>
                    <li @if($tab_menu == 'overled')class="active"@endif><a href="{{url('/receive/overList')}}">完成</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/receive/channel') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 创建渠道收款单
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
                        <th>渠道商</th>
                        <th>总金额</th>
                        <th>操作人</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>




                    {{--@foreach($brandlist as $v)--}}
                        {{--<tr>--}}
                            {{--<td class="text-center"><input name="Order" type="checkbox" value="{{$v->id}}"></td>--}}
                            {{--<td class="magenta-color">{{$v->number}}</td>--}}
                            {{--<td>--}}
                                {{--@if ($v->status == 0)--}}
                                    {{--待关联人确认--}}
                                    {{--<span class="label label-danger">默认</span>--}}
                                {{--@endif--}}
                                {{--@if ($v->status == 1)--}}
                                    {{--<span class="label label-danger">待采购确认</span>--}}
                                {{--@endif--}}
                                {{--@if ($v->status == 2)--}}
                                    {{--<span class="label label-danger">待供应商确认</span>--}}
                                {{--@endif--}}

                                {{--@if ($v->status == 3)--}}
                                    {{--<span class="label label-success">待确认付款</span>--}}
                                {{--@endif--}}

                                {{--@if ($v->status == 4)--}}
                                    {{--<span class="label label-default">完成</span>--}}
                                {{--@endif--}}

                            {{--</td>--}}
                            {{--<td>--}}
                                {{--{{$v->supplier_user_id}}--}}
                                {{--@foreach($suppliers as $supplier)--}}
                                    {{--<option @if($supplier->id == $v->supplier_user_id) selected @endif value="{{ $supplier->id }}">{{ $supplier->nam }}</option>--}}
                                {{--@endforeach--}}
                            {{--</td>--}}
                            {{--<td>{{$v->total_price}}</td>--}}
                            {{--<td>{{ \Illuminate\Support\Facades\Auth::user()->realname}}</td>--}}
                            {{--<td>{{ $v->created_at }}</td>--}}
                            {{--<td>--}}
                                {{--<a href="{{url('/payment/show')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">查看详情</a>--}}
                                {{--<a href="{{url('/payment/edit')}}?id={{$v->id}}" class="magenta-color mr-r">编辑</a>--}}
                                {{--<a href="javascript:void(0)" value="{{$v->id}}" class="magenta-color delete">删除</a>--}}

                                {{--<button type="button" id="charge" value="{{$purchase->id}}" class="btn btn-success btn-sm mr-r">记账</button>--}}
                                {{--<button type="button" id="reject" value="{{$v->id}}" class="btn btn-warning btn-sm mr-r reject">驳回</button>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    </tbody>
                </table>
            </div>
        </div>
        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    </div>
@endsection
