@extends('home.base')

@section('title', '完成入库单列表')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        入库单列表
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    @include('home.storage.warehouse-subnav')
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row fz-0">
            <button type="button" class="btn btn-white mlr-2r">导出</button>
        </div>
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>入库单编号</th>
                        <th>相关采购单</th>
                        <th>入库仓库</th>
                        <th>入库数量</th>
                        <th>已入库数量</th>
                        <th>制单时间</th>
                        <th>制单人</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($enter_warehouses as $enter_warehouse)
                    <tr>
                        <td class="text-center"><input name="Order" active="0" type="checkbox"></td>
                        <td class="magenta-color">{{$enter_warehouse->number}}</td>
                        <td>{{$enter_warehouse->purchase_number}}</td>
                        <td>{{$enter_warehouse->storage_name}}</td>
                        <td>{{$enter_warehouse->count}}</td>
                        <td>{{$enter_warehouse->in_count}}</td>
                        <td>{{$enter_warehouse->created_at_val}}</td>
                        <td>{{$enter_warehouse->user_name}}</td>
                        <td tdr="nochect">
                            <button type="button" id="edit-enter" value="{{$enter_warehouse->id}}" class="btn btn-white btn-sm edit-enter">查看详细</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($enter_warehouses)
            <div class="col-md-6 col-md-offset-6">{!! $enter_warehouses->render() !!}</div>
        @endif
    </div>
    
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
@endsection
