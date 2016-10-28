@extends('home.base')

@section('title', '入库单详情')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        入库单详情
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
            <div class="form-horizontal">
                <div id="append-sku">
                    <div class="form-group">
                        <label for="number" class="col-sm-1 control-label">入库仓库</label>
                        <div class="col-sm-4">
                            <p class="form-text">{{ $enter_warehouse->storage->name }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="summary" class="col-sm-1 control-label">备注说明</label>
                        <div class="col-sm-4">
                            <p class="form-text">{{ $enter_warehouse->summary }}</p>
                        </div>
                    </div>
                    
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="active">
                                <th>SKU编码</th>
                                <th>商品名称</th>
                                <th>商品属性</th>
                                <th>需入库数量</th>
                                <th>已入库数量</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enter_skus as $enter_sku)
                                <tr>
                                    <td class="magenta-color">
                                        {{ $enter_sku->number }}
                                    </td>
                                    <td>{{ $enter_sku->name }}</td>
                                    <td>{{ $enter_sku->mode }}</td>
                                    <td>{{ $enter_sku->count }}</td>
                                    <td>{{ $enter_sku->in_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="active">
                                <td colspan="3">合计</td>
                                <td>需入库：<span id="total" class="magenta-color">{{ $enter_warehouse->count }}</span></td>
                                <td>已入库：<span id="changetotal" spantotal="0" class="magenta-color">{{ $enter_warehouse->in_count }}</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>    
@endsection
