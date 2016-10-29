<!DOCTYPE html>
<html lang="zn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>太火鸟-ERP管理系统</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ elixir('assets/css/app.css') }}">
    @yield('partial_css')
    
    <style>
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
    <script src="{{ elixir('assets/js/plugins.js') }}"></script>
    <script src="{{ elixir('assets/js/base.js') }}"></script>
    @yield('partial_js')
    <script type="text/javascript">
        // 初始化脚本
        kingfisher.initial();

        @yield('customize_js')
        
    </script>
</body>
</html>
