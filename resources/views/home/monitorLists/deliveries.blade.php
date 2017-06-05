@extends('home.base')

@section('customize_css')
    @parent
    .check-btn{
    padding: 10px 0;
    height: 30px;
    position: relative;
    margin-bottom: 10px !important;
    margin-left: 10px !important;
    }
    .check-btn input{
    z-index: 2;
    width: 100%;
    height: 100%;
    top: 6px !important;
    opacity: 0;
    left: 0;
    margin-left: 0 !important;
    color: transparent;
    background: transparent;
    cursor: pointer;
    }
    .check-btn button{
    position: relative;
    top: -11px;
    left: 0;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    监控报表
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li><a href="{{url('/purchases')}}">采购订单</a></li>
                    <li><a href="{{url('/pInvoices')}}">采购发票</a></li>
                    <li><a href="{{url('/salesOrders')}}">销售订单</a></li>
                    <li><a href="{{url('/ESSalesOrders')}}">电商销售订单</a></li>
                    <li><a href="{{url('/salesInvoices')}}">销售发票</a></li>
                    <li class="active"><a href="{{url('/deliveries')}}">配送数据</a></li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-12">
                    <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong id="showtext"></strong>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th>用户ID</th>
                            <th>订单编号</th>
                            <th>订单日期</th>
                            <th>配送单编号</th>
                            <th>配送日期</th>
                            <th>商品名称</th>
                            <th>规格型号</th>
                            <th>单位</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>订单状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($deliveries as $delivery)
                            <tr>
                                <td>{{ $delivery->id }}</td>
                                <td>{{ $delivery->number }}</td>
                                <td>{{ $delivery->order_start_time }}</td>
                                <td>{{ $delivery->express_no }}</td>
                                <td>{{ $delivery->order_send_time }}</td>
                                <td>{{ $delivery->product_name }}</td>
                                <td>{{ $delivery->mode }}</td>
                                <td>{{ $delivery->weight }}</td>
                                <td>{{ $delivery->unit_price }}</td>
                                <td>{{ $delivery->count }}</td>
                                <td>{{ $delivery->status_val }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($deliveries)
            <div class="row">
                <div class="col-md-12 text-center">{!! $deliveries->render() !!}</div>
            </div>
        @endif
    </div>
@endsection
@section('customize_js')
    @parent

@endsection