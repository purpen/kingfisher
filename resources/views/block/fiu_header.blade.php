<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
        <!-- Branding Image -->
        <a class="navbar-brand logo">
            <img id="fiu_logo" src="{{ url('images/fiu_log.png') }}" class="img-responsive" alt="fiu_logo" title="fiu_logo">
        </a>
    </div>

    <div class="navbar-collapse collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
            <li class="dropdown"><a href="{{ url('/fiu/home') }}">首页</a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="dropdown"><a href="{{ url('/fiu/saasProduct/lists') }}">商品管理</a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="dropdown"><a href="{{ url('/fiu/saas/image/noStatus') }}">素材管理</a></li>
        </ul>
        {{--<ul class="nav navbar-nav">--}}
            {{--<li class="dropdown"><a href="{{ url('/fiu/home') }}">订单管理</a></li>--}}
        {{--</ul>--}}
        <ul class="nav navbar-nav">
            <li class="dropdown"><a href="{{ url('/fiu/saas/user/allStatus') }}">分销商管理</a></li>
        </ul>
        {{--<ul class="nav navbar-nav">--}}
            {{--<li class="dropdown"><a href="{{ url('/fiu/site') }}">站点管理</a></li>--}}
        {{--</ul>--}}
        <ul class="nav navbar-nav">
            <li class="dropdown"><a href="{{url('/fiu/saas/skuDistributor')}}">SKU分销管理</a></li>
        </ul>

        <ul class="nav navbar-nav">
            <li class="dropdown">

                <a href="javascript:void(0);" class="dropdown-toggle" type="button" id="dropdownMenu8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">

                <li class="dropdown"><a href="{{ url('/home') }}">erp后台</a></li>
                <li class="dropdown"><a href="{{ url('/fiu/saasFeedback') }}">用户反馈</a></li>
                </ul>

            </li>
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right mr-r">

            <!-- Authentication Links -->
            @if (Auth::guest())
               <li class="dropdown">
                    <a href="{{ url('/login') }}" class="transparent btn-magenta btn"> 登录</a>
                    <a href="{{ url('/register') }}" class="transparent btn-magenta btn"> 注册</a>
                </li>
            @else
                <li class="dropdown">
                    <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-bell"></span>
                    </a>
                    <ul class="dropdown-menu mr-r" aria-labelledby="dropdownMenu7">
                        <li>
                            <div class="ptb-4r plr-4r">
                                暂时没有新的提醒哦 ...
                            </div>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="javascript:void(0);" class="transparent dropdown-toggle" type="button" id="dropdownMenu8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="user img-circle" src="{{ Auth::user()->cover ?  Auth::user()->cover->file->avatar : url('images/default/headportrait.jpg') }}" align="absmiddle"> {{Auth::user()->account}}
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </a>
                    <ul class="dropdown-menu mr-3r" aria-labelledby="dropdownMenu8">
                        {{--<li><a href="{{ url('/user/edit') }}">个人资料</a></li>--}}
                        <li><a href="{{url('/logout')}}">退出</a></li>
                    </ul>
                </li>
            @endif
        </ul>

    </div>
</nav>