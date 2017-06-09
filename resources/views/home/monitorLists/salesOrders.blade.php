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
                    <li class="active"><a href="{{url('/salesOrders')}}">销售订单</a></li>
                    <li><a href="{{url('/ESSalesOrders')}}">电商销售订单</a></li>
                    <li><a href="{{url('/salesInvoices')}}">销售发票</a></li>
                    <li><a href="{{url('/deliveries')}}">配送数据</a></li>
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
                            <th>ID</th>
                            <th>订单编号</th>
                            <th>订单日期</th>
                            <th>客户名称</th>
                            <th>商品名称</th>
                            <th>规格型号</th>
                            <th>单位</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>订单金额</th>
                            <th>订单状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($salesOrders as $salesOrder)
                            <tr>
                                <td>{{ $salesOrder->id }}</td>
                                <td>{{ $salesOrder->number }}</td>
                                <td>{{ $salesOrder->order_start_time }}</td>
                                <td>{{ $salesOrder->buyer_name }}</td>
                                <td>{{ $salesOrder->product_name }}</td>
                                <td>{{ $salesOrder->mode }}</td>
                                <td>{{ $salesOrder->weight }}</td>
                                <td>{{ $salesOrder->unit_price }}</td>
                                <td>{{ $salesOrder->count }}</td>
                                <td>{{ $salesOrder->pay_money }}</td>
                                <td>{{ $salesOrder->status_val }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($salesOrders)
            <div class="row">
                <div class="col-md-12 text-center">{!! $salesOrders->render() !!}</div>
            </div>
        @endif
    </div>
@endsection
@section('customize_js')
    @parent

@endsection