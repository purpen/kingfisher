<ul class="nav navbar-nav nav-list">
    <li @if($verified == 0)class="active"@endif><a href="{{url('/purchase')}}">待采购审核 @if($count['waiting']>0)<span class="badge">{{$count['waiting']}}</span>@endif</a></li>
    <li @if($verified == 1)class="active"@endif><a href="{{url('/purchase/purchaseStatus')}}?verified=1">业管主管审核 @if($count['directing']>0)<span class="badge">{{$count['directing']}}</span>@endif</a></li>
    <li @if($verified == 9)class="active"@endif><a href="{{url('/purchase/purchaseStatus')}}?verified=9">审核已完成</a></li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/purchase/search') }}" method="POST">
            <div class="form-group">
                <input type="text" name="where" class="form-control" placeholder="编号、制单人、供应商、仓库">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>