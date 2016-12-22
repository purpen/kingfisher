<ul class="nav navbar-nav nav-list">
    <li @if($subnav == 'checkpay')class="active"@endif><a href="{{url('/payment')}}">待财务审核 @if($count)<span class="badge">{{$count}}</span>@endif</a></li>
    <li @if($subnav == 'waitpay')class="active"@endif><a href="{{url('/payment/payableList')}}">应付款</a></li>
    <li @if($subnav == 'finishpay')class="active"@endif><a href="{{url('/payment/completeList')}}">已付款</a></li>
</ul>

<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" action="{{url('/payment/search')}}" id="search" method="POST">
            <div class="form-group">
                <input type="text" name="where" class="form-control" placeholder="付款单号,收款人">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            </div>
            <button id="purchase-search" type="submit" class="btn btn-default">搜索</button>
        </form>
    </li>
</ul>