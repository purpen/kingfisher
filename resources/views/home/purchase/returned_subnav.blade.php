<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav nav-list">
        <li @if ($tab_menu == 'waiting')class="active"@endif>
            <a href="{{url('/returned')}}">待审核 @if($count['waiting']>0)<span class="badge">{{$count['waiting']}}</span>@endif</a>
        </li>
        <li @if ($tab_menu == 'approved')class="active"@endif>
            <a href="{{url('/returned/returnedStatus')}}?verified=1">业管主管审核 @if($count['approved']>0)<span class="badge">{{$count['approved']}}</span>@endif</a>
        </li>
        <li @if ($tab_menu == 'finished')class="active"@endif>
            <a href="{{url('/returned/returnedStatus')}}?verified=9">审核已完成</a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right mr-0">
        <li class="dropdown">
            <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/returned/search')}}" method="POST">
                <div class="form-group">
                    <input type="text" name="q" class="form-control" placeholder="采购退货单编号">
                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                </div>
                <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
            </form>
        </li>
    </ul>
</div>