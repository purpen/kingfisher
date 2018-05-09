@extends('home.base')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    收款单
                </div>
            </div>
            @include('home/receiveOrder.subnav')
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="formwrapper">
                        <form class="form-horizontal" id="create_receive" method="post" action="{{url('/receive/storeReceive')}}">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

                            <h5>付款人</h5>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">收款人:</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="payment_user">
                                </div>

                                <label class="col-sm-1 control-label">金额<small>(元)</small>:</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="amount">
                                </div>
                            </div>

                            <h5>收款人</h5>
                            <hr>

                            <div class="form-group">
                                <label class="col-sm-1  control-label">收款账号:</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <select class="selectpicker" id="payment_account_id" name="payment_account_id"
                                                style="display: none;">
                                            <option value=''>收款账号</option>
                                            @foreach($payment_account as $v)
                                                <option value="{{ $v->id }}">{{ $v->bank . ':' . $v->account }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-1 control-label">收款时间：</label>
                                <div class="col-md-4">
                                    <input type="text" name="receive_time" class="form-control pickday" value="">
                                </div>
                            </div>
                            

                            <h5>单据相关</h5>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">收支类型:</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <select class="selectpicker" name="type">
                                            <option value=''>收支类型</option>
                                            <option value="5">营销费</option>
                                            <option value="6">货款</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">备注说明:</label>
                                <div class="col-md-7">
                                    <textarea id="summary" name="summary" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-1">
                                    <button id="btnSave" type="submit" class="btn btn-magenta btn-lg mr-r save">确认保存
                                    </button>
                                    <button id="btnReturn" type="button" class="btn btn-default btn-lg"
                                            onclick="window.history.back()">返回
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customize_js')
    @parent
    {{--<script>--}}

    {{--前端验证--}}
    $("#create_receive").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok-sign',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            amount: {
                validators: {
                    notEmpty: {
                        message: '金额不能为空'
                    },
                    regexp: {
                        regexp: /^[0-9\.]+$/,
                        message: '格式不正确！'
                    }
                }
            },
            payment_user: {
                validators: {
                    notEmpty: {
                        message: '付款人不能为空！'
                    }
                }
            },
            type: {
                validators: {
                    notEmpty: {
                        message: '类型不能为空！'
                    }
                }
            },
            payment_account_id: {
                validators: {
                    notEmpty: {
                        message: '选择收款账号！'
                    }
                }
            }
        }
    });
@endsection