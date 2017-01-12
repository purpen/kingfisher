@extends('home.base')

@section('title', '付款单')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    付款单管理
                </div>
            </div>
            <div class="navbar-collapse collapse">
                @include('home.payment.subnav')
            </div>
        </div>
        <div class="container mainwrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="formwrapper">
                        <form class="form-horizontal" id="create_payment" method="post" action="{{url('/payment/storePayment')}}">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

                        <h5>收款人</h5>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">收款人:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="receive_user">
                            </div>

                            <label class="col-sm-1 control-label">金额<small>(元)</small>:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="amount">
                            </div>
                        </div>

                        <h5>付款人</h5>
                        <hr>

                        <div class="form-group">
                            <label class="col-sm-1 control-label">付款账号:</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select class="selectpicker" id="payment_account_id" name="payment_account_id">
                                        <option value=''>选择付款账号</option>
                                        @foreach($payment_account as $v)
                                            <option value="{{ $v->id }}">{{ $v->bank . ':' . $v->account }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label class="col-sm-1 control-label">付款时间:</label>
                            <div class="col-md-3">
                                <input type="text" name="payment_time" class="form-control pickday">
                            </div>
                        </div>

                        <h5>单据相关</h5>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">收支类型:</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select class="selectpicker" id="" name="type">
                                        <option value=''>收支类型</option>
                                        <option value="5">货款</option>
                                        <option value="6">服务费</option>
                                        <option value="7">差旅费</option>
                                        <option value="8">日常报销</option>
                                        <option value="9">营销费</option>
                                        <option value="10">手续费</option>
                                        <option value="11">福利费</option>
                                        <option value="12">办公费</option>
                                        <option value="13">业务招待费</option>
                                        <option value="14">推广费</option>
                                        <option value="15">房屋水电费</option>
                                        <option value="16">公积金</option>
                                        <option value="17">社保</option>
                                        <option value="18">印花税</option>
                                        <option value="19">个人所得税</option>
                                        <option value="20">税金</option>
                                        <option value="21">固定资产</option>
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
@endsection
@section('customize_js')
    @parent


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