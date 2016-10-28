<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'all')class="active"@endif><a href="{{url('/refund')}}">退款申请</a></li>
    <li @if($tab_menu == 'agree')class="active"@endif><a href="{{url('/refund/consentList')}}">同意退款</a></li>
    <li @if($tab_menu == 'reject')class="active"@endif><a href="{{url('/refund/rejectList')}}">拒绝退款</a></li>
</ul>
<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="" method="POST">
            <div class="form-group">
                <input type="text" name="where" class="form-control" placeholder="">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>