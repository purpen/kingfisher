<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'waitcheck')class="active"@endif>
        <a href="{{url('/changeWarehouse')}}">
            待审核 @if($tab_count['waitcheck'])<span class="badge">{{$tab_count['waitcheck']}}</span>@endif
        </a>
    </li>
    <li @if($tab_menu == 'verified')class="active"@endif>
        <a href="{{url('/changeWarehouse/verify')}}">
            业管主管审核 @if($tab_count['verifing'])<span class="badge">{{$tab_count['verifing']}}</span>@endif
        </a>
    </li>
    <li @if($tab_menu == 'finished')class="active"@endif>
        <a href="{{url('/changeWarehouse/completeVerify')}}">审核已完成</a>
    </li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/changeWarehouse/search') }}" method="POST">
            <div class="form-group">
                <input type="text" name="number" class="form-control" placeholder="编号">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>