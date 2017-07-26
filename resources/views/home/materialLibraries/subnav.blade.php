<ul class="nav navbar-nav nav-list">
    <li @if($type == 1)class="active"@endif ><a href="{{url('/saas/image')}}">图片</a></li>
    <li @if($type == 3)class="active"@endif><a href="{{url('/saas/describe')}}">文字段</a></li>
    <li @if(!in_array($type,[1,2,3]))class="active"@endif><a href="{{url('/saas/article')}}">文章</a></li>
    <li @if($type == 2)class="active"@endif><a href="{{url('/saas/video')}}">视频</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/saas/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="search"  class="form-control" value="{{$search}}" placeholder="商品编号、名称">
                    <input type="hidden" name="type"  class="form-control" value="{{$type}}">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                </div>
            </div>
        </form>
    </li>
</ul>
