@extends('home.base')

@section('customize_css')
    @parent
        
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="console">
                        <div class="media">
                            <a class="media-left" href="#">
                                <img class="avatar img-circle" src="{{ Auth::user()->cover ?  Auth::user()->cover->path : url('images/default/headportrait.jpg') }}" align="absmiddle">
                            </a>
                            <div class="media-body">
                                <span class="label label-danger">{{ Auth::user()->roles()->first()  ? Auth::user()->roles()->first()->display_name : '' }}</span>
                                <h4 class="media-heading mt-2r">{{ Auth::user()->account }}</h4>    
                                <p class="mt-2r">
                                    {{ $content }}
                                </p>                             
                            </div>
                        </div>
                        <hr>
                        <div class="tip-buttons">
                            
                            @permission('admin.order.viewlist')
                            <a class="btn btn-default" href="#">
                                 待付款订单 <span class="badge">0</span>
                            </a>
                            <a class="btn btn-default" href="#">
                                 待发货订单 <span class="badge">0</span>
                            </a>
                            <a class="btn btn-default" href="#">
                                 售后订单 <span class="badge">0</span>
                            </a>
                            @endpermission
                            
                            @permission('admin.supplier.viewlist')
                            <a class="btn btn-default" href="#">
                                 待审供应商 <span class="badge">0</span>
                            </a>
                            @endpermission
                            
                            @permission('admin.product.viewlist')
                            <a class="btn btn-default" href="#">
                                 待上架商品 <span class="badge">0</span>
                            </a>
                            @endpermission
                            
                            @permission('admin.purchase.viewlist')
                            <a class="btn btn-default" href="#">
                                 待审采购单 <span class="badge">0</span>
                            </a>
                            @endpermission
                            
                            @permission('admin.warehouse.viewlist')
                            <a class="btn btn-default" href="#">
                                 待审入库单 <span class="badge">0</span>
                            </a>
                            @endpermission
                            
                            @permission('admin.warehouse.viewlist')
                            <a class="btn btn-default" href="#">
                                 待审出库单 <span class="badge">0</span>
                            </a>
                            @endpermission
                            
                        </div>
                        <hr>
                        <div class="messages">
                            <div class="page-header">
                                <h5>操作记录 <small>注意警告或错误提醒</small></h5>
                            </div>
                            <ul class="list-group">
                                @foreach($messages as $message)
                                    <li class="row list-group-item list-group-item-warning">
                                        <span class="col-sm-11">{{$message->message}}</span>
                                        <span>
                                            <button class="btn btn-primary col-sm-1" type="button" id="confirm" value="{{$message->id}}">
                                                确认处理
                                            </button>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            @if ($messages)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">{!! $messages->render() !!}</div>
                </div>
            @endif
		</div>
    </div>
@endsection

@section('customize_js')
    @parent
    
    $("#confirm").click(function () {
        var id = $(this).attr('value');
        var _token = $("#_token").val();
        var dom = $(this).parent().parent();
        $.post('{{url('/home/ajaxConfirm')}}',{'_token':_token,'id':id},function (e) {
            if(e.status){
                dom.remove();
            }else{
                alert('e.message');
            }
        },'json');
    });
@endsection