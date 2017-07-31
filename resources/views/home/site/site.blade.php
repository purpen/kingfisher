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
                    站点管理
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-sm-12">
                    <a type="button" class="btn btn-white mr-2r" href="{{url('/saas/site/create')}}">
                        <i class="glyphicon glyphicon-edit"></i> 添加站点
                    </a>
                </div>
            </div>
            <div class="row scroll">
                <div class="col-sm-12">
                   <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th>名称</th>
                                <th>标识</th>
                                <th>网址</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sites as $site)
                            <tr>
                                <td>{{ $site->name }}</td>
                                <td>{{ $site->mark }}</td>
                                <td>{{ $site->url }}</td>
                                <td>
                                    @if ($site->status == 1)
                                        <span class="label label-success">启用</span>
                                    @else
                                        <span class="label label-danger">禁用</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($site->status == 1)
                                        <a href="/site/{{ $site->id}}/unStatus" class="btn btn-sm btn-danger">关闭</a>
                                    @else
                                        <a href="/site/{{ $site->id}}/status" class="btn btn-sm btn-success">开放</a>
                                    @endif
                                    <a class="btn btn-default btn-sm" href="{{ url('/saas/site/edit') }}/{{$site->id}}">编辑</a>
                                    <a class="btn btn-default btn-sm" href="{{ url('/saas/site/delete') }}/{{$site->id}}">删除</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                   </table> 
               </div>
            </div>
        </div>
        @if ($sites)
            <div class="row">
                <div class="col-md-12 text-center">{!! $sites->render() !!}</div>
            </div>
        @endif
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('partial_js')
    @parent
@endsection


