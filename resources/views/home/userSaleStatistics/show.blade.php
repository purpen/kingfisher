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
                    销售明细
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/order/userSaleList')}}" method="POST">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="user_id_sales" value="{{$user_id_sales}}">
                            <div class="form-group mr-2r">
                                <a href="{{ url('/order/userSaleList') }}?user_id_sales={{ $user_id_sales }}&time=7" class="btn btn-link">最近7天</a>
                                <a href="{{ url('/order/userSaleList') }}?user_id_sales={{ $user_id_sales }}&time=30" class="btn btn-link">最近30天</a>
                            </div>
                            <div class="form-group mr-2r">
                                <label class="control-label">日期：</label>
                                <input type="text" name="start_date" class="pickdatetime form-control" value="{{ $start_date }}" placeholder="开始日期">
                                至
                                <input type="text" name="end_date" class="pickdatetime form-control" value="{{ $end_date }}" placeholder="结束日期">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">查询</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            
            <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong id="showtext"></strong>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="control-label">{{ $username }} / </label>
                            <label class="control-label">销售额：{{ $money_sum }} 元</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="datatable-length">
                        <select class="form-control selectpicker input-sm" name="per_page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="datatable-info ml-r">
                        条/页，显示 {{ $order_list->firstItem() }} 至 {{ $order_list->lastItem() }} 条，共 {{ $order_list->total() }} 条记录
                    </div>
                </div>
            </div>
            
            <div class="row scroll">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">提醒</span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">提醒</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">退款</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">锁单</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">无法送达</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">货到付款</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">预售</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                状态
                            </th>
                            <th>
                                店铺名
                            </th>
                            <th>订单号/下单时间</th>
                            <th>买家</th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">买家备注</span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">有买家备注</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">无买家备注</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        <span class="title">卖家备注</span>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">有卖家备注</a>
                                        </li>
                                        <li role="lichoose">
                                            <a role="menuitem" tabindex="-1" href="javascript:void(0);">无卖家备注</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th>
                                物流/运单号
                            </th>
                            <th>
                                数量
                            </th>
                            <th>实付/运费</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_list as $order)
                            <tr>
                                <td class="text-center">
                                    <input name="Order" class="sku-order" type="checkbox" active="0" value="{{ $order->id }}">
                                </td>
                                <td></td>
                                <td>
                                    @if (in_array($order->status, array(0)))
                                        <span class="label label-default">{{$order->status_val}}</span>
                                    @endif

                                    @if (in_array($order->status, array(1,5,8)))
                                        <span class="label label-danger">{{$order->status_val}}</span>
                                    @endif

                                    @if (in_array($order->status, array(10,20)))
                                        <span class="label label-success">{{$order->status_val}}</span>
                                    @endif
                                </td>
                                <td>{{$order->store->name}}</td>
                                <td class="magenta-color">
                                    <span>{{$order->number}}</span><br>
                                    <small class="text-muted">{{$order->order_start_time}}</small>
                                </td>
                                <td>{{$order->buyer_name}}</td>
                                <td>{{$order->buyer_summary}}</td>
                                <td>{{$order->seller_summary}}</td>
                                <td>
                                    <span>{{$order->logistics->name}}</span><br>
                                    <small class="text-muted">{{$order->express_no}}</small>
                                </td>
                                <td>{{$order->count}}</td>
                                <td>{{$order->pay_money}} / {{$order->freight}}</td>
                                <td tdr="nochect">
                                    <button class="btn btn-gray btn-sm show-order mb-2r" type="button" value="{{$order->id}}" active="1">
                                        <i class="glyphicon glyphicon-eye-open"></i> 查看
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order_list)
            <div class="row">
                <div class="col-md-12 text-center">{!! $order_list->appends(['user_id_sales' => $user_id_sales])->render() !!}</div>
            </div>
            @endif
        </div>
    </div>
    @include('home/userSaleStatistics.orderInfo')
@endsection

@section('customize_js')
    @parent

@endsection


@section('load_private')
    @parent
        $(".show-order").click(function() {
            var skus = [];
            $(".order-list").remove();
            var order = $(this).parent().parent();
            var obj = $(this);
            if ($(this).attr("active") == 1) {
                var id = $(this).attr("value");
                $.get('{{url('/order/ajaxEdit')}}',{'id':id},function (e) {
                    if(e.status){
                        var template = $('#order-info-form').html();
                        var views = Mustache.render(template, e.data);

                        order.after(views);

                        obj.attr("active", 0);


                        {{--收回详情--}}
                        $("#fold").click(function () {
                            $(".order-list").remove();
                            obj.attr("active",1);
                        });


                    }else{
                        alert(e.message);
                        return false;
                    }
                },'json');
            }else{
                $(".order-list").remove();
                $(this).attr("active",1);
            }

        });
@endsection