@extends('home.base')

@section('title', '退款')
@section('customize_css')
    @parent
    .bnonef{
    padding:0;
    box-shadow:none !important;
    background:none;
    color:#fff !important;
    }
    #form-user,#form-product,#form-jyi,#form-beiz {
    height: 225px;
    overflow: scroll;
    }
    .scrollspy{
    height:180px;
    overflow: scroll;
    margin-top: 10px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        退款
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li><a href="{{url('/refund')}}">退款</a></li>
                        <li class="active"><a href="{{url('/refund/consentList')}}">同意退款</a></li>
                        <li><a href="{{url('/refund/rejectList')}}">拒绝退货</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right mr-0">
                        <li class="dropdown">
                            <form class="navbar-form navbar-left" role="search" id="search" action="" method="POST">
                                <div class="form-group">
                                    <input type="text" name="where" class="form-control" placeholder="">
                                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                                </div>
                                <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row scroll">
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
                                {{--
                                <li role="presentation" class="sort" type="up">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                        <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                    </a>
                                </li>
                                <li role="presentation" class="sort" type="down">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                        <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                    </a>
                                </li>--}}
                                <li role="lichoose">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0);">提醒</a>
                                </li>
                            </ul>
                        </div>
                    </th>
                    <th>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                <span class="title">状态</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                <li role="lichoose" class="sort" type="up">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                        <span class="glyphicon glyphicon-arrow-up"></span> 升序
                                    </a>
                                </li>
                                <li role="lichoose" class="sort" type="down">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0);">
                                        <span class="glyphicon glyphicon-arrow-down"></span> 降序
                                    </a>
                                </li>
                                <li class="divider"></li>
                            </ul>
                        </div>
                    </th>
                    <th>订单状态</th>
                    <th>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle bnonef" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                <span class="title">店铺名</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                            </ul>
                        </div>
                    </th>
                    <th>退单编号</th>
                    <th>平台退款单号</th>
                    <th>申请时间</th>
                    <th>订单编号</th>
                    <th>平台订单号</th>
                    <th>买家账号</th>
                    <th>买家姓名</th>
                    <th>退款金额</th>
                    <th>买家申请原因</th>
                </tr>
                </thead>
                <tbody>
                @foreach($refunds as $refund)
                    <tr>
                        <td class="text-center">
                            <input name="Order" class="sku-order" type="checkbox" active="0" value="1" refund_id="{{$refund->id}}">
                        </td>
                        <td></td>
                        <td>{{$refund->status_name}}</td>
                        <td>{{$refund->order->status_val}}</td>
                        <td>{{$refund->store->name}}</td>
                        <td>{{$refund->number}}</td>
                        <td>{{$refund->out_refund_money_id}}</td>
                        <td>{{$refund->apply_time}}</td>
                        <td>{{$refund->order->number}}</td>
                        <td>{{$refund->out_order_id}}</td>
                        <td>{{$refund->out_buyer_id}}</td>
                        <td>{{$refund->out_buyer_name}}</td>
                        <td>{{$refund->amount}}</td>
                        <td>{{$refund->summary}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($refunds)
            <div class="col-md-6 col-md-offset-6">{!! $refunds->render() !!}</div>
        @endif
    </div>
    </div>
@endsection
@section('customize_js')
    @parent

@endsection