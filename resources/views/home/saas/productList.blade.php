@extends('home.base')

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
                    saas商品管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.saas.subnav')
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
                <form id="per_page_from" action="{{ url('/saasProduct/lists') }}" method="POST">
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
                        条/页，显示 {{ $products->firstItem() }} 至 {{ $products->lastItem() }} 条，共 {{ $products->total() }} 条记录
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
                        @role(['buyer', 'director', 'admin'])
                        <th>成本价</th>
                        @endrole
                        <th>市场售价</th>
                        <th>建议售价</th>
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
                            <td class="table-name" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $product->title }}">
                                <span class="proname">{{ $product->tit }}</span>
                            </td>
                            <td>
                                @if ($product->supplier) {{ $product->supplier->nam }}【{{$product->supplier->type_val}}】 @endif
                            </td>
                            @role(['buyer', 'director', 'admin'])
                            <td>
                                {{ $product->cost_price }}
                            </td>
                            @endrole
                            <td>
                                {{ $product->market_price }}
                            </td>
                            <td>
                                {{ $product->sale_price }}
                            </td>
                            <td class="magenta-color text-center">{{$product->inventory}}</td>
                            <td class="table-mark" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $product->summary }}">{{ str_limit($product->summary, 80) }}</td>
                            <td>
                                <button class="btn btn-default btn-sm showSku" onclick="showSku({{$product->id}})">显示SKU</button>
                                <a class="btn btn-default btn-sm" href="{{ url('/product/edit') }}?id={{$product->id}}" target="_blank">详情</a>
                                <a class="btn btn-default btn-sm" href="{{ url('/saasProduct/info/') }}?id={{$product->id}}" target="_blank">设置</a>
                                <a class="btn btn-default btn-sm" href="{{ url('/saas/image') }}?id={{$product->id}}" target="_blank">相关素材</a>
                            </td>
                        </tr>
                        @foreach($product->productsSku as $sku)
                            <tr class="bone product{{$product->id}} active" active="0" hidden>
                                <td class="text-center"></td>
                                @if(in_array($product->status,[1,2,3]))
                                    <td></td>
                                @endif
                                <td>
                                    <img src="{{$sku->first_img}}"  class="img-thumbnail" style="width: 80px;">
                                </td>
                                <td>SKU<br>{{ $sku->number }}</td>
                                <td colspan="2">属性：{{ $sku->mode }}</td>
                                <td>{{ $sku->bid_price }}</td>
                                <td>{{ $sku->cost_price }}</td>
                                <td>{{ $sku->price }}</td>
                                <td class="magenta-color text-center">{{ $sku->quantity }}</td>
                                <td>{{ $sku->summary }}</td>
                                <td></td>
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
@endsection

@section('customize_js')
    @parent
    var _token = $('#_token').val();


    {{--展示隐藏SKU--}}
    function showSku(id) {
    var dom = '.product' + id;

    if($(dom).eq(0).attr('active') == 0){
    $(dom).each(function () {
    $(this).attr("active",1);
    });
    $(dom).show("slow");

    }else{
    $(dom).each(function () {
    $(this).attr("active",0);
    });
    $(dom).hide("slow");
    }

    }
@endsection
@section('load_private')
    @parent
    {{--<script>--}}
    $(function () { $("[data-toggle='popover']").popover(); });
    $('.operate-update-offlineEshop').click(function(){
    $(this).siblings().css('display','none');
    $(this).css('display','none');
    $(this).siblings('input[name=txtTitle]').css('display','block');
    $(this).siblings('input[name=txtTitle]').focus();
    });

    $('input[name=txtTitle]').bind('keypress',function(event){
    if(event.keyCode == "13") {
    $(this).css('display','none');
    $(this).siblings().removeAttr("style");
    $(this).siblings('.proname').html($(this).val());
    }
    });

    $('input[name=txtTitle]').bind('blur',function(){
    $(this).css('display','none');
    $(this).siblings().removeAttr("style");
    $(this).siblings('.proname').html($(this).val());
    });

    $('.per_page').change(function () {
    $("#per_page_from").submit();
    });
@endsection
