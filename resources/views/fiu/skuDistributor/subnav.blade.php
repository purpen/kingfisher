<ul class="nav navbar-nav nav-list">
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/fiu/skuDistributor/search')}}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"  value="{{$search}}" placeholder="sku名称、分销">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                </div>
            </div>
        </form>
    </li>
</ul>