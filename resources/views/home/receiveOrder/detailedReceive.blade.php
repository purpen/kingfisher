@extends('home.base')

@section('title', '收款单详细')

@section('customize_css')
    @parent

@endsection

@section('customize_js')
    {{--<script>--}}
    @parent

@endsection

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        收款单
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                </div>
            </div>
        </div>
        <div class="container mainwrap">
            <div class="prl10auto">

                <div class="panel prl10auto mt15" style="padding:20px 10px;">
                    <h5>付款人</h5>

                    <div class="row mt15 f14">
                        <div class="col-md-3">付款人：<span class="fb">{{$receive->payment_user}}</span></div>
                        <div class="col-md-3">应付款：<span class="fb">{{$receive->amount}}</span></div>
                    </div>

                </div>
                <form class="form-horizontal">
                    <div class="panel prl10auto" style="padding:20px 10px;">
                        <h5>收款人</h5>

                        <div class="row mt15 f14">
                            <div class="form-group col-md-3">
                                <select class="selectpicker" id="payment_account_id" name="payment_account_id" style="display: none;">
                                    <option value=''>选择收款账号</option>
                                    @foreach($payment_account as $v)
                                        <option value="{{ $v->id }}" {{$receive->payment_account_id == $v->id?'selected':''}}>{{ $v->account . ':' . $v->bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                付款时间：<input type="date" name="receive_time" value="{{$receive->receive_time}}">

                        </div>
                    </div>

                    <div class="panel prl10auto mt15" style="padding:20px 10px;">
                        <h5>单据相关</h5>

                        <div class="row mt15 f14">
                            <div class="col-md-3">收支类型：<span class="fb">{{$receive->type}}</span></div>
                            <div class="col-md-3">相关单据号：<span class="fb">{{$receive->target_number}}</span></div>
                        </div>
                        <div class="row mt15 f14">
                            <div class="col-md-3">创建时间：<span class="fb">{{$receive->created_at_val}}</span></div>
                            <div class="col-md-3">创建人：<span class="fb">{{$receive->user->realname}}</span></div>
                        </div>

                        <div class="form-group">
                            <div class="w50 left lh30 f14">备注</div>
                            <div class="col-sm-5"><textarea id="summary" name="summary" class="form-control" rows="5">{{$receive->summary}}</textarea></div>
                        </div>


                    </div>

                    <div style="padding:20px 10px 40px 10px">

                        <button id="btnReturn" type="button" class="btn btn-default" onclick="window.history.back()">返回</button>
                </form>
            </div>

        </div>
@endsection
