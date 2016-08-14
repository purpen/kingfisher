@extends('home.base')

@section('title', '分类')
@section('customize_css')
    @parent
    .classify{
    background: rgba(221,221,221,0.3)
    }
    .classify .ui.dividing.header{
    padding: 5px 15px 10px;
    border-bottom: 1px solid rgba(0,0,0,0.2);
    font-size:16px;
    }
    .panel-group .panel-heading{
    padding: 20px;
    margin-top: 10px;
    position: relative;
    }
    .panel-title {
    font-size: 14px;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    padding: 0px 15px;
    line-height: 40px;
    text-decoration: none !important;
    }
    .panel-title:hover{
    background:#f5f5f5;
    }
    .panel-title.collapsed span.glyphicon.glyphicon-triangle-bottom {
    transform: rotate(-90deg);
    -webkit-transform: rotate(-90deg);
    }
    .panel-group .panel-heading+.panel-collapse>.list-group{
    margin-left: 15px;
    border: none;
    }
    .list-group-item{
    padding: 5px 15px;
    background-color: rgba(0,0,0,0);
    border: 0 !important;
    border-radius: 0 !important;
    }
    tr.bone > td{
    border:none !important;
    border-bottom: 1px solid #ddd !important;
    }
    tr.brnone > td{
    border: none !important;
    border-bottom: 1px solid #ddd !important;
    }
    .popover-content tr{
    line-height: 24px;
    font-size: 13px;
    }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        分类
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-2 p-0 m-0 classify" style="height: 580px;">
                <h5 class="ui dividing header">
                    全部分类
                </h5>
                <div class="plr-3r ptb-r">
                    <button type="button" class="btn btn-white" data-toggle="modal" data-target="#addclass">新增分类</button>
                    <div class="modal fade" id="addclass" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
                        <div class="modal-dialog modal-zm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="gridSystemModalLabel">新增分类</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="addclassify" class="form-horizontal" role="form" method="POST" action="{{ url('/category/store') }}">
                                        {!! csrf_field() !!}
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <label for="title" class="col-sm-2 control-label p-0 lh-34 m-56">分类名</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="title" class="form-control float" id="title" placeholder="输入分类名"  value="{{ old('title') }}">
                                                @if ($errors->has('title'))
                                                    <span class="help-block">
														<strong>{{ $errors->first('title') }}</strong>
													</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                                            <label for="order" class="col-sm-2 control-label p-0 lh-34 m-56">排序</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="order" class="form-control float" id="order" placeholder="选填"  value="{{ old('order') }}">
                                                @if ($errors->has('order'))
                                                    <span class="help-block">
														<strong>{{ $errors->first('order') }}</strong>
													</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="type" class="col-sm-2 control-label p-0 lh-34 m-56">类型</label>
                                            <div class="col-md-8 pl-4r ml-3r">
                                                <div class="form-inline">
                                                    <div class="form-group mb-0">
                                                        <select class="selectpicker" id="type" name="type" style="display: none;">
                                                            <option value="1">商品</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="modal-footer pb-r">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                <button type="submit" class="btn btn-magenta">确定</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-group" role="tablist">
                    <div class="panel-heading" role="tab">
                        <a class="panel-title collapsed" href="#collapseListGroup1" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseListGroup1">
                            <span class="glyphicon glyphicon-triangle-bottom mr-r" aria-hidden="true"></span>商品分类
                        </a>
                    </div>
                    <div id="collapseListGroup1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false">
                        <ul class="list-group">
                            @foreach($product_list as $list)
                                <a class="list-group-item" href="#">{{ $list['title'] }}</a>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">

@endsection
@section('customize_js')
    @parent
    {{--<script>--}}
    $("#checkAll").click(function () {
    $("input[name='Order']:checkbox").prop("checked", this.checked);
    });
    var _token = $('#_token').val();
    $(function () { $("[data-toggle='popover']").popover(); });

    $('.operate-update-offlineEshop').click(function(){
    $(this).siblings().css('display','none');
    $(this).css('display','none');
    $(this).siblings('input[name=txtTitle]').css('display','block');
    $(this).siblings('input[name=txtTitle]').focus();
    });
    $('input[name=txtTitle]').bind('keypress',function(event){
    if(event.keyCode == "13") {
    $(this).css('display','none');
    $(this).siblings().removeAttr("style");
    $(this).siblings('.proname').html($(this).val());
    }
    });
    $('input[name=txtTitle]').bind('blur',function(){
    $(this).css('display','none');
    $(this).siblings().removeAttr("style");
    $(this).siblings('.proname').html($(this).val());
    });


@endsection