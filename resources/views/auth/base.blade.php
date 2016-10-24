@extends('layout.app')

@section('customize_css')
    @parent
        .control-label{
            color: #666;
        }
        .form-horizontal .control-label {
            padding-left: 5px;
            padding-right: 5px;
        }
        #container{
            background:url({{ url('images/default/bitmap.png') }}) no-repeat;
            background-size:cover;
            position: absolute;
            height: 100%;
            width: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
        }
        #login-block{
            width: 450px;
            padding: 0 30px;
            background: #fff;
            position: absolute;
            top: 38%;
            right: 12%;
            margin-top: -125px;
        }
        #login-block h3{
            padding-bottom: 15px;
            color: #FF3366 !important;
            font-weight:400;
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

@section('customize_js')
    @parent
       
@endsection
