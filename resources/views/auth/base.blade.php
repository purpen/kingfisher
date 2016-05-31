@extends('layout.app')

@section('customize_css')
    @parent
        .control-label{
            color: #666;
        }
        #container{
            background:url({{ url('images/default/background.jpg') }}) no-repeat;
            background-size:cover;
            position: relative;
        }
        #erp-content{
            min-height:400px;
        }
        #login-block{
            height: 305px;
            padding: 0 30px;
            background: #fff;
            position: absolute;
            top:0;
            right:15%;
        }
        #login-block h3{
            padding-bottom: 15px;
            color: #FF3366 !important;
        }
        .erp-login{
            width: 100%;
        }
        .forgetpass{
            padding-top: 6px;
        }
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
