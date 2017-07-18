<ul class="nav navbar-nav nav-list">
    @if(!empty($product_id))
    <li @if($type == 'article')class="active" @endif><a href="{{url('/article')}}/{{$product_id}}">相关文章</a></li>
    @endif
    <li @if($type == 'all')class="active" @endif><a href="{{url('/articles')}}">全部文章</a></li>
</ul>
