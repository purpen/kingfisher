@extends('home.base')

@section('title', '修改退货单')

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
                        修改退货单
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
        <form id="add-purchase" role="form" method="post" action="{{ url('/returned/update') }}">
            <div class="row ui white ptb-4r">
                <div class="col-md-3">采购退货单号：<span></span>{{$returned->number}}</div>
                <div class="col-md-3">采购单号：<span></span>{{$returned->purchase_number}}</div>
                <div class="col-md-3">供货商：<span>{{$returned->supplier}}</span></div>
                <div class="col-md-3">采购入库仓库：<span>{{$returned->purchase_storage}}</span></div>
            </div>
            <div class="row ui white ptb-4r">
                <h4>退货商品<span>共<span>{{$returned->count}}</span>件</span>-退货仓库：[{{$returned->storage}}]
                </h4>
                <input type="hidden" id="returned_id" name="returned_id" value="{{$returned->id}}">
                <input type="hidden" id="storage_id" name="storage_id" value="{{$returned->storage_id}}">
                <table class="table table-striped table-hover">
                    <thead class=" table-bordered">
                    <tr>
                        <th>商品图</th>
                        <th>SKU编码</th>
                        <th>商品名称</th>
                        <th>属性</th>
                        {{--<th>采购金额</th>
                        <th>数量</th>--}}
                        <th>退货数量</th>
                        <th>退货价格</th>
                    </tr>
                    </thead>
                    <tbody id="sku-list">
                    @foreach($returnedSkus as $returnedSku)
                        <tr>
                            <input type="hidden" name="returned_sku_id[]" value="{{$returnedSku->id}}">
                            <td><img src="{{$returnedSku->path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
                            <td class="fb">{{$returnedSku->number}}</td>
                            <td>{{$returnedSku->name}}</td>
                            <td>{{$returnedSku->mode}}</td>
                           {{-- <td>{{$returnedSku->total}}元</td>
                            <td>{{$returnedSku->count}}</td>--}}
                            <td><div class="form-group" style="width:100px;"><input type="text"  class="form-control interger" placeholder="输入数量" name="count[]" value="{{$returnedSku->count}}"></div></td>
                            <td><div class="form-group" style="width:100px;"><input type="text" class="form-control interger" placeholder="输入金额" name="price[]" value="{{$returnedSku
                            ->price}}"></div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div><h4><span>共计退款金额<span>{{$returned->price}}</span>元</span></h4></div>
                <div class="form-horizontal">
                    <div class="form-group mlr-0">
                        <div class="lh-34 m-56 ml-3r fl">备注</div>
                        <div class="col-sm-5 pl-0">
                            <textarea rows="3" class="form-control" name="summary" id="memo">{{$returned->summary}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4r pt-2r">
                <button type="submit" class="btn btn-magenta mr-r save">保存</button>
                <button type="button" class="btn btn-white cancel once"  onclick="window.history.back()">取消</button>
            </div>
            {!! csrf_field() !!}
        </form>
    </div>
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
        $("#add-purchase").formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'count[]': {
                    validators: {
                        notEmpty: {
                            message: '退货数量不能为空！'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: '退货数量填写不正确！'
                        }
                    }
                },
                'price[]': {
                    validators: {
                        notEmpty: {
                            message: '退货价格不能为空！'
                        },
                        regexp: {
                            regexp: /^[0-9\.]+$/,
                            message: '退货价格填写不正确！'
                        }
                    }
                },
            }
        });


@endsection
