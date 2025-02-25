<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'waiting')class="active"@endif><a href="{{url('/enterWarehouse')}}">采购入库</a></li>
    <li @if($tab_menu == 'exchange')class="active"@endif><a href="{{url('/enterWarehouse/changeEnter')}}">调拨入库</a></li>
    {{--<li @if($tab_menu == 'refund')class="active"@endif><a href="">销售退货入库</a></li>--}}
    <li @if($tab_menu == 'completed')class="active"@endif><a href="{{url('/enterWarehouse/complete')}}">已完成入库</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/enterWarehouse/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="number" value="{{$number}}" class="form-control" placeholder="入库单编号">
                    <div class="input-group-btn">
                        <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </div>
        </form>
    </li>
</ul>