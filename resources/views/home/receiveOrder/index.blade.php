@extends('home.base')

@section('customize_js')
    @parent
    var _token = $("#_token").val();

@endsection

@section('load_private')
    @parent

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

    {{--按时时间、类型导出--}}
    $("#receive-excel-1").click(function () {
        var type = $("#type").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var subnav = $("#subnav").val();
        if(start_date == '' || end_date == ''){
            alert('请选择时间');
        }else{
            post('{{url('/dateGetReceiveExcel')}}',{'type':type,'start_date':start_date,'end_date':end_date,'subnav':subnav});
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
                    收款单
                </div>
            </div>
            @include('home/receiveOrder.subnav')
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                    <div class="form-group">
                        <a href="{{ url('/receive/createReceive') }}" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-edit"></i> 创建收款单
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <span>应收金额：<span class="text-danger">{{ $money->amount_sum }}</span> 元</span>
                <span>已收金额：<span class="text-danger">{{ $money->received_sum }}</span> 元</span>
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
                    <th>关联人</th>
                    <th>备注</th>
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
                            @if($v->type == 3)
                                <td><a target="_blank" href="{{url('/order/search')}}?number={{$v->target_number}}">{{$v->target_number}}</a></td>
                            @else
                                <td>{{$v->target_number}}</td>
                            @endif
                            <td>{{$v->target_user}}</td>
                            <td>{{$v->summary}}</td>
                            <td>{{$v->created_at_val}}</td>
                            <td>
                                <a href="{{url('/receive/editReceive')}}?id={{$v->id}}" class="btn btn-white btn-sm mr-r">查看</a>
                                @if($v->status == 0)
                                <button type="button" value="{{$v->id}}" class="btn btn-warning btn-sm mr-r receive">确认收款</button>
                                @endif
                                @if($subnav == 'waitReceive'&& $v->type > 4)
                                <button type="button" id="" value="{{$v->id}}" class="btn btn-white btn-sm mr-r delete">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                                @endif
                                @role(['admin'])
                                @if($subnav == 'finishReceive' && $v->type > 4)
                                    <button type="button" id="" value="{{$v->id}}" class="btn btn-white btn-sm mr-r delete">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                @endif
                                @endrole
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
