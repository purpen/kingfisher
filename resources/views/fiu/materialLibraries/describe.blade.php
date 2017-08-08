@extends('fiu.base')

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
                        <form id="per_page_from" action="{{url('/fiu/saas/describe')}}?id={{$product_id}}" method="POST">
                    @else
                        <form id="per_page_from" action="{{ url('/fiu/saas/describe') }}" method="POST">
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
                    <a type="button" class="btn btn-white" href="{{url('/fiu/saas/describe/create')}}">
                        <i class="glyphicon glyphicon-edit"></i> 添加文字段
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
                                <th>字段</th>
                                <th>创建时间</th>
                                <th>审核状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($materialLibraries as $materialLibrary)
                            <tr>
                                <td>{{ $materialLibrary->product_number }}</td>
                                <td>{{ $materialLibrary->products ? $materialLibrary->products->title : ''  }}</td>
                                <td style="width:300px;">{{ $materialLibrary->describe }}</td>
                                <td>{{ $materialLibrary->created_at }}</td>
                                <td>
                                    @if ($materialLibrary->status == 1)
                                        <span class="label label-success">是</span>
                                    @else
                                        <span class="label label-danger">否</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($materialLibrary->status == 1)
                                        <a href="/fiu/saas/material/{{ $materialLibrary->id}}/unStatus" class="btn btn-sm btn-danger  mr-2r">关闭</a>
                                    @else
                                        <a href="/fiu/saas/material/{{ $materialLibrary->id}}/status" class="btn btn-sm btn-success  mr-2r">开启</a>
                                    @endif
                                    <a class="btn btn-default btn-sm  mr-2r" href="{{ url('/fiu/saas/describe/edit') }}/{{$materialLibrary->id}}">编辑</a>
                                    <a class="btn btn-default btn-sm  mr-2r" href="{{ url('/fiu/saas/material/delete') }}/{{$materialLibrary->id}}">删除</a>

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
                <div class="col-md-12 text-center">{!! $materialLibraries->appends(['search' => $search , 'type' => $type])->render() !!}</div>
            </div>
        @endif
    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('partial_js')
    @parent
    <script src="{{ elixir('assets/js/fine-uploader.js') }}" type="text/javascript"></script>
@endsection

@section('load_private')
    @parent

    $('.per_page').change(function () {
    $("#per_page_from").submit();
    });
@endsection


