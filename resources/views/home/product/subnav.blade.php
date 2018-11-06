<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'default')class="active"@endif><a href="{{url('/product')}}">全部</a></li>
    <li @if($tab_menu == 'unpublish')class="active"@endif><a href="{{url('/product/unpublishList')}}">待上架</a></li>
    <li @if($tab_menu == 'saled')class="active"@endif><a href="{{url('/product/saleList')}}">在售中</a></li>
    <li @if($tab_menu == 'canceled')class="active"@endif><a href="{{url('/product/cancList')}}">已取消</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/product/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="search" style="max-width: 100%;width: 200px"  class="form-control" value="{{$name}}" placeholder="编号、简称、SKU">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                </div>
            </div>
        </form>
    </li>
</ul>