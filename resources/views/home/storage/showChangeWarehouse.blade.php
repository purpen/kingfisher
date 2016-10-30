@extends('home.base')

@section('title', '编辑调拨单')

@section('customize_css')
    @parent
    .scrollt{
    height:400px;
    overflow:hidden;
    }
    .sublock{
    display: block !important;
    margin-left: -15px;
    margin-right: -15px;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        调拨单详情
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    @include('home.storage.exchange_subnav')
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        @include('block.errors')
        <div class="row formwrapper">
            <div class="col-md-12">
                <div class="form-horizontal">
                    <h5>调拨单信息</h5>
                    <hr>
                    
                    <div class="form-group">
                        <label for="out_storage_id" class="col-sm-1 control-label">调出仓库</label>
                        <div class="col-sm-2">
                            <p class="form-text">
                                @foreach($storage_list as $storage)
                                    @if($change_warehouse->out_storage_id == $storage->id)
                                        {{ $storage->name }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                        
                        <label for="in_storage_id" class="col-sm-1 control-label">调入仓库</label>
                        <div class="col-sm-2">
                            <p class="form-text">
                                @foreach($storage_list as $storage)
                                    @if($change_warehouse->in_storage_id == $storage->id)
                                        {{ $storage->name }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                    
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="active">
                                <th>SKU编码</th>
                                <th>商品名称</th>
                                <th>商品属性</th>
                                <th>库存数量</th>
                                <th>调出数量</th>
                            </tr>
                        </thead>
                        <tbody id="append-sku">
                            @foreach($change_warehouse_sku_list as $sku)
                            <tr><input type="hidden" name="sku_id[]" value="{{ $sku->sku_id }}">
                                <td>{{ $sku->number }}</td>
                                <td>{{ $sku->name }}</td>
                                <td>{{ $sku->mode }}</td>
                                <td>{{ $sku->storage_count }}</td>
                                <td>{{ $sku->count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="form-group">
                        <label for="summary" class="col-sm-1 control-label">备注说明</label>
                        <div class="col-sm-8">
                            {{$change_warehouse->summary}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customize_js')
    @parent

@endsection
