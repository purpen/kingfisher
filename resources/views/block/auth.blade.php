
@section('customize_css')
    @parent
        
@endsection

    <nav class="navbar navbar-inverse navbar-static-top mb-0">
        <div class="container-fluid header">
            
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand logo" href="{{ url('/') }}">
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
                <ul class="nav navbar-nav navbar-right mr-0">
                    <!-- Authentication Links -->
                    
                    @if ($data["towhere"] == "login")
                        <li>
                            <a href="/register" class="transparent btn-magenta btn" role="button">
                                注册
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="transparent btn-magenta btn" href="/login" role="button">
                                登录
                            </a>
                        </li>
                    @endif
                
                </ul>
            </div>
        </div>
    </nav>