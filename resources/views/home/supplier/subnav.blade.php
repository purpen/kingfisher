<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'verifying')class="active"@endif><a href="{{url('/supplier/verifyList')}}">待审核</a></li>
    <li @if($tab_menu == 'verified')class="active"@endif><a href="{{url('/supplier')}}">已审核</a></li>
    <li @if($tab_menu == 'close')class="active"@endif><a href="{{url('/supplier/closeList')}}">已关闭</a></li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/supplier/search') }}" method="POST">
            <div class="form-group">
                <input type="text" name="nam" class="form-control" placeholder="公司简称">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>