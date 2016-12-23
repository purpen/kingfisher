<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'default')class="active"@endif><a href="{{url('/product')}}">全部</a></li>
    <li @if($tab_menu == 'unpublish')class="active"@endif><a href="{{url('/product/unpublishList')}}">待上架</a></li>
    <li @if($tab_menu == 'saled')class="active"@endif><a href="{{url('/product/saleList')}}">在售中</a></li>
    <li @if($tab_menu == 'canceled')class="active"@endif><a href="{{url('/product/cancList')}}">已取消</a></li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/product/search') }}" method="POST">
            <div class="form-group">
                <input type="text" name="q" class="form-control" placeholder="商品货号、名称">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>