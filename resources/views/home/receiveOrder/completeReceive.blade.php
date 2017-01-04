@extends('home.base')

@section('title', '已收款')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    {{--<script>--}}
    @parent
    var _token = $("#_token").val();
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
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
                @include('home/receiveOrder.subnav')
            </div>
        </div>
    </div>
    <div class="container mainwrap">

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
                        <td>@if($v->user){{ $v->user->realname }}@else 自动同步 @endif</td>
                        <td>{{$v->created_at_val}}</td>
                        <td>
                            <a href="{{url('/receive/detailedReceive')}}?id={{$v->id}}" class="magenta-color mr-r">详细</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            @if ($receive)
                <div class="col-md-6 col-md-offset-6">{!! $receive->appends(['subnav' => $subnav, 'where' => $where, 'start_date' => $start_date, 'end_date' => $end_date, 'type' => $type])->render() !!}</div>
            @endif
        </div>
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
