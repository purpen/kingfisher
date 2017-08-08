<ul class="nav navbar-nav nav-list">
    @if($type == 1)
        @if(!empty($product_id))
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/image/noStatus')}}?id={{$product_id}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/image')}}?id={{$product_id}}">已审核</a></li>
        @else
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/image/noStatus')}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/image')}}">已审核</a></li>
        @endif
    @endif
    @if($type == 2)
        @if(!empty($product_id))
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/video/noStatus')}}?id={{$product_id}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/video')}}?id={{$product_id}}">已审核</a></li>
        @else
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/image/noStatus')}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/image')}}">已审核</a></li>
        @endif
    @endif
    @if($type == 3)
        @if(!empty($product_id))
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/describe/noStatus')}}?id={{$product_id}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/describe')}}?id={{$product_id}}">已审核</a></li>
        @else
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/describe/noStatus')}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/describe')}}">已审核</a></li>
        @endif
    @endif
    @if($type == 4)
        @if(!empty($product_id))
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/article/noStatus')}}?id={{$product_id}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/article')}}?id={{$product_id}}">已审核</a></li>
        @else
            <li @if($status == 0)class="active"@endif ><a href="{{url('/fiu/saas/article/noStatus')}}">草稿箱</a></li>
            <li @if($status == 1)class="active"@endif><a href="{{url('/fiu/saas/article')}}">已审核</a></li>
        @endif
    @endif
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/fiu/saas/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="search"  class="form-control" value="{{$search}}" placeholder="商品编号、名称">
                    <input type="hidden" name="type"  class="form-control" value="{{$type}}">
                    <input type="hidden" name="status"  class="form-control" value="{{$status}}">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                </div>
            </div>
        </form>
    </li>
</ul>
