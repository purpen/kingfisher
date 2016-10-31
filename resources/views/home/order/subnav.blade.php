<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'all')class="active"@endif><a href="{{url('/order')}}">全部订单</a></li>
    <li @if($tab_menu == 'waitpay')class="active"@endif><a href="{{url('/order/nonOrderList')}}">待付款</a></li>
    <li @if($tab_menu == 'waitcheck')class="active"@endif><a href="{{url('/order/verifyOrderList')}}">待审核</a></li>
    <li @if($tab_menu == 'waitsend')class="active"@endif><a href="{{url('/order/sendOrderList')}}">待发货</a></li>
    <li @if($tab_menu == 'sended')class="active"@endif><a href="{{url('/order/completeOrderList')}}">已发货</a></li>
    <li @if($tab_menu == 'servicing')class="active"@endif><a href="{{url('/order/servicingOrderList')}}">售后中</a></li>
    <li @if($tab_menu == 'finished')class="active"@endif><a href="{{url('/order/finishedOrderList')}}">已完成</a></li>
    <li @if($tab_menu == 'closed')class="active"@endif><a href="{{url('/order/closedOrderList')}}">已关闭</a></li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action=" " method="POST">
            <div class="form-group">
                <input type="text" name="q" class="form-control" placeholder="订单号">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>