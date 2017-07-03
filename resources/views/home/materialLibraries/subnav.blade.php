<ul class="nav navbar-nav nav-list">
    <li @if($type == 1)class="active"@endif ><a href="{{url('/image')}}/{{$product_id}}">图片</a></li>
    <li @if($type == 2)class="active"@endif><a href="{{url('/video')}}/{{$product_id}}">视频</a></li>
    <li @if($type == 3)class="active"@endif><a href="{{url('/describe')}}/{{$product_id}}">文字段</a></li>
</ul>
