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
                    供货商月统计
                </div>
            </div>
            
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li @if($tab_menu == 'no')class="active"@endif><a href="{{url('/noSupplierMonth')}}">未确认</a></li>
                    <li @if($tab_menu == 'yes')class="active"@endif><a href="{{url('/supplierMonth')}}">已确认</a></li>
                </ul>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row scroll">
                <div class="col-sm-12">
                   <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th>供应商名称</th>
                                <th>年月</th>
                                <th>总金额</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($supplierMonths)
                            @foreach($supplierMonths as $supplierMonth)
                                <tr>
                                    <td>{{ $supplierMonth->supplier_name }}</td>
                                    <td>{{ $supplierMonth->year_month }}</td>
                                    <td>{{ $supplierMonth->total_price }}</td>
                                    <td>
                                        @if ($supplierMonth->status == 0)
                                            <a href="/supplierMonth/{{ $supplierMonth->id}}/status" class="btn btn-sm btn-success">确认</a>
                                        @else
                                            <a href="/supplierMonth/{{ $supplierMonth->id}}/noStatus" class="btn btn-sm btn-danger">取消</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                   </table> 
               </div>
            </div>
            <div class="row">
                @if ($supplierMonths)
                    <div class="col-md-12 text-center">{!! $supplierMonths->render() !!}</div>
                @endif
            </div>
        </div>

    </div>

    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('partial_js')
    @parent
    <script src="{{ elixir('assets/js/fine-uploader.js') }}" type="text/javascript"></script>
@endsection

@section('customize_js')

@endsection

@section('load_private')
    @parent

@endsection
