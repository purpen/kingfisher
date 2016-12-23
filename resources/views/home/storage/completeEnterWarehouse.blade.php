@extends('home.base')

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
        <div class="row scroll">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>审核状态</th>
                        <th>单据编号</th>
                        <th>入库仓库</th>
                        <th>总数量</th>
                        <th>已入库数量</th>
                        <th>总金额</th>
                        <th>相关来源</th>
                        <th>制单时间</th>
                        <th>制单人</th>
                        <th>审核时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($enter_warehouses as $enter_warehouse)
                    <tr>
                        <td class="text-center"><input name="Order" active="0" type="checkbox"></td>
                        <td>
                            @if ($enter_warehouse->storage_status == 0)
                            <span class="label label-danger">{{ $enter_warehouse->status_label }}</span>
                            @elseif ($enter_warehouse->storage_status == 1)
                            <span class="label label-warning">{{ $enter_warehouse->status_label }}</span>
                            @elseif($enter_warehouse->storage_status == 5)
                            <span class="label label-success">{{ $enter_warehouse->status_label }}</span>
                            @endif
                        </td>
                        <td class="magenta-color">{{$enter_warehouse->number}}</td>
                        <td>{{$enter_warehouse->storage->name}}</td>
                        <td>{{$enter_warehouse->count}}</td>
                        <td>{{$enter_warehouse->in_count}}</td>
                        <td></td>
                        <td>{{$enter_warehouse->purchase_number}}</td>
                        <td>{{$enter_warehouse->created_at_val}}</td>
                        <td>{{$enter_warehouse->user->realname}}</td>
                        <td></td>
                        <td tdr="nochect">
                            <a href="{{ url('/enterWarehouse/show/') }}/{{ $enter_warehouse->id }}" class="btn btn-white btn-sm">查看详细</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($enter_warehouses)
        <div class="row">
            <div class="col-md-10 col-md-offset-2">{!! $enter_warehouses->appends(['number' => $number])->render() !!}</div>
        </div>
        @endif
    </div>
    
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    
@endsection
