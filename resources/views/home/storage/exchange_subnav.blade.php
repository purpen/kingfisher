<ul class="nav navbar-nav nav-list">
    <li class="active"><a href="{{url('/changeWarehouse')}}">待审核 ({{$count_arr['count_0']}})</a></li>
    <li><a href="{{url('/changeWarehouse/verify')}}">业管主管审核 ({{$count_arr['count_1']}})</a></li>
    <li><a href="{{url('/changeWarehouse/completeVerify')}}">审核已完成</a></li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="#" method="POST">
            <div class="form-group">
                <input type="text" name="where" class="form-control" placeholder="">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>