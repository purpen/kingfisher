
@section('customize_css')
    @parent
        .navbar-default{
            background-color: #fff;
            border-color: #FF3366;
            margin-bottom: 0;
        }
        .header,.navbar-header,.navbar-brand{
            height:80px;
        }
        #logo{
            height:100%;
        }
        .navbar-brand{
            padding-top: 10px;
        }
        .navbar-right{
            margin-top: 25px;
            margin-right: 0;
        }
        .navbar-right li a{
            padding: 5px 14px;
            border:0;
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
                {{--
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ url('/home') }}">首页</a></li>
                </ul>
                --}}
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    
                    @if ($data["towhere"] == "login")
                        <li><a class="btn btn-default erp-button" href="#" role="button">注册</a></li>
                    @else
                        <li><a class="btn btn-default erp-button" href="#" role="button">登录</a></li>
                    @endif
                
                </ul>
            </div>
        </div>
    </nav>