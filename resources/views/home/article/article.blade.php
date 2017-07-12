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
        @include('block.errors')
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    文章管理
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-sm-12">
                    <a type="button" class="btn btn-white mr-2r" href="{{url('/article/create')}}/{{$product_id}}">
                        <i class="glyphicon glyphicon-edit"></i> 添加文章
                    </a>
                </div>
            </div>
            <div class="row scroll">
                <div class="col-sm-12">
                   <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th>商品名称</th>
                                <th>商品编号</th>
                                <th>文章标题</th>
                                <th>文章作者</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <th>{{ $product->title }}</th>
                                <th>{{ $article->product_number }}</th>
                                <th>{{ $article->title }}</th>
                                <th>{{ $article->author }}</th>
                                <th>
                                    <a class="btn btn-default btn-sm" href="{{ url('/article/edit') }}/{{$article->id}}">编辑</a>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                   </table> 
               </div>
            </div>
        </div>
        @if ($articles)
            <div class="row">
                <div class="col-md-12 text-center">{!! $articles->render() !!}</div>
            </div>
        @endif
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('partial_js')
    @parent
@endsection


