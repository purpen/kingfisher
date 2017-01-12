<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'verifying')class="active"@endif><a href="{{url('/supplier/verifyList')}}">待审核</a></li>
    <li @if($tab_menu == 'verified')class="active"@endif><a href="{{url('/supplier')}}">已审核</a></li>
    <li @if($tab_menu == 'close')class="active"@endif><a href="{{url('/supplier/closeList')}}">已关闭</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/supplier/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="nam" class="form-control" value="{{$nam}}" placeholder="公司简称">
                    <div class="input-group-btn">
                        <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </div>
        </form>
    </li>
</ul>