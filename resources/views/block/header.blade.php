
@section('customize_css')
    @parent
        .navbar-default{
            background-color: #fff;
            border-color: #FF3366;
        }
        .header,.navbar-header,.navbar-brand,.navbar-nav li a{
            height:80px;
        }
        #logo{
            height:100%;
        }
        .navbar-brand{
            padding-top: 10px;
        }
        .navbar-nav li a{
            padding-top: 32px;
            font-size: 16px;
            font-weight: 800;
        }
        .navbar-nav > .active > a{
            color: #FF3366 !important;
        }
        .navbar-nav li:hover{
            background-color: #e7e7e7;
        }
        .navbar-nav li a:hover{
            color: #FF3366 !important;
        }
        .dropdown-toggle{
            padding-top: 20px !important;
        }
        .dropdown-menu{
            min-width: 0;
        }
        .dropdown-menu > li{
            height: 44px;
        }
        .dropdown-menu > li > a{
            height: 44px;
            padding-top: 12px;
        }
        .dropdown-menu > li:hover{
            background: #eee;
        }
@endsection

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid header">
            
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img id="logo" src="{{ url('images/logo.png') }}" class="img-responsive" alt="logo" title="logo">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ url('/home') }}">首页</a></li>
                    <li><a href="{{ url('/article') }}">客服</a></li>
                    <li><a href="{{ url('/article') }}">订单处理</a></li>
                    <li><a href="{{ url('/article') }}">库管</a></li>
                    <li><a href="{{ url('/article') }}">采购</a></li>
                    <li><a href="{{ url('/article') }}">运营</a></li>
                    <li><a href="{{ url('/article') }}">财务</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        
                        <li><a href="{{ url('/login') }}">登录</a></li>
                        <li><a href="{{ url('/register') }}">注册</a></li>
                    @else    
                        <li>
                            <a href="{{ url('/message') }}">
                                <i class="fa fa-bell"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img id="topheadportrait" width=40 style="display:inline-block" class="img-responsive center-block img-circle" src="{{ url('images/default/headportrait.jpg') }}" alt="headportrait" title="headportrait">
                                &nbsp;<span>caowei</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-btn fa-cog"></i>帐号设置</a></li>
                                <li><a href="/logout"><i class="fa fa-btn fa-sign-out"></i>退出帐号</a></li>
                            </ul>
                        </li>   
                    @endif
                
                </ul>
            </div>
        </div>
    </nav>