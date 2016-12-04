<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'saled')class="active"@endif><a href="{{url('/outWarehouse/orderOut')}}">订单出库</a></li>
    <li @if($tab_menu == 'waiting')class="active"@endif><a href="{{url('/outWarehouse')}}">采购退货出库</a></li>
    <li @if($tab_menu == 'exchanged')class="active"@endif><a href="{{url('/outWarehouse/changeOut')}}">调拨出库</a></li>
    <li @if($tab_menu == 'finished')class="active"@endif><a href="{{url('/outWarehouse/complete')}}">已完成出库</a></li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="" method="POST">
            <div class="form-group">
                <input type="text" name="where" class="form-control" placeholder="编号">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>