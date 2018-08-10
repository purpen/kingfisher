@extends('home.base')

@section('customize_css')
    @parent

@endsection

@section('content')
    @parent
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        销售统计
                    </div>
                </div>
                <ul class="nav navbar-nav navbar-right mr-0">
                    <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/salesStatistics/search')}}" method="POST">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden"  name="id" value="{{$user->id}}">
                        <div class="form-group">
                            <label for="weight" class="control-label">开始时间</label>
                            <input type="text" class="input-append date datetimepicker" id="datetimepicker" name="start_time" value="{{$start_time}}">
                            <label for="weight" class="control-label">结束时间</label>
                            <input type="text" class="input-append date datetimepicker" id="datetimepicker" name="end_time" value="{{$end_time}}">
                        </div>
                        <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
                    </form>
                </ul>
            </div>

        </div>
        <div class="container mainwrap">
            @include('block.form-errors')
            <div class="row">
                <div class="form-inline">
                    <div class="form-group col-sm-4">
                        <h4>会员名称：<span class="magenta-color">{{$user->username}}</span></h4>
                    </div>
            <div class="row scroll">
            </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th>商品/型号</th>
                        <th>数量</th>
                        <th>单价</th>
                        <th>优惠</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr>
                            <td>{{$v->sku_name}}</td>
                            <td>{{$v->quantity}}</td>
                            <td>{{$v->price}}</td>
                            <td>{{$v->discount}}</td>
                            <td>{{$v->updated_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-8">
                            总金额：<span class="magenta-color">{{$sum_money}}</span> - 总优惠：<span class="magenta-color">{{$discount}}</span> = 实际金额：<span class="magenta-color">{{$pay_money}}</span>
                        </div>
                    </div>
            </div>
           {{-- @if ($data)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">{!! $data->render() !!}</div>
                </div>
            @endif--}}
        </div>
            <p class="mt-4r">
                <a href="{{url('/salesStatistics/user')}}?id={{$user->id}}" class="btn btn-default">
                    <i class="glyphicon glyphicon-arrow-left"></i> 返回上一步
                </a>
            </p>
    </div>

@endsection

@section('customize_js')
    @parent
    {{--选择事件插件--}}
    $('.datetimepicker').datetimepicker({
    language:  'zh',
    minView: "month",
    format : "yyyy-m-d h:i:s",
    autoclose:true,
    todayBtn: true,
    todayHighlight: true,
    });
@endsection