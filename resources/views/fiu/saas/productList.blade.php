@extends('fiu.base')

@section('customize_css')
    @parent
    tr.bone > td{
    border:none !important;
    border-bottom: 1px solid #ddd !important;
    }
    tr.brnone > td{
    border: none !important;
    border-bottom: 1px solid #ddd !important;
    }
    .popover-content tr{
    line-height: 24px;
    font-size: 13px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    商品管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('fiu.saas.subnav')
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-8">
                <div class="form-inline">
                </div>
            </div>
            <div class="col-md-4 text-right">
                {{--分页数量选择--}}
                <form id="per_page_from" action="{{ url('/fiu/saasProduct/lists') }}" method="POST">
                    <div class="datatable-length">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <select class="form-control selectpicker input-sm per_page" name="per_page">
                            <option @if($per_page == 10) selected @endif value="10">10</option>
                            <option @if($per_page == 25) selected @endif value="25">25</option>
                            <option @if($per_page == 50) selected @endif value="50">50</option>
                            <option @if($per_page == 100) selected @endif value="100">100</option>
                        </select>
                    </div>
                    <div class="datatable-info ml-r">
                        条/页，显示 {{ $products->firstItem() }} 至 {{ $products->lastItem() }} 条，共 {{ $products->total() }}
                        条记录
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th>缩略图</th>
                        <th>编号</th>
                        <th>商品简称</th>
                        <th>供应商</th>
                        {{--@role(['buyer', 'director', 'admin'])--}}
                        {{--<th>成本价</th>--}}
                        {{--@endrole--}}
                        <th>分销价格</th>
                        {{--<th>建议售价</th>--}}
                        <th class="text-center">库存总量</th>
                        <th>备注</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="brnone">
                            <td class="text-center">
                                <input type="checkbox" name="Order" value="{{ $product->id }}">
                            </td>
                            <td>
                                <img src="{{$product->first_img}}" class="img-thumbnail" style="width: 80px;">
                            </td>
                            <td class="magenta-color">
                                {{ $product->number }}
                            </td>
                            <td class="table-name" data-container="body" data-toggle="popover" data-placement="top"
                                data-content="{{ $product->title }}">
                                <span class="proname">{{ $product->tit }}</span>
                            </td>
                            <td>
                                @if ($product->supplier) {{ $product->supplier->nam }}【{{$product->supplier->type_val}}
                                】 @endif
                            </td>
                            {{--@role(['buyer', 'director', 'admin'])--}}
                            {{--<td>--}}
                            {{--{{ $product->cost_price }}--}}
                            {{--</td>--}}
                            {{--@endrole--}}
                            <td id="product{{ $product->id }}">
                                {{ $product->saasInfo() ? $product->saasInfo()->price : '未设置' }}
                            </td>
                            {{--<td>--}}
                            {{--{{ $product->sale_price }}--}}
                            {{--</td>--}}
                            <td class="magenta-color text-center">{{$product->inventory}}</td>
                            <td class="table-mark" data-container="body" data-toggle="popover" data-placement="top"
                                data-content="{{ $product->summary }}">{{ str_limit($product->summary, 80) }}</td>
                            <td>
                                <button class="btn btn-default btn-sm showSku" onclick="showSku({{$product->id}})">
                                    显示SKU
                                </button>
                                <button class="btn btn-default btn-sm edit-product"
                                        onclick="editProduct({{ $product->id }})">编辑
                                </button>
                                <a class="btn btn-default btn-sm"
                                   href="{{ url('/fiu/saasProduct/info/') }}?id={{$product->id}}" target="_blank">设置</a>
                                <a class="btn btn-default btn-sm"
                                   href="{{ url('/fiu/saas/image') }}?id={{$product->id}}" target="_blank">相关素材</a>
                            </td>
                        </tr>
                        @foreach($product->productsSku as $sku)
                            <tr class="bone product{{$product->id}} active" active="0" hidden>
                                <td class="text-center"></td>
                                {{--@if(in_array($product->status,[1,2,3]))--}}
                                {{--<td></td>--}}
                                {{--@endif--}}
                                <td>
                                    <img src="{{$sku->first_img}}" class="img-thumbnail" style="width: 80px;">
                                </td>
                                <td>SKU<br>{{ $sku->number }}</td>
                                <td colspan="2">属性：{{ $sku->mode }}</td>
                                {{--<td>{{ $sku->cost_price }}</td>--}}
                                <td id="sku{{$sku->id}}">{{ $sku->saasSkuInfo() ? $sku->saasSkuInfo()->price : '未设置'}}</td>
                                {{--<td>{{ $sku->price }}</td>--}}
                                <td class="magenta-color text-center">{{ $sku->quantity }}</td>
                                <td>{{ $sku->summary }}</td>
                                <td>
                                    <button class="btn btn-default btn-sm edit-product"
                                            onclick="editSku({{ $sku->id }})">编辑
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">{!! $products->appends(['search' => $name, 'per_page' => $per_page])->render() !!}</div>
        </div>
    </div>
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">


    {{--编辑商品弹窗--}}
    <div class="modal fade" id="updateProduct" tabindex="-1" role="dialog" aria-labelledby="updateProductLabel">
        <div class="modal-dialog modal-zm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="gridSystemModalLabel">更改基础商品信息</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="text" id="update_product_id" name="product_id" hidden>
                            <label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">价格</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price1"
                                       placeholder="输入价格"
                                       value="">
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="modal-footer pb-r">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-magenta" onclick="postProduct()">确定</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--编辑sku弹窗--}}
    <div class="modal fade" id="updateSku" tabindex="-1" role="dialog" aria-labelledby="updateSkuLabel">
        <div class="modal-dialog modal-zm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="gridSystemModalLabel">更改基础sku信息</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="text" id="update_sku_id" name="sku_id" hidden>
                            <label for="name" class="col-sm-2 control-label p-0 lh-34 m-56">价格</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price2"
                                       placeholder="输入价格"
                                       value="">
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="modal-footer pb-r">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-magenta" onclick="postSku()">确定</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
        var _token = $('#_token').val();


        {{--展示隐藏SKU--}}
        function showSku(id) {
            var dom = '.product' + id;

            if ($(dom).eq(0).attr('active') == 0) {
                $(dom).each(function () {
                    $(this).attr("active", 1);
                });
                $(dom).show("slow");

            } else {
                $(dom).each(function () {
                    $(this).attr("active", 0);
                });
                $(dom).hide("slow");
            }
        }

        function editProduct(id) {
            $.get('{{url('/fiu/saasProduct/ajaxGetSaasProduct')}}', {"product_id": id, "_token": _token}, function (e) {
                if (e.status == -1) {
                    alert(e.msg);
                } else {
                    $("#update_product_id").attr('value', id);
                    $("#price1").attr('value', e.data['price']);
                    $("#updateProduct").modal().show();
                }
            }, 'json');
        }

        function postProduct() {
            var product_id = $("#update_product_id").attr("value");
            var price = $("#price1").val();
            $("#updateProduct").modal('hide');
            $.post('{{ url('/fiu/saasProduct/ajaxSetSaasProduct') }}', {
                    'product_id': product_id,
                    'price': price,
                    '_token': _token
                },
                function (e) {
                    if(e.status == 1){
                        $("#product" + product_id).html(price);
                    }else if(e.status == 0){
                        alert(e.message);
                    }else if(e.status == -1){
                        alert(e.msg);
                    }
                }, 'json');
            $("#update_product_id").attr("value",'');
            $("#price1").val('');
        }

        function editSku(id) {
            $.get('{{url('/fiu/saasProduct/ajaxGetSaasSku')}}', {"sku_id": id, "_token": _token}, function (e) {
                if (e.status == -1) {
                    alert(e.msg);
                } else {
                    $("#update_sku_id").attr('value', id);
                    $("#price2").attr('value', e.data['price']);
                    $("#updateSku").modal().show();
                }
            }, 'json');
        }

        function postSku() {
            var sku_id = $("#update_sku_id").attr("value");
            var price = $("#price2").val();
            $("#updateSku").modal('hide');
            $.post('{{ url('/fiu/saasProduct/ajaxSetSaasSku') }}', {
                    'sku_id': sku_id,
                    'price': price,
                    '_token': _token
                },
                function (e) {
                    if(e.status == 1){
                        $("#sku" + sku_id).html(price);
                    }else if(e.status == 0){
                        alert(e.message);
                    }else if(e.status == -1){
                        alert(e.msg);
                    }
                }, 'json');
            $("#update_sku_id").attr("value",'');
            $("#price2").val('');
        }

        @endsection

        @section('load_private')
        @parent
        {{--<script>--}}
        $(function () {
            $("[data-toggle='popover']").popover();
        });
        $('.operate-update-offlineEshop').click(function () {
            $(this).siblings().css('display', 'none');
            $(this).css('display', 'none');
            $(this).siblings('input[name=txtTitle]').css('display', 'block');
            $(this).siblings('input[name=txtTitle]').focus();
        });

        $('input[name=txtTitle]').bind('keypress', function (event) {
            if (event.keyCode == "13") {
                $(this).css('display', 'none');
                $(this).siblings().removeAttr("style");
                $(this).siblings('.proname').html($(this).val());
            }
        });

        $('input[name=txtTitle]').bind('blur', function () {
            $(this).css('display', 'none');
            $(this).siblings().removeAttr("style");
            $(this).siblings('.proname').html($(this).val());
        });

        $('.per_page').change(function () {
            $("#per_page_from").submit();
        });
@endsection
