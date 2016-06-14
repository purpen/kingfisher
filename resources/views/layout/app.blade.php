<!DOCTYPE html>
<html lang="zn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')-太火鸟ERP</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ elixir('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/css/fonts.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/css/formValidation.css') }}">
    @yield('partial_css')
    <link rel="stylesheet" href="{{ elixir('assets/css/app.css') }}">
    
    <style>
        body {
            font-family: "Arial","Microsoft YaHei","黑体","宋体",sans-serif;
        }
        .fa-btn {
            margin-right: 6px;
        }
        .erp-button{
            color: #fff !important;
            background-color: #FF3366;
            border:1px solid #FF3366;
        }
        .erp-button:hover{
            border:1px solid #FF3366;
            background-color: #fff;
            color: #FF3366 !important;
        }
        .erp-link{
            color: #FF3366;
        }
        .erp-link:hover{
            color: #FF3366;
        }
        @yield('customize_css')
    </style>
    
</head>
<body id="app-layout">
    
    @yield('header')

    @yield('content')
    
    @yield('footer')

    <!-- JavaScripts -->
    <script src="{{ elixir('assets/js/jquery.js') }}"></script>
    <script src="{{ elixir('assets/js/bootstrap.js') }}"></script>
    <script src="{{ elixir('assets/js/formValidation.js') }}"></script>
    <script src="{{ elixir('assets/js/mustache.js') }}"></script>
    @yield('partial_js')
    <script src="{{ elixir('assets/js/app.js') }}"></script>
    <script>
        @yield('customize_js')
    </script>
</body>
</html>
