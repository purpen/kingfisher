<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'all')class="active"@endif><a  href="{{url('/order')}}">全部</a></li>
    <li @if($tab_menu == 'waitpay')class="active"@endif><a href="{{url('/order/nonOrderList')}}">待付款</a></li>
    <li @if($tab_menu == 'waitcheck')class="active"@endif><a href="{{url('/order/verifyOrderList')}}">待审核</a></li>
{{--    <li @if($tab_menu == 'finance')class="active"@endif><a href="{{url('/order/financeOrderList')}}">待财务审核</a></li>--}}
    <li @if($tab_menu == 'waitsend')class="active"@endif><a href="{{url('/order/sendOrderList')}}">待发货</a></li>
    <li @if($tab_menu == 'sended')class="active"@endif><a href="{{url('/order/completeOrderList')}}">已发货</a></li>
    <li @if($tab_menu == 'servicing')class="active"@endif><a href="{{url('/order/servicingOrderList')}}">售后中</a></li>
    <li @if($tab_menu == 'finished')class="active"@endif><a href="{{url('/order/finishedOrderList')}}">已完成</a></li>
    <li @if($tab_menu == 'closed')class="active"@endif><a href="{{url('/order/closedOrderList')}}">已关闭</a></li>
    <li  @if($tab_menu == 'closed')class="active"@endif><a style="color: red;;border-bottom:1px solid red;"   href="{{url('/invoice/lists')}}">发票记录</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/invoice/lists')}}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

            <select style="width: 130px;height: 34px;" name="receiving_id">
                <option value ="0">请选择</option>
                <option value ="1">增值税普通发票</option>
                <option value="2">增值税专用发票</option>
            </select>
            <div class="form-group mr-2r">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="order_number" value="{{$order_number}}" class="form-control" placeholder="订单号">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>

                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </div>
        </form>
    </li>
</ul>