@extends('layout.fiu_app')

@section('header')
    @parent
    @include('block.fiu_header')
@endsection

@section('content')
    @parent
    @include('block.fiu_content')
@endsection

@section('footer')
    @parent
    @include('block.fiu_footer')
@endsection
