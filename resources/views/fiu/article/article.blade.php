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
                    素材管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('fiu.materialLibraries.subnav')
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-1">
                    {{--分页数量选择--}}
                    @if(!empty($product_id))
                        <form id="per_page_from" action="{{url('/fiu/saas/article')}}?id={{$product_id}}" method="POST">
                    @else
                        <form id="per_page_from" action="{{ url('/fiu/saas/article') }}" method="POST">
                    @endif
                        <div class="datatable-length">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <select class="form-control selectpicker input-sm per_page" name="type">
                                <option @if($type == 1) selected @endif value="1">图片</option>
                                <option @if($type == 2) selected @endif value="2">视频</option>
                                <option @if($type == 3) selected @endif value="3">文字</option>
                                <option @if($type == 4) selected @endif value="4">文章</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-11">
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
                                    @if ($article->status == 1)
                                        <a href="/fiu/saas/article/{{ $article->id}}/unStatus" class="btn btn-sm btn-danger">草稿箱</a>
                                    @else
                                        <a href="/fiu/saas/article/{{ $article->id}}/status" class="btn btn-sm btn-success">已审核</a>
                                    @endif
                                    <a class="btn btn-default btn-sm" href="{{ url('/fiu/saas/article/edit') }}/{{$article->id}}">编辑</a>
                                    <a class="btn btn-default btn-sm" href="{{ url('/fiu/saas/article/delete') }}/{{$article->id}}">删除</a>

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


@section('load_private')
    @parent

    $('.per_page').change(function () {
    $("#per_page_from").submit();
    });
@endsection


