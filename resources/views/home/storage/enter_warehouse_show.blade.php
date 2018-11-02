@extends('home.base')

@section('title', '入库单详情')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
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
    <div class="container mainwrap">
        <div class="row scroll">
            <div class="col-md-12">
                <div class="formwrapper form-horizontal">
                    <form id="addsku" class="form-horizontal" method="post" action="">
                    <div id="append-sku">
                        <input type="hidden" name="out_warehouse_id" value="{{$enter_warehouse->id}}">
                        <input type="hidden" name="changeWarehouse_id" value="{{$enter_warehouse->changeWarehouse_id}}">
                        <input type="hidden" name="purchase_id" value="{{$enter_warehouse->purchase_id}}">
                        <div class="form-group">
                            <label for="number" class="col-sm-1 control-label">入库仓库:</label>
                            <div class="col-sm-4">
                                <p class="form-text">{{ $enter_warehouse->storage->name }}</p>
                            </div>

                            <label for="department" class="col-sm-1 control-label">部门:</label>
                            <div class="col-sm-4">
                                <p class="form-text">{{ $enter_warehouse->department_val }}</p>
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
                                    <td><span id="total" class="magenta-color">{{ $enter_warehouse->count }}</span></td>
                                    <td><span id="changetotal" spantotal="0" class="magenta-color">{{ $enter_warehouse->in_count }}</span></td>
                                </tr>
                            </tfoot>
                        </table>

                        @if($res)
                            <hr>
                            <div class="form-group">
                                <h3 style="width:100%;margin-left: 37%">历史记录</h3>
                            </div>
                        @endif

                        @foreach($res as $val)
                            <div>
                                @foreach ($val['data_base'] as $value)
                                    <div class="form-group">
                                        <label for="realname" class="col-sm-2 control-label {{ $errors->has('realname') ? ' has-error' : '' }}">操作人:</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="realname" name="realname" class="form-control" readonly value="{{ $value['realname'] }}">
                                        </div>
                                        @if($enter_warehouse->changeWarehouse_id)
                                        <label for="outorin_time" class="col-sm-2 control-label {{ $errors->has('outorin_time') ? ' has-error' : '' }}">操作时间:</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="outorin_time" name="outorin_time" class="form-control" readonly value="{{ $value['outorin_time'] }}">
                                        </div>
                                            @elseif($enter_warehouse->purchase_id)
                                            <label for="storage_time" class="col-sm-2 control-label {{ $errors->has('storage_time') ? ' has-error' : '' }}">操作时间:</label>
                                            <div class="col-sm-2">
                                                <input type="text" id="storage_time" name="storage_time" class="form-control" readonly value="{{ $value['storage_time'] }}">
                                            </div>
                                            @endif
                                    </div>
                                @endforeach

                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr class="active">
                                        <th>SKU编码</th>
                                        <th>商品名称</th>
                                        <th>商品属性</th>
                                        <th>出库数量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($val['data'] as $allocation_out)
                                        <tr>
                                            <td class="magenta-color">
                                                {{ $allocation_out['number'] }}
                                            </td>
                                            <td>{{ $allocation_out['name'] }}</td>
                                            <td>{{ $allocation_out['mode'] }}</td>
                                            <td>{{ $allocation_out['num'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        @endforeach
                    </div> </form>


                        <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">
                            <i class="glyphicon glyphicon-arrow-left"></i> 返回列表
                        </button>
                    </div>
                </div>
            </div>
        </div>
@endsection
