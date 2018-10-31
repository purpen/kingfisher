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
                <input type="hidden" name="storage_id" value="{{$out_warehouse->storage_id}}">
                <div id="append-sku">
                    <div class="form-group">
                        <label for="goodsSku" class="col-sm-2 control-label">商品扫描</label>
                        <div class="col-sm-6">
                            <input type="text" id="goodsSku" class="form-control">
                        </div>
                    </div>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label">仓库:</label>
                        <div class="col-sm-3">
                            <p class="form-text">{{ $out_warehouse->storage_name }}</p>
                        </div>

                        <label for="department" class="col-sm-2 control-label">部门:</label>
                        <div class="col-sm-3">
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
                                <td>
                                    <input type="hidden" name="out_sku_id[]" value="{{$out_sku->id}}">
                                    <input type="hidden" name="sku_id[]" value="{{$out_sku->sku_id}}">
                                    <input type="text" onkeyup="onlyNum(this)" maxlength="{{$out_sku->not_count}}" name="count[]" class="form-control input-operate integer count" value="{{$out_sku->not_count}}" data-toggle="popover" data-placement="top" data-content="数量不能大于可入库数量" required>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr class="active">
                            <td colspan="3">合计</td>
{{--                            @{{#enter_warehouse}}--}}
                            <td><span id="total" class="magenta-color">{{ $out_warehouse->count }}</span></td>
                            <td><span id="changetotal" spantotal="0" class="magenta-color">{{ $out_warehouse->out_count }}</span></td>
                            <td>未出库：<span id="changetotal" spantotal="0" class="magenta-color">{{$out_warehouse->not_count}}</span></td>
                            {{--@{{/enter_warehouse}}--}}
                        </tr>
                        </tfoot>
                    </table>

                    <input type="hidden" name="changeWarehouse_department" value="{{$out_warehouse->changeWarehouse_department}}">
                    <input type="hidden" name="changeWarehouse_id" value="{{$out_warehouse->changeWarehouse_id}}">
                    <div class="form-group">
                        <label for="summary" class="col-sm-2 control-label">出库备注</label>
                        <div class="col-sm-8">
                            <textarea rows="2" class="form-control" name="summary">{{ $out_warehouse->summary }}</textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="submit" class="btn btn-magenta makesure">确认提交</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.history.back()">取消</button>
                </div>
            </form>
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