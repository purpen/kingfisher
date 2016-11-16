@extends('home.base')

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
                        退款管理
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    @include('home.refund.subnav')
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                <tr class="gblack">
                    <th class="text-center">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>
                        提醒
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
                            </ul>
                        </div>
                    </th>
                    <th>订单状态</th>
                    <th>
                        来源店铺
                    </th>
                    <th>退单编号</th>
                    <th>平台退款单号</th>
                    <th>订单编号</th>
                    <th>平台订单号</th>
                    <th>买家账号</th>
                    <th>买家姓名</th>
                    <th>退款金额</th>
                    <th>买家申请原因</th>
                    <th>操作</th>
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
                        <td>
                            <span>{{$refund->number}}</span><br/>
                            <small class="text-muted">{{$refund->apply_time}}</small>
                        </td>
                        <td>{{$refund->out_refund_money_id}}</td>
                        <td>{{$refund->order->number}}</td>
                        <td>{{$refund->out_order_id}}</td>
                        <td>{{$refund->out_buyer_id}}</td>
                        <td>{{$refund->out_buyer_name}}</td>
                        <td>{{$refund->amount}}</td>
                        <td>{{$refund->summary}}</td>
                        <td tdr="nochect">
                            <button class="btn btn-gray btn-sm mr-2r consentRefund" type="button" value="{{$refund->id}}">同意</button>
                            <button class="btn btn-gray btn-sm mr-2r rejectRefund" type="button" value="{{$refund->id}}" active="1">拒绝</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($refunds)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">{!! $refunds->render() !!}</div>
        </div>
        @endif
    </div>
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();
    $(".consentRefund").click(function () {
        if(confirm("确认同意退款！")){
            var refund_id = $(this).attr('value');
            var button_this = $(this);
            $.post('{{url('/refundMoney/ajaxConsentRefund')}}',{'_token':_token,'refund_id':refund_id},function (e) {
                if(e.status){
                    button_this.parent().parent().remove();
                }
            },'json');
        }
    });

    $(".rejectRefund").click(function () {
        if(confirm("确认拒绝退款！")){
            var refund_id = $(this).attr('value');
            var button_this = $(this);
            $.post('{{url('/refundMoney/ajaxRejectRefund')}}',{'_token':_token,'refund_id':refund_id},function (e) {
                if(e.status){
                    button_this.parent().parent().remove();
                }
            },'json');
        }
    });
@endsection