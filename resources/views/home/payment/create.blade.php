@extends('home.base')

@section('title', '付款单')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        付款单
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row formwrapper">
                <div class="col-md-12">
                    <form class="form-horizontal" id="create_payment" method="post" action="{{url('/payment/storePayment')}}">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

                        <h5>收款人</h5>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">收款人:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="receive_user">
                                {{--<label class="control-label">{{ $payable->receive_user }}</label>--}}
                            </div>

                            <label class="col-sm-1 control-label">应收款:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="amount">
                                {{--<label class="control-label">{{ $payable->amount }} 元</label>--}}
                            </div>
                        </div>

                        <h5>付款人</h5>
                        <hr>

                        <div class="form-group">
                            <label class="col-sm-1 control-label">付款账号:</label>
                            <div class="col-md-3">
                                <select class="selectpicker" id="payment_account_id" name="payment_account_id"
                                        style="display: none;">
                                    <option value=''>选择付款账号</option>
                                    @foreach($payment_account as $v)
                                        <option value="{{ $v->id }}">{{ $v->bank . ':' . $v->account }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-sm-1 control-label">付款时间:</label>
                            <div class="col-md-3">
                                <input type="text" id="datetimepicker" name="payment_time" class="form-control"
                                       value="">
                            </div>
                        </div>

                        <h5>单据相关</h5>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">收支类型:</label>
                            <div class="col-md-3">
                                <select class="selectpicker" id="" name="type" style="display: none;">
                                    <option value=''>收支类型</option>
                                    <option value="5">贷款</option>
                                    <option value="6">服务费</option>
                                    <option value="7">差旅费</option>
                                    <option value="8">日常报销</option>
                                    <option value="9">营销费</option>
                                </select>
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
@endsection
@section('customize_js')
    @parent
    {{--选则到货的时间--}}
    $('#datetimepicker').datetimepicker({
    language:  'zh',
    minView: "month",
    format : "yyyy-mm-dd",
    autoclose:true,
    todayBtn: true,
    todayHighlight: true,
    });

    {{--前端验证--}}
    $("#create_payment").formValidation({
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
            receive_user: {
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