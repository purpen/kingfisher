<ul class="nav navbar-nav nav-list">
    <li @if($subnav == 'checkpay')class="active"@endif><a href="{{url('/payment')}}">待财务审核 @if($count)<span class="badge">{{$count}}</span>@endif</a></li>
    <li @if($subnav == 'waitpay')class="active"@endif><a href="{{url('/payment/payableList')}}">应付款</a></li>
    <li @if($subnav == 'finishpay')class="active"@endif><a href="{{url('/payment/completeList')}}">已付款</a></li>
</ul>

<ul class="nav navbar-nav navbar-right mr-0">
    <li class="dropdown">
        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/payment/search')}}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group mr-2r">
                <label class="control-label">快速查看：</label>
                <a href="" class="btn btn-link">最近7天</a> 
                <a href="" class="btn btn-link">最近30天</a>
            </div>
            <div class="form-group mr-2r">
                <label class="control-label">筛选日期：</label>
                <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期">
                至
                <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="where" class="form-control" placeholder="编号">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </div>
        </form>
    </li>
</ul>