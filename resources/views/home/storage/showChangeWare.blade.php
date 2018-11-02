@extends('home.base')

@section('title', '调拨出库单明细')
@section('partial_css')
    @parent
    <link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
    @parent
    #picForm .form-control {
    top: 0;
    left: 0;
    position: absolute;
    opacity: 0;
    width: 100px;
    height: 100px;
    z-index: 3;
    cursor: pointer;
    }
    #appendsku {
    margin-left:40px;
    font-size:14px;
    }
    .qq-upload-button {
    width: 100px;
    height: 100px;
    position: absolute !important;
    }
@endsection
@section('customize_js')
    @parent


@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    调拨出库单明细
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">

        <div class="modal-body">
            <form id="addsku" class="form-horizontal" method="post" action="">

                <input type="hidden" name="out_warehouse_id" value="{{$out_warehouse->id}}">
                <input type="hidden" name="changeWarehouse_id" value="{{$out_warehouse->changeWarehouse_id}}">
                <div id="append-sku">
                    <div class="form-group">
                        <label for="goodsSku" class="col-sm-2 control-label">商品扫描</label>
                        <div class="col-sm-8">
                            <input type="text" id="goodsSku" class="form-control">
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <br><br><br>
                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label">仓库:</label>
                        <div class="col-sm-2">
                            <p class="form-text">{{ $out_warehouse->storage_name }}</p>
                        </div>

                        <label for="department" class="col-sm-2 control-label">部门:</label>
                        <div class="col-sm-2">
                            <p class="form-text">{{ $out_warehouse->department_val }}</p>
                        </div>
                    </div>

                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="active">
                            <th>SKU编码</th>
                            <th>商品名称</th>
                            <th>商品属性</th>
                            <th>需出库数量</th>
                            <th>已出库数量</th>
                            <th>本次出库数量</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($out_skus as $out_sku)
                            <tr>
                                <td class="magenta-color">
                                    {{ $out_sku->number }}
                                </td>
                                <td>{{ $out_sku->name }}</td>
                                <td>{{ $out_sku->mode }}</td>
                                <td class="counts">{{ $out_sku->count }}</td>
                                <td class="incounts">{{ $out_sku->out_count }}</td>
                                <td>{{$out_sku->not_count}}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    @if($res)
                        <hr>
                        <div class="form-group">
                            <h3 style="width:100%;margin-left: 37%">历史记录</h3>
                        </div>
                        <br>
                    @endif

                    @foreach($res as $val)
                    <div>
                        @foreach ($val['data_base'] as $value)
                    <div class="form-group">
                        <label for="realname" class="col-sm-2 control-label {{ $errors->has('realname') ? ' has-error' : '' }}">操作人:</label>
                        <div class="col-sm-2">
                            <input type="text" id="realname" name="realname" class="form-control" readonly value="{{ $value['realname'] }}">
                        </div>
                        <label for="outorin_time" class="col-sm-2 control-label {{ $errors->has('outorin_time') ? ' has-error' : '' }}">操作时间:</label>
                        <div class="col-sm-2">
                            <input type="text" id="outorin_time" name="outorin_time" class="form-control" readonly value="{{ $value['outorin_time'] }}">
                        </div>
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
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            @endsection

            @section('partial_js')
                @parent
                <script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
            @endsection

            @section('customize_js')
                @parent

            @endsection