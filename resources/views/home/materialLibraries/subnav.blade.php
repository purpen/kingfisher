<ul class="nav navbar-nav nav-list">
    <li @if($type == 1)class="active"@endif ><a href="{{url('/saas/image')}}">图片</a></li>
    <li @if($type == 2)class="active"@endif><a href="{{url('/saas/video')}}">视频</a></li>
    <li @if($type == 3)class="active"@endif><a href="{{url('/saas/describe')}}">文字段</a></li>
</ul>
