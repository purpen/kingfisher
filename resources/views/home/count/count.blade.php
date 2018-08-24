@extends('home.base')

@section('customize_css')
    @parent
    .classify{
    background: rgba(221,221,221,0.3)
    }
    .classify .ui.dividing.header{
    padding: 5px 15px 10px;
    border-bottom: 1px solid rgba(0,0,0,0.2);
    font-size:16px;
    }
    .panel-group .panel-heading{
    padding: 20px;
    margin-top: 10px;
    position: relative;
    }
    .panel-title {
    font-size: 14px;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    padding: 0px 15px;
    line-height: 40px;
    text-decoration: none !important;
    }
    .panel-title:hover{
    background:#f5f5f5;
    }
    .panel-title.collapsed span.glyphicon.glyphicon-triangle-bottom {
    transform: rotate(-90deg);
    -webkit-transform: rotate(-90deg);
    }
    .panel-group .panel-heading+.panel-collapse>.list-group{
    margin-left: 15px;
    border: none;
    }
    .list-group-item{
    padding: 5px 15px;
    background-color: rgba(0,0,0,0);
    border: 0 !important;
    border-radius: 0 !important;
    }
    tr.bone > td{
    border:none !important;
    border-bottom: 1px solid #ddd !important;
    }
    tr.brnone > td{
    border: none !important;
    border-bottom: 1px solid #ddd !important;
    }
    .popover-content tr{
    line-height: 24px;
    font-size: 13px;

    .panel-group{max-height:770px;overflow: auto;}
    .leftMenu{margin:10px;margin-top:5px;}
    .leftMenu .panel-heading{font-size:14px;padding-left:20px;height:36px;line-height:36px;color:#e0ffff;position:relative;cursor:pointer;}/*转成手形图标*/
    .leftMenu .panel-heading span{position:absolute;right:10px;top:12px;}
    .leftMenu .menu-item-left{padding: 2px; background: transparent; border:1px solid transparent;border-radius: 6px;}
    .leftMenu .menu-item-left:hover{background:#e0ffff;border:1px solid #1E90FF;}
}


@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    统计报表
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">

        <div class="col-md-2">
            <div class="panel-group table-responsive" role="tablist">
                <div class="panel panel-primary leftMenu">
                    <!-- 利用data-target指定要折叠的分组列表 -->
                    <div class="panel-heading" id="collapseListGroupHeading1" data-toggle="collapse" data-target="#collapseListGroup1" role="tab">
                        <h4 class="panel-title">
                            {{--<a href="" class="glyphicon glyphicon-chevron-up right">收入分析</a>--}}
                            <span class="glyphicon glyphicon-chevron-up right">收入分析</span>
                        </h4>
                    </div>
                    <!-- .panel-collapse和.collapse标明折叠元素 .in表示要显示出来 -->
                    <div id="collapseListGroup1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading1">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <!-- 利用data-target指定URL -->
                                <button class="menu-item-left" data-target="test2.html">
                                    <a href="" class="glyphicon glyphicon-triangle-right">商品收入</a>
                                </button>
                            </li>
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">门店收入</a>
                                </button>
                            </li>
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">地区收入</a>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div><!--panel end-->

                <div class="panel panel-primary leftMenu">
                    <div class="panel-heading" id="collapseListGroupHeading2" data-toggle="collapse" data-target="#collapseListGroup2" role="tab" >
                        <h4 class="panel-title">
                            {{--<a href="" class="glyphicon glyphicon-triangle-right">利润分析</a>--}}
                            <span class="glyphicon glyphicon-chevron-down right">利润分析</span>
                        </h4>
                    </div>
                    <div id="collapseListGroup2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading2">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">商品利润</a>
                                </button>
                            </li>
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">门店利润</a>
                                </button>
                            </li>
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">地区利润</a>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary leftMenu">
                    <div class="panel-heading" id="collapseListGroupHeading3" data-toggle="collapse" data-target="#collapseListGroup3" role="tab" >
                        <h4 class="panel-title">
                            {{--<a href="" class="glyphicon glyphicon-chevron-show right">利润率分析</a>--}}
                            <span class="glyphicon glyphicon-chevron-show right">利润率分析</span>
                        </h4>
                    </div>
                    <div id="collapseListGroup3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading2">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">商品利润率</a>
                                </button>
                            </li>
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">门店利润率</a>
                                </button>
                            </li>
                            <li class="list-group-item">
                                <button class="menu-item-left">
                                    <a href="" class="glyphicon glyphicon-triangle-right">地区利润率</a>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row1">
            <div class="col-md-8" style="margin-left: 54px">
            <h3>铟立方总收入趋势</h3>
            </div>
            <br>
            <div class="col-md-7">
                <label for="inputStartTime" class="col-sm-2 control-label" style="width: 90px">开始时间</label>
                <div class="col-sm-3" style="width: 125px">
                    <input type="text" class="form-control datetimepicker start1" name="start_time1" value="" placeholder="开始时间" required autocomplete="off">
                </div>
                @if ($errors->has('start_time1'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('start_time1') }}</strong>
                                </span>
                @endif
                <label for="inputEndTime" class="col-sm-2 control-label" style="width: 90px">结束时间</label>
                <div class="col-sm-3" style="width: 125px;">
                    <input type="text" class="form-control datetimepicker end1" name="end_time1" value="" placeholder="结束时间" required autocomplete="off">
                </div>
                @if ($errors->has('end_time1'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('end_time1') }}</strong>
                                </span>
                @endif
        </div>

            <div class="col-md-8">
                <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
                <div id="main1" style="width: 600px;height:400px;"></div>
            </div>

</div>










        <div class="row4" style="margin-left: 300px">
        <div class="col-md-8" style="margin-left: 60px">
            <select class="selectpicker" id="products" name="products" style="display: none;">
                <option value="">请选择商品名称</option>
{{--                @foreach($products as $v)--}}
                <option value="1">小米平衡车</option>
{{--                <option value="{{$v->id}}">{{$v->title}}</option>--}}
                {{--@endforeach--}}
            </select>
            <select class="selectpicker" id="sku_id" name="sku_id" style="display: none;">
                <option value="">请选择SKU</option>
                {{--@foreach($product_sku as $v)--}}
                <option value="1">订单审核</option>
{{--                <option value="{{$v->id}}">{{$v->mode}}</option>--}}
                {{--@endforeach--}}
            </select>
            <br>
            <div class="col-md-8">
            <select class="selectpicker" id="time_slot" name="time_slot" style="display: none;">
                <option value="最近7天">最近7天</option>
                <option value="最近30天">最近30天</option>
                <option value="最近60天">最近60天</option>
                <option value="最近90天">最近90天</option>
            </select>
            <label for="inputStartTime" class="col-sm-2 control-label" style="width: 90px">开始时间</label>
            <div class="col-sm-3" style="width: 125px">
                <input type="text" class="form-control datetimepicker start4" name="start_time4" value="" placeholder="开始时间" required autocomplete="off">
            </div>
            @if ($errors->has('start_time4'))
                <span class="help-block">
                                    <strong>{{ $errors->first('start_time4') }}</strong>
                                </span>
            @endif
            <label for="inputEndTime" class="col-sm-2 control-label" style="width: 90px">结束时间</label>
            <div class="col-sm-3" style="width: 125px;">
                <input type="text" class="form-control datetimepicker end4" name="end_time4" value="" placeholder="结束时间" required autocomplete="off">
            </div>
            @if ($errors->has('end_time4'))
                <span class="help-block">
                                    <strong>{{ $errors->first('end_time4') }}</strong>
                                </span>
            @endif
        </div>
        </div>
        <div class="col-md-8">
        <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
        <div id="main" style="width: 600px;height:400px;"></div>
        </div>

        <br>
        <div class="col-md-7">
        <label for="inputStartTime" class="col-sm-2 control-label" style="width: 90px">开始时间</label>
        <div class="col-sm-3" style="width: 125px">
            <input type="text" class="form-control datetimepicker start5" name="start_time5" value="" placeholder="开始时间" required autocomplete="off">
        </div>
        @if ($errors->has('start_time5'))
            <span class="help-block">
                                    <strong>{{ $errors->first('start_time5') }}</strong>
                                </span>
        @endif
        <label for="inputEndTime" class="col-sm-2 control-label" style="width: 90px">结束时间</label>
        <div class="col-sm-3" style="width: 125px;">
            <input type="text" class="form-control datetimepicker end5" name="end_time5" value="" placeholder="结束时间" required autocomplete="off">
        </div>
        @if ($errors->has('end_time5'))
            <span class="help-block">
                                    <strong>{{ $errors->first('end_time5') }}</strong>
                                </span>
        @endif

            <button type="submit" id="out_purchase" class="btn btn-white mr-2r">
                下载表格
            </button>
        </div>

        </div>
        <div class="col-md-7" style="margin-left: 300px">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th>时间</th>
                    <th>今日收入</th>
                    <th>累积收入</th>
                    <th>销售总量</th>
                </tr>
                </thead>
                <tbody id="def">

                </tbody>
            </table>
        </div>


        {{--<div class="row5">--}}
        {{--<div class="col-md-7" style="margin-left: 60px">--}}
            {{--<select class="selectpicker" id="goods" name="goods" style="display: none;">--}}
                {{--<option value="">请选择商品名称</option>--}}
                {{--@foreach($provinces as $v)--}}
                {{--<option value="1">订单审核</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
            {{--<select class="selectpicker" id="skus" name="skus" style="display: none;">--}}
                {{--<option value="">请选择SKU</option>--}}
                {{--@foreach($provinces as $v)--}}
                {{--<option value="1">订单审核</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
            {{--<br>--}}
            {{--<div class="col-md-8">--}}
            {{--<select class="selectpicker" id="times" name="times" style="display: none;">--}}
                {{--<option value="最近7天">最近7天</option>--}}
                {{--<option value="最近30天">最近30天</option>--}}
                {{--<option value="最近60天">最近60天</option>--}}
                {{--<option value="最近90天">最近90天</option>--}}
            {{--</select>--}}
            {{--<label for="inputStartTime" class="col-sm-2 control-label" style="width: 90px">开始时间</label>--}}
            {{--<div class="col-sm-3" style="width: 125px">--}}
                {{--<input type="text" class="form-control datetimepicker start6" name="start_time6" value="" placeholder="开始时间" required autocomplete="off">--}}
            {{--</div>--}}
            {{--@if ($errors->has('start_time6'))--}}
                {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('start_time6') }}</strong>--}}
                                {{--</span>--}}
            {{--@endif--}}
            {{--<label for="inputEndTime" class="col-sm-2 control-label" style="width: 90px">结束时间</label>--}}
            {{--<div class="col-sm-3" style="width: 125px;">--}}
                {{--<input type="text" class="form-control datetimepicker end6" name="end_time6" value="" placeholder="结束时间" required autocomplete="off">--}}
            {{--</div>--}}
            {{--@if ($errors->has('end_time6'))--}}
                {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('end_time6') }}</strong>--}}
                                {{--</span>--}}
            {{--@endif--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-md-8">--}}
        {{--<!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->--}}
        {{--<div id="main" style="width: 600px;height:400px;"></div>--}}
        {{--</div>--}}

        {{--<br>--}}
        {{--<div class="col-md-7" style="margin-left: 300px">--}}
        {{--<label for="inputStartTime" class="col-sm-2 control-label" style="width: 90px">开始时间</label>--}}
        {{--<div class="col-sm-3" style="width: 125px">--}}
            {{--<input type="text" class="form-control datetimepicker start7" name="start_time7" value="" placeholder="开始时间" required autocomplete="off">--}}
        {{--</div>--}}
        {{--@if ($errors->has('start_time7'))--}}
            {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('start_time7') }}</strong>--}}
                                {{--</span>--}}
        {{--@endif--}}
        {{--<label for="inputEndTime" class="col-sm-2 control-label" style="width: 90px">结束时间</label>--}}
        {{--<div class="col-sm-3" style="width: 125px;">--}}
            {{--<input type="text" class="form-control datetimepicker end7" name="end_time7" value="" placeholder="结束时间" required autocomplete="off">--}}
        {{--</div>--}}
        {{--@if ($errors->has('end_time7'))--}}
            {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('end_time7') }}</strong>--}}
                                {{--</span>--}}
        {{--@endif--}}
        {{--</div>--}}

        {{--<button type="submit" id="out_purchase" class="btn btn-white mr-2r">--}}
            {{--下载表格--}}
        {{--</button>--}}
        {{--</div>--}}
        {{--<div class="col-md-7" style="margin-left: 300px">--}}
            {{--<table class="table table-bordered table-striped">--}}
                {{--<thead>--}}
                {{--<tr class="gblack">--}}
                    {{--<th>时间</th>--}}
                    {{--<th>今日收入</th>--}}
                    {{--<th>累积收入</th>--}}
                    {{--<th>销售总量</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody id="def">--}}

                {{--</tbody>--}}
            {{--</table>--}}
        {{--</div>--}}
    {{--</div>--}}

    </div>

    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection
@section('customize_js')
    @parent
    {{--选择时间--}}
    $('.datetimepicker').datetimepicker({
    language:  'zh',
    minView: "month",
    format : "yyyy-mm-dd",
    autoclose:true,
    todayBtn: true,
    todayHighlight: true,
    });


    $(function(){
    $(".panel-heading").click(function(e){
    $(this).find("a").toggleClass("glyphicon-chevron-down");
    $(this).find("a").toggleClass("glyphicon-chevron-up");
    $(this).find("a").toggleClass("glyphicon-chevron-show");
    });




    {{--function(ec){--}}
    {{--一级菜单对应的曲线图--}}
    {{--// 基于准备好的dom，初始化echarts实例--}}
    var main = document.getElementById('main1');
    var mainone = document.getElementById('main');
    var charts = [];//同一个页面使用多个图表，把option实例存储在这个数组里

    var mychart = echarts.init(main);
    {{--// 指定图表的配置项和数据--}}
    option = {
    xAxis: {
    type: 'category',
    data: ['one', 'two', 'three', 'four', 'five', 'six', 'seven']
    },
    yAxis: {
    type: 'value'
    },
    series: [{
    data: [820, 932, 901, 934, 1290, 1330, 1320],
    type: 'line',
    smooth: true
    }]
    };

    {{--// 使用刚指定的配置项和数据显示图表。--}}
    mychart.setOption(option);
    charts.push(mychart);

    {{--二级菜单对应的曲线图--}}
    mychart=echarts.init(mainone);
    {{--// 指定图表的配置项和数据--}}
    option = {
    xAxis: {
    type: 'category',
    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
    },
    yAxis: {
    type: 'value'
    },
    series: [{
    data: [1, 932, 901, 934, 1290, 1330, 2000],
    type: 'line',
    smooth: true
    }]
    };

    {{--// 使用刚指定的配置项和数据显示图表。--}}
    mychart.setOption(option);
    charts.push(mychart);
    window.onresize = function(){
    for(var i = 0;i< charts.length;i++){
        charts[i].resize();
    }
    }
    });

    {{--};--}}


@endsection
