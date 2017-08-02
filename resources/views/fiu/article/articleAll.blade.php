@extends('fiu.base')

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
                    全部文章
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-sm-12">
                    <a type="button" class="btn btn-white mr-2r" href="{{url('/fiu/saas/article/create')}}">
                        <i class="glyphicon glyphicon-edit"></i> 添加文章
                    </a>
                </div>
            </div>
            <div class="row scroll">
                <div class="col-sm-12">
                   <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th>商品编号</th>
                                <th>商品名称</th>
                                <th>文章标题</th>
                                <th>文章来源</th>
                                <th>文章作者</th>
                                <th>创建时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>{{ $article->products ? $article->products->number : '' }}</td>
                                <td>{{ $article->products ? $article->products->title : '' }}</td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->site_from }}</td>
                                <td>{{ $article->author }}</td>
                                <td>{{ $article->created_at }}</td>
                                <td>
                                    @if ($article->status == 1)
                                        <span class="label label-success">已审核</span>
                                    @else
                                        <span class="label label-danger">草稿箱</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-default btn-sm" href="{{ url('/fiu/saas/article/edit') }}/{{$article->id}}">编辑</a>
                                    <a class="btn btn-default btn-sm" href="{{ url('/fiu/saas/article/delete') }}/{{$article->id}}">删除</a>
                                    @if ($article->status == 1)
                                        <a href="/fiu/article/{{ $article->id}}/unStatus" class="btn btn-sm btn-danger">草稿箱</a>
                                    @else
                                        <a href="/fiu/article/{{ $article->id}}/status" class="btn btn-sm btn-success">已审核</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                   </table> 
               </div>
            </div>
        </div>
        @if ($articles)
            <div class="row">
                <div class="col-md-12 text-center">{!! $articles->appends(['search' => $search, 'type' => $type])->render() !!}</div>
            </div>
        @endif
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('partial_js')
    @parent
@endsection


