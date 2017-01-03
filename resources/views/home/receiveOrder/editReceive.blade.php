@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        收款单详情
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row formwrapper">
                <div class="col-md-12">
                    <form class="form-horizontal" method="post" action="{{url('/receive/updateReceive')}}">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" value="{{$receive->id}}">

                        <h5>付款人</h5>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">付款人:</label>
                            <div class="col-md-3">
                                <label class="control-label">{{$receive->payment_user}}</label>
                            </div>

                            <label class="col-sm-1 control-label">应付款<small>(元)</small>:</label>
                            <div class="col-md-3">
                                <label class="control-label">{{$receive->amount}} 元</label>
                            </div>
                        </div>

                        <h5>收款人</h5>
                        <hr>

                        <div class="form-group">
                            <label class="col-sm-1 control-label">收款账号:</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <select class="selectpicker" id="payment_account_id" name="payment_account_id" style="display: none;">
                                        <option value=''>选择收款账号</option>
                                        @foreach($payment_account as $v)
                                            <option value="{{ $v->id }}" {{$receive->payment_account_id == $v->id?'selected':''}}>{{ $v->account . ':' . $v->bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label class="col-sm-1 control-label">付款时间：</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control pickday" name="receive_time" value="{{$receive->receive_time}}">
                            </div>
                        </div>

                        <h5>单据相关</h5>
                        <hr>
                        <div class="form-group">
                            <div class="col-md-3">收支类型：<span class="fb">{{$receive->type_val}}</span></div>
                            <div class="col-md-3">相关单据号：<span class="fb">{{$receive->target_number}}</span></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">创建时间：<span class="fb">{{$receive->created_at_val}}</span></div>
                            <div class="col-md-3">创建人：<span class="fb">{{$receive->user->realname}}</span></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">备注说明:</label>
                            <div class="col-md-7">
                                <textarea id="summary" name="summary" class="form-control" rows="5">{{$receive->summary}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-1">
                                <button id="btnSave" type="submit" class="btn btn-magenta btn-lg mr-r save">确认保存</button>
                                <button id="btnReturn" type="button" class="btn btn-default btn-lg" onclick="window.history.back()">返回</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection