@extends('home.base')

@section('customize_css')
    @parent
    .check-btn{
    padding: 10px 0;
    height: 30px;
    position: relative;
    margin-bottom: 10px !important;
    margin-left: 10px !important;
    }
    .check-btn input{
    z-index: 2;
    width: 100%;
    height: 100%;
    top: 6px !important;
    opacity: 0;
    left: 0;
    margin-left: 0 !important;
    color: transparent;
    background: transparent;
    cursor: pointer;
    }
    .check-btn button{
    position: relative;
    top: -11px;
    left: 0;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        商品统计
                    </div>
                </div>

                <ul class="nav navbar-nav navbar-right mr-0">
                    <li class="dropdown">
                        <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/statistics/skuSale')}}" method="POST">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group mr-2r">
                                <label class="control-label">快速查看：</label>
                                <a href="{{url('/statistics/skuSale')}}?time=7" class="btn btn-link">最近7天</a>
                                <a href="{{url('/statistics/skuSale')}}?time=30" class="btn btn-link">最近30天</a>
                            </div>
                            <div class="form-group mr-2r">
                                <label class="control-label">筛选日期：</label>
                                <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期">
                                至
                                <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default">搜索</button>
                                    </div><!-- /btn-group -->
                                </div><!-- /input-group -->
                            </div>
                        </form>
                    </li>
                </ul>
                <div id="warning" class="alert alert-danger" role="alert" style="display: none">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="showtext"></strong>
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th>商品图</th>
                        <th>SKU编码</th>
                        <th>商品名称</th>
                        <th>型号</th>
                        <th>售价</th>
                        <th>销售数量</th>
                        <th>销售金额(元)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sku_list as $sku)
                        <tr>
                            <td><img src="{{ $sku->productsSku->first_img }}" class="img-thumbnail" style="width: 80px;"></td>
                            <td class="magenta-color">{{$sku->productsSku->number}}</td>
                            <td>{{ $sku->product->title }}</td>
                            <td>{{ $sku->productsSku->mode }}</td>
                            <td>{{$sku->productsSku->price}}</td>
                            <td>{{$sku->count}}</td>
                            <td>{{$sku->sale_money}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-2">{!! $sku_list->appends(['time' => $time, 'start_date' => $start_date, 'end_date' => $end_date ])->render() !!}</div>
            </div>
        </div>
    </div>
@endsection
@section('customize_js')
    @parent

@endsection