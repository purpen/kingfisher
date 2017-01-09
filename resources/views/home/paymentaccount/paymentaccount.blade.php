@extends('home.base')

@section('title', '付款账户')

@section('customize_css')
    @parent
    #erp_storage {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    background:#fff;
    }
    #erp_storageRacks {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    background:#fff;
    }
    #erp_storagePlaces {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    background:#fff;
    }
    .list-group-item:last-child{
    border-radius:0;
    }
    .list-group-item{
    border-left:none;
    border-right:none;
    border-top:none;
    margin-bottom:0;
    }
@endsection
@section('content')
    @parent
    
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    
    <div id="warning" class="alert alert-danger" role="alert" style="display: none">
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong id="showtext"></strong>
    </div>
    
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    财务资料
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-list">
                    <li class="active">
                        <a href="{{url('/paymentAccount')}}"> 付款账户
                        </a>
                    </li>
                    <li class="">
                        <a href="">收支类型
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
            	<div class="form-inline">
            		<div class="form-group mr-2r">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
                            <i class="glyphicon glyphicon-edit"></i> 添加账号
                        </button>
            		</div>
            	</div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="gblack">
                            <th class="text-center"><input type="checkbox" id="checkAll"></th>
                            <th>所属店铺</th>
                            <th>开户行</th>
                            <th>账号</th>
                            <th>默认收款账号</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentAccount as $d)
                            <tr>
                                <td class="text-center"><input type="checkbox"></td>
                                <td>{{$d->store->name}}</td>
                                <td>{{$d->bank}}</td>
                                <td>{{$d->account}}</td>
                                <td></td>
                                <td>{{$d->summary}}</td>
                                <td>
                                    <button type="button" class="btn btn-default btn-sm" onclick="editPayment({{ $d->id }})" value="{{ $d->id }}">编辑</button>
                                    <button type="button" class="btn btn-default btn-sm" onclick="destroyPayment({{ $d->id }})" value="{{ $d->id }}">删除</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{--弹出框--}}
            <!-- 更新Modal -->
            <div class="modal fade" id="updateMyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">更改付款账户</h4>
                        </div>
                        <div class="modal-body">
                            <form action="{{url('/paymentAccount/update')}}" class="form-horizontal" method="post" id="updatepayment">
                                {{ csrf_field() }}
                                <input type="hidden" id="id" name="id">
                                
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">选择店铺</label>
									<div class="col-sm-5">
                                        <div class="input-group">
                                            <select name="store_id" id="store_id1" class="select2 selectpicker">
                                                @foreach($store as $v)
                                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
									</div>
								</div>
                                
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">开户银行</label>
									<div class="col-sm-8">
                                        <input type="text" id="bank1" class="form-control" name="bank">
									</div>
								</div>
                                
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">账号</label>
									<div class="col-sm-8">
                                        <input type="text" id="account1" class="form-control float" name="account">
									</div>
								</div>
                                
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">备注</label>
									<div class="col-sm-8">
                                        <input type="text" id="summary1" class="form-control float" name="summary">
									</div>
								</div>
                                
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">备注</label>
									<div class="col-sm-8">
                                        <input type="text" id="summary1" class="form-control float" name="summary">
									</div>
								</div>
                                
								<div class="form-group mb-0">
									<div class="modal-footer pb-r">
                                        <button type="submit" class="btn btn-magenta">确认提交</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
									</div>
								</div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            {{--弹出框--}}
            <!-- 添加Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">新增付款账户</h4>
                        </div>
                        <div class="modal-body">
                            
                            <form action="{{url('/paymentAccount/store')}}" class="form-horizontal" method="post" id="addpayment">
                                {{ csrf_field() }}
                                
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">选择店铺</label>
									<div class="col-sm-5">
                                        <div class="input-group">
                                            <select name="store_id" id="store_id1" class="selectpicker">
                                                @foreach($store as $v)
                                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
									</div>
								</div>
                            
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">开户银行</label>
									<div class="col-sm-8">
                                        <input type="text" id="bank1" class="form-control" name="bank">
									</div>
								</div>
                            
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">账号</label>
									<div class="col-sm-8">
                                        <input type="text" id="account1" class="form-control float" name="account">
									</div>
								</div>
                            
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">备注</label>
									<div class="col-sm-8">
                                        <input type="text" id="summary1" class="form-control float" name="summary">
									</div>
								</div>
                            
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">备注</label>
									<div class="col-sm-8">
                                        <input type="text" id="summary1" class="form-control float" name="summary">
									</div>
								</div>
                                
								<div class="form-group mb-0">
									<div class="modal-footer pb-r">
                                        <button type="submit" class="btn btn-magenta">确认提交</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
									</div>
								</div>
                        
                            </form>
                                
                        </div>
                    </div>
                </div>
                
            </div>
                
        </div>
    </div>
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();
    
    function editPayment(id) {
        $.get('/paymentAccount/edit',{'id':id},function (e) {
            if (e.status == 1){
                $("#id").val(e.data.id);
                $("#store_id1").val(e.data.store_id);
                $("#bank1").val(e.data.bank);
                $("#account1").val(e.data.account);
                $("#summary1").val(e.data.summary);
                $('#updateMyModal').modal('show');
            }
        },'json');

    }

    function destroyPayment(id) {
        if(confirm('确认删除吗？')){
            $.post('/paymentAccount/destroy',{"_token":_token,"id":id},function (e) {
                if(e.status == 1){
                    location.reload();
                }else{
                    alert(e.message);
                }
            },'json');
        }

    }

@endsection

