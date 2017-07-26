@extends('home.base')

@section('partial_css')
    @parent
    <link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
    @parent
    .m-92{
    min-width:92px;
    text-align:right;
    vertical-align: top !important;
    line-height: 34px;
    }
    .img-add{
    width: 100px;
    height: 100px;
    background: #f5f5f5;
    vertical-align: middle;
    text-align: center;
    padding: 24px 0;
    }
    .img-add .glyphicon{
    font-size:30px;
    }
    #picForm{
    position:relative;
    color: #f36;
    height: 100px;
    text-decoration: none;
    width: 100px;
    }
    #picForm:hover{
    color:#e50039;
    }
    #picForm .form-control{
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    width: 100px;
    height: 100px;
    z-index: 3;
    cursor: pointer;
    }
    .removeimg{
    position: absolute;
    left: 75px;
    bottom: 10px;
    font-size: 13px;
    }
    #appendsku{
    margin-left:40px;
    font-size:14px;
    }
    .qq-uploader {
    position: relative;
    width: 100%;
    width: 100px;
    height: 100px;
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    }
    .qq-upload-button{
    width:100px;
    height:100px;
    position:absolute !important;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        @include('block.errors')
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    素材库管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.materialLibraries.subnav')
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-sm-12">
                    <a type="button" class="btn btn-white mr-2r" href="{{url('/saas/video/create')}}">
                        <i class="glyphicon glyphicon-edit"></i> 添加视频
                    </a>
                </div>
            </div>
            <div class="row scroll">
                <div class="col-sm-12">
                   <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th>缩略图</th>
                                <th>商品编号</th>
                                <th>商品名称</th>
                                <th>字段</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($materialLibraries as $materialLibrary)
                            <tr>
                                <td>
                                    <img src="{{ $materialLibrary->file->video ? $materialLibrary->file->video : url('images/default/video.png') }}" class="img-thumbnail" style="width: 80px;">
                                </td>
                                <td>{{ $materialLibrary->product_number }}</td>
                                <td>{{ $materialLibrary->products ? $materialLibrary->products->title : ''}}</td>
                                <td>{{ $materialLibrary->describe }}</td>
                                <td>{{ $materialLibrary->created_at }}</td>
                                <td>
                                    <a class="btn btn-default btn-sm" href="{{ url('/saas/video/edit') }}/{{$materialLibrary->id}}">编辑</a>
                                    @if(!empty($materialLibrary->path))
                                        <button type="button" onclick=" AddressVideo('{{ $materialLibrary->file->srcfile }}')" class="btn btn-white btn-sm" data-toggle="modal" data-target="#Video">视频</button>
                                    @endif
                                    <a class="btn btn-default btn-sm" href="{{ url('/saas/material/delete') }}/{{$materialLibrary->id}}">删除</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                   </table> 
               </div>
            </div>
        </div>
        @if ($materialLibraries)
            <div class="row">
                <div class="col-md-12 text-center">{!! $materialLibraries->render() !!}</div>
            </div>
        @endif
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    @include("home/materialLibraries.videoModal")

@endsection
@section('partial_js')
    @parent
    <script src="{{ elixir('assets/js/fine-uploader.js') }}" type="text/javascript"></script>

@endsection

@section('customize_js')
    @parent
    {{--协议地址--}}
    function AddressVideo (address) {
        var address = address;
        document.getElementById("videoAddress").src = address;
    }
@endsection

