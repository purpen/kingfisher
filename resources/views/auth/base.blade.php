@extends('layout.app')

@section('customize_css')
    @parent
        
@endsection

@section('header')
    @parent
    @include('block.auth')
@endsection

@section('content')
    @parent
    
@endsection

@section('footer')
    @parent
    
@endsection

@section('customize_js')
    @parent
        var height = $(window).height() - 81;
        var login_height = 300;
        var login_top = (height-login_height)/2;
        $('#erp-content').css('height',height+'px');
        $('#login-block').css('top',login_top+'px');
        window.onresize = function(){
            var height = $(window).height() - 81;
            $('#erp-content').css('height',height+'px');
            $('#login-block').css('top',login_top+'px');
        }
@endsection
