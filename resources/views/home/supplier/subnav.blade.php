
<ul class="nav navbar-nav nav-list">
    <li @if($status == 0)class="active"@endif><a href="{{url('/supplier')}}">全部</a></li>
    <li @if($status == 1)class="active"@endif><a href="{{url('/supplier?status=1')}}">待审核</a></li>
    <li @if($status == 2)class="active"@endif><a href="{{url('/supplier?status=2')}}">已审核</a></li>
    <li @if($status == 3)class="active"@endif><a href="{{url('/supplier?status=3')}}">未通过</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/supplier/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="hidden" name="status" value="{{$status}}">
                    <input type="text" name="nam" class="form-control" style="max-width: 100%;width: 400px" value="{{$nam}}" placeholder="公司全称、品牌、联系人">
                    <div class="input-group-btn">
                        {{--<button id="supplier-search" type="submit" class="btn btn-default">搜索</button>--}}
                        <button id="supplier-search" type="submit" class="btn btn-default">搜索</button>
                    </div><!-- /btn-group -->
                </div><!-- /input-group -->
            </div>
        </form>
    </li>
</ul>