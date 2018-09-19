@extends('home.base')

@section('partial_css')
    @parent
    <link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection

@section('customize_css')
    @parent
    #form-user,#form-product,#form-jyi,#form-beiz {
    height: 245px;
    margin-bottom: 10px;
    overflow-x: hidden;
    overflow-y: scroll;
    padding-top: 10px;
    }
    .scrollspy{
    height:180px;
    overflow: scroll;
    margin-top: 10px;
    }
    .table{
    width: 100%;
    border-collapse:collapse;
    border-spacing:0;
    }
    .fixedThead{
    display: block;
    width: 100%;
    }
    .scrollTbody{
    display: block;
    height: 300px;
    overflow: auto;
    width: 100%;
    }
    .table td,.table th {
    width: 200px;
    border-bottom: none;
    border-left: none;
    border-right: 1px solid #CCC;
    border-top: 1px solid #DDD;
    padding: 2px 3px 3px 4px
    }
    .table tr{
    border-left: 1px solid #EB8;
    border-bottom: 1px solid #B74;
    }
    .loading{
    width:160px;
    height:56px;
    position: absolute;
    top:50%;
    left:50%;
    line-height:56px;
    color:#fff;
    padding-left:60px;
    font-size:15px;
    background: #000 url(images/loader.gif) no-repeat 10px 50%;
    opacity: 0.7;
    z-index:9999;
    -moz-border-radius:20px;
    -webkit-border-radius:20px;
    border-radius:20px;
    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
    }
@endsection

@section('content')
    @parent
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="navbar-header">
                <div class="navbar-brand">
                    发票审核记录
                </div>
            </div>
        </div>
    </div>
    @foreach($history as $value)
      <div style="border:1px solid rgb(121, 121, 121);width: 100%; display: inline-block">

            <label class="col-sm-1 control-label">发票类型</label>
            <div class="col-sm-4">
                @if ($value->receiving_id == 0)
                    <span class="label label-default">不开票 </span>
                @endif
                @if ($value->receiving_id == 1)
                    <span class="label label-default">增值税普通发票</span>
                @endif
                @if ($value->receiving_id == 2)
                    <span class="label label-default">增值税专用发票</span>
                @endif
            </div>

            <label class="col-sm-1 control-label" style="margin-left: -100px;">申请时间</label>
            <div class="col-sm-3">
                <span class="form-text text-danger">{{$value->application_time}} </span>
            </div>
            <label class="col-sm-1 control-label">发票状态</label>
            <div class="col-sm-3" style="margin-top: -25px;margin-left:90px;">
                @if ($value->receiving_type == 1)
                    <span class="label label-default">未开票</span>
                @endif
                    @if ($value->receiving_type == 2)
                        <span class="label label-default">审核中</span>
                    @endif
                    @if ($value->receiving_type == 3)
                        <span class="label label-default">已开票</span>
                    @endif
                    @if ($value->receiving_type == 4)
                        <span class="label label-default">拒绝</span>
                    @endif
                    @if ($value->receiving_type == 5)
                        <span class="label label-default">已过期</span>
                    @endif
                    @if ($value->receiving_type == '')
                        <span class="label label-default"></span>
                    @endif
            </div>
          <br><br>
            <label class="col-sm-1 control-label">驳回原因</label>
            <div class="col-sm-3">
                <textarea name="txt" clos=",50" rows="5" warp="virtual" disabled style="margin: 0px; height: 128px; width: 342px;">{{$value->reason}} </textarea>

            </div>
            <label class="col-sm-1 control-label">审核人</label>
            <div class="col-sm-3">
                <span class="form-text text-danger">{{$value->reviewer}} </span>
            </div>
          <label class="col-sm-1 control-label">审核时间</label>
          <div class="col-sm-3">
              <span class="form-text text-danger">{{$value->audit}} </span>
          </div> <label class="col-sm-1 control-label">单位地址</label>
          <div class="col-sm-3">
              <span class="form-text text-danger">{{$value->unit_address}} </span>
          </div> <label class="col-sm-1 control-label">电话号码</label>
          <div class="col-sm-3">
              <span class="form-text text-danger">{{$value->company_phone}} </span>
          </div>
          <label class="col-sm-1 control-label">企业名称</label>
          <div class="col-sm-3">
              <span class="form-text text-danger">{{$value->company_name}} </span>
          </div> <label class="col-sm-1 control-label">税号</label>
          <div class="col-sm-3">
              <span class="form-text text-danger"> {{$value->duty_paragraph}}</span>
          </div> <label class="col-sm-1 control-label">开户行名称</label>
          <div class="col-sm-3">
              <span class="form-text text-danger">{{$value->opening_bank}} </span>
          </div> <label class="col-sm-1 control-label">银行账户</label>
          <div class="col-sm-3">
              <span class="form-text text-danger"> {{$value->bank_account}}</span>
          </div>
          <label class="col-sm-1 control-label">收件人姓名</label>
          <div class="col-sm-3">
              <span class="form-text text-danger">{{$value->receiving_name}} </span>
          </div>
          <label class="col-sm-1 control-label">收件人电话</label>
          <div class="col-sm-3">
              <span class="form-text text-danger">{{$value->receiving_phone}} </span>
          </div>
          <label class="col-sm-1 control-label">收件人地址</label>
          <div class="col-sm-3">
              <span class="form-text text-danger"> {{$value->receiving_address}}</span>
          </div>
          @if($value->receiving_id == 2)
          <label class="col-sm-2 control-label">一般纳税人证明</label>
          <div class="col-sm-4">
              <img src={{$value->prove_url}} alt="100x100" class="img-thumbnail" >

          </div>
           @endif
     </div>
    @endforeach
@endsection