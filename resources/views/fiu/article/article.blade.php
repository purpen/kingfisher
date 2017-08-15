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
        @if (session('error_message'))
            <div class="alert alert-success error_message">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p class="text-danger">{{ session('error_message') }}</p>
            </div>
        @endif
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
                                <th>公众号</th>
                                <th>文章作者</th>
                                <th>创建时间</th>
                                <th>审核状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td class="magenta-color">{{ $article->products ? $article->products->number : '' }}</td>
                                <td>{{ $article->products ? $article->products->title : '' }}</td>
                                <td><a href="{{$web_url.$article->id}}">{{ $article->title }}</a></td>
                                <td>{{ $article->site_from }}</td>
                                <td>{{ $article->author }}</td>
                                <td>{{ $article->created_at }}</td>
                                <td>
                                    @if ($article->status == 1)
                                        <span class="label label-success">是</span>
                                    @else
                                        <span class="label label-danger">否</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($article->status == 1)
                                        <a href="/fiu/saas/article/{{ $article->id}}/unStatus" class="btn btn-sm btn-danger  mr-2r">关闭</a>
                                    @else
                                        <a href="/fiu/saas/article/{{ $article->id}}/status" class="btn btn-sm btn-success  mr-2r">开启</a>
                                    @endif
                                    <a class="btn btn-default btn-sm  mr-2r" href="{{ url('/fiu/saas/article/edit') }}/{{$article->id}}">编辑</a>
                                    <a class="btn btn-default btn-sm " href="{{ url('/fiu/saas/article/delete') }}/{{$article->id}}">删除</a>

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


