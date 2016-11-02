@extends('home.base')

@section('title', '同步库存')

@section('customize_css')
    @parent
    .operate-update-offlineEshop,.operate-update-offlineEshop:hover,.btn-default.operate-update-offlineEshop:focus{
    border: none;
    display: inline-block;
    background: none;
    box-shadow: none !important;
    }
@endsection

@section('content')
    @parent

    @include('block.errors')

    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        同步库存
                    </div>
                </div>
                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                    </li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row fz-0">
                <button type="button" id="synchronous" class="btn btn-white mlr-2r">手动同步库存</button>
            </div>
            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>状态</th>
                        <th>操作人</th>
                        <th>开始时间</th>
                        <th>结束时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $v)
                        <tr>
                            <th class="text-center"><input type="checkbox"></th>
                            <th>{{$v->status_val}}</th>
                            <th>{{$v->user->realname}}</th>
                            <th>{{$v->time}}</th>
                            <th>{{$v->end_time}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($lists)
            <div class="col-md-6 col-md-offset-6">{!! $lists->render() !!}</div>
        @endif
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();
    $("#synchronous").click(function () {
        $.get('{{url('/synchronousStock/synchronous')}}',{},function (e) {
            if(e.status){
                location.reload();
            }else{
                alert(e.message);
            }
        },'json');
    });
@endsection