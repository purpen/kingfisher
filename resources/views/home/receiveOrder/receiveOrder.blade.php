@extends('home.base')

@section('customize_js')
    @parent
    var _token = $("#_token").val();

@endsection

@section('load_private')
    @parent

    {{--按时时间、类型导出--}}
    $("#receive-excel-1").click(function () {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        if(start_date == '' || end_date == ''){
            alert('请选择时间');
        }else{
            post('{{url('/dateGetReceiveExcel')}}',{'start_date':start_date,'end_date':end_date});
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
                    收入报表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/receiveExcel/search')}}" method="POST">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

                            <div class="form-group mr-2r">
                                <a href="{{url('/receiveExcel/search')}}?time=7" class="btn btn-link">最近7天</a>
                                <a href="{{url('/receiveExcel/search')}}?time=30" class="btn btn-link">最近30天</a>
                            </div>
                            <div class="form-group mr-2r">
                                <label class="control-label">日期：</label>
                                <input type="text" id="start_date" name="start_date" class="pickdatetime form-control" placeholder="开始日期" value="{{$start_date or ''}}">
                                至
                                <input type="text" id="end_date" name="end_date" class="pickdatetime form-control" placeholder="结束日期" value="{{$end_date or ''}}">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default">查询</button>
                                    </div><!-- /btn-group -->
                                </div><!-- /input-group -->
                            </div>
                        </form>
                    </li>
                </ul>
            </div>        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">

                    <div class="form-group">
                        <button type="button" id="receive-excel-1" class="btn btn-white mr-2r">
                            <i class="glyphicon glyphicon-arrow-up"></i> 条件导出
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th>销售主体</th>
                    <th>销售产品</th>
                    <th>品牌</th>
                    <th>销售模式</th>
                    <th>客户名称</th>
                    <th>销售时间</th>
                    <th>销售数量</th>
                    <th>销售金额</th>
                    <th>成本金额</th>
                    <th>开票时间</th>
                    <th>开票金额</th>
                    <th>收款时间</th>
                    <th>收款金额</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($receiveOrder as $v)
                        <tr>
                            <td>{{$v->department_name}}</td>
                            <td>{{$v->product_title}}</td>
                            <td>{{$v->supplier_name}}</td>
                            <td>{{$v->order_type}}</td>
                            <td>{{$v->buyer_name}}</td>
                            <td>{{$v->order_start_time}}</td>
                            <td>{{$v->quantity}}</td>
                            <td>{{$v->price}}</td>
                            <td>{{$v->cost_price}}</td>
                            <td>{{$v->invoice_start_time}}</td>
                            <td>{{$v->total_money}}</td>
                            <td>{{$v->receive_time}}</td>
                            <td>{{$v->amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="row">
            @if ($receiveOrder)
                <div class="col-md-12 text-center">{!! $receiveOrder->appends(['start_date' => $start_date, 'end_date' => $end_date])->render() !!}</div>
            @endif
        </div>
    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
