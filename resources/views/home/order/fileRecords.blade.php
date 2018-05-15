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
                    订单导入记录
                </div>
            </div>
        </div>
        @if (session('error_message'))
            <div class="alert alert-success error_message">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p class="text-danger">{{ session('error_message') }}</p>
            </div>
        @endif
        <div class="container mainwrap">
            <div class="row scroll">
                <div class="col-sm-12">
                   <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="gblack">
                                <th>id</th>
                                <th>文件名</th>
                                <th>总条数</th>
                                <th>成功数</th>
                                <th>失败数</th>
                                <th>状态</th>
                                <th>创建时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($fileRecords as $fileRecord)
                            <tr>
                                <td>{{ $fileRecord->id}}</td>
                                <td>{{ $fileRecord->file_name}}</td>
                                <td>{{ $fileRecord->total_count}}</td>
                                <td>{{ $fileRecord->success_count }}</td>
                                <td>{{ $fileRecord->no_sku_count + $fileRecord->repeat_outside_count + $fileRecord->null_field_count + $fileRecord->sku_storage_quantity_count + $fileRecord->product_unopened_count}}</td>
                                <td>{{ $fileRecord->status_val }}</td>
                                <td>{{ $fileRecord->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                   </table> 
               </div>
            </div>
        </div>
        @if ($fileRecords)
            <div class="row">
                <div class="col-md-12 text-center">{!! $fileRecords->render() !!}</div>
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
