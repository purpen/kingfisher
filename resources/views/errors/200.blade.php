@extends('home.base')

@section('content')
    <div class="container mainwrap">
        <div class="row">
            <div class="col-sm-8">
                <div class="message">
                    <p><img class="permission " style="margin:auto;height:50%;width:50%;" src="{{ url('images/default/image_1_.png') }}" align="absmiddle"></p>
                </div>
                <p><th>{{$message}}</th></p>
                <p class="mt-4r">
                    <a href="{{ $back_url }}" class="btn btn-default">
                        <i class="glyphicon glyphicon-arrow-left"></i> 返回上一步
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection