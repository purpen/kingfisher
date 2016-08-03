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
                        编辑调拨单
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="add-purchase" role="form"">
            <div class="row ui white ptb-4r">
                <div class="col-md-12">
                    <div class="form-inline">
                        <div class="form-group vt-34">出库仓库：</div>
                        <div class="form-group pr-4r mr-2r">
                                @foreach($storage_list as $storage)
                                    @if($change_warehouse->out_storage_id == $storage->id)
                                        {{ $storage->name }}
                                    @endif
                                @endforeach
                        </div>
                        <div class="form-group vt-34">入库仓库：</div>
                        <div class="form-group pr-4r mr-2r">
                            @foreach($storage_list as $storage)
                                @if($change_warehouse->in_storage_id == $storage->id)
                                    {{ $storage->name }}
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="row ui white ptb-4r">
                <div class="well-lg textc mlr-3r mt-r">
                    <table class="table table-striped table-hover" style="margin-bottom:20px;">
                        <thead class=" table-bordered">
                        <tr>
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
                </div>
                <div class="form-horizontal">
                    <div class="form-group mlr-0">
                        <div class="lh-34 m-56 ml-3r fl">备注</div>
                        <div class="col-sm-5 pl-0">
                            {{$change_warehouse->summary}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4r pt-2r">
                <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">返回</button>
            </div>
        </form>
    </div>
@endsection

@section('customize_js')
    @parent

@endsection
