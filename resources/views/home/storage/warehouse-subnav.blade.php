<ul class="nav navbar-nav nav-list">
    <li class="active"><a href="{{url('/enterWarehouse')}}">采购入库</a></li>
    <li><a href="">销售退货入库</a></li>
    <li><a href="{{url('/enterWarehouse/changeEnter')}}">调拨入库</a></li>
    <li><a href="{{url('/enterWarehouse/complete')}}">完成入库</a></li>
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