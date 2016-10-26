@extends('home.base')

@section('title', '付款单详情')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        付款单详情
                    </div>
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row formwrapper">
                <div class="col-md-12">
                    <form class="form-horizontal" method="post" action="{{url('/payment/updatePayable')}}">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" value="{{$payable->id}}">
                
                        <h5>收款人</h5>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">收款人:</label>
                            <div class="col-md-3">
                                <label class="control-label">{{ $payable->receive_user }}</label>
                            </div>
                    
                            <label class="col-sm-1 control-label">应收款:</label>
                            <div class="col-md-3">
                                <label class="control-label">{{ $payable->amount }} 元</label>
                            </div>
                        </div>
                
                        <h5>付款人</h5>
                        <hr>
                    
                        <div class="form-group">
                            <label class="col-sm-1 control-label">付款账号:</label>
                            <div class="col-md-3">
                                <p class="form-text"></p>
                            </div>
                    
                            <label class="col-sm-1 control-label">付款时间:</label>
                            <div class="col-md-3">
                                <p class="form-text">{{$payable->payment_time}}</p>
                            </div>
                        </div>
                    
                        <h5>单据相关</h5>
                        <hr>
                        <div class="form-group">
                            <div class="col-md-3">收支类型：<span class="fb">{{$payable->type}}</span></div>
                            <div class="col-md-3">相关单据号：<span class="fb">{{$payable->target_number}}</span></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">创建时间：<span class="fb">{{$payable->created_at_val}}</span></div>
                            <div class="col-md-3">创建人：<span class="fb">{{$payable->user->realname}}</span></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">备注说明:</label>
                            <div class="col-md-7">
                                 <p class="form-text">{{$payable->summary}}</p>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button id="btnReturn" type="button" class="btn btn-default" onclick="window.history.back()">返回列表</button>
                </div>
            </div>
        </div>
    </div>
@endsection
