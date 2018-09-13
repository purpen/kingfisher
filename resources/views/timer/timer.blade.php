@extends('home.base')

@section('partial_css')
    @parent
@endsection
@section('customize_css')
    @parent
@endsection
@section('content')
    @parent
    <div class="frbird-erp">


            亲爱的{{$users->realname}}，您好，Laravel学院新发布了XXX功能，立即去体验下吧：
            <a href="http://laravelacademy.org">前往学院</a>

    </div>
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('partial_js')
    @parent
@endsection



