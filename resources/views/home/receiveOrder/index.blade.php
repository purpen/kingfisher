@extends('home.base')

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
            <div class="navbar-header">
                <div class="navbar-brand">
                    收款单
                </div>
            </div>
            @include('home/receiveOrder.subnav')
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/receive/createReceive') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 创建收款单
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
                                <a href="{{url('/receive/editReceive')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">查看</a>
                                <button type="button" value="{{$v->id}}" class="btn btn-warning btn-sm mr-r receive">确认收款</button>
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
        </div>
        <div class="row">
            @if ($receive)
                <div class="col-md-6 col-md-offset-6">{!! $receive->appends(['subnav' => $subnav, 'where' => $where, 'start_date' => $start_date, 'end_date' => $end_date, 'type' => $type])->render() !!}</div>
            @endif
        </div>
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
