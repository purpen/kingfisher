@extends('home.base')

@section('title', '应收款')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();

    $(".receive").click(function () {
        var arr_id = [];
        arr_id.push($(this).val());
        $.post('{{url('/receive/ajaxConfirmReceive')}}', {'_token': _token, 'arr_id': arr_id}, function (e) {
            if (e.status == 1) {
                location.reload();
            } else if (e.status == -1) {
                alert(e.msg);
            } else{
                alert(e.message);
            }
        }, 'json');
    });

    $(".delete").click(function () {
        var id = $(this).val();
        $.post('{{url('/receive/ajaxDestroy')}}', {'_token': _token, 'id': id}, function (e) {
            if (e.status == 1) {
                location.reload();
            } else if (e.status == -1) {
                alert(e.msg);
            } else{
                alert(e.message);
            }
        }, 'json');
    });
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        收款单
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="{{url('/receive')}}">应收款</a></li>
                        <li><a href="{{url('/receive/complete')}}">已收款</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/receive/search')}}" method="POST">
                                <div class="form-group">
                                    <input type="text" name="where" class="form-control" placeholder="">
                                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                                </div>
                                <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="form-group">
            <a href="{{ url('/receive/createReceive') }}" class="btn btn-white mr-2r">
                <i class="glyphicon glyphicon-edit"></i> 创建收款
            </a>
        </div>
        <div class="row">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th class="text-center"><input type="checkbox" id="checkAll"></th>
                    <th>收款单号</th>
                    <th>付款人</th>
                    <th>应付金额</th>
                    <th>收支类型</th>
                    <th>相关单据</th>
                    <th>备注</th>
                    <th>创建人</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($receive as $v)
                    <tr>
                        <td class="text-center"><input name="Order" type="checkbox" value="{{$v->id}}"></td>
                        <td class="magenta-color">{{$v->number}}</td>
                        <td>{{$v->payment_user}}</td>
                        <td>{{$v->amount}}</td>
                        <td>{{$v->type_val}}</td>
                        <td>{{$v->target_number}}</td>
                        <td>{{$v->summary}}</td>
                        <td>{{$v->user->realname}}</td>
                        <td>{{$v->created_at_val}}</td>
                        <td>
                            <button type="button" value="{{$v->id}}" class="btn btn-white btn-sm mr-r receive">确认收款</button>
                            <a href="{{url('/receive/editReceive')}}?id={{$v->id}}" class="magenta-color mr-r">详细</a>
                            @if($v->type > 4)
                            <button type="button" id="" value="{{$v->id}}" class="btn btn-white btn-sm mr-r delete">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            @if ($receive)
                <div class="col-md-6 col-md-offset-6">{!! $receive->appends(['where' => $where])->render() !!}</div>
            @endif
        </div>
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
