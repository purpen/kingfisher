@extends('home.base')

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
            <div class="navbar-header">
                <div class="navbar-brand">
                    分类管理
                </div>
            </div>
        </div>
    </div>
    <div class="container mainwrap">
        <div class="row">
            <div class="col-md-2 classify" style="height: 580px;">
                <h5 class="ui dividing header">
                    全部分类
                </h5>
                <div class="plr-3r ptb-r">
                    <button type="button" class="btn btn-white" data-toggle="modal" data-target="#addclass">新增分类</button>
                </div>

                <div class="panel-group" role="tablist">
                    <div class="panel-heading" role="tab">
                        <a class="panel-title collapsed" href="#collapseListGroup1" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseListGroup1">
                            <span class="glyphicon glyphicon-triangle-bottom mr-r" aria-hidden="true"></span>商品分类
                        </a>
                    </div>
                    <div id="collapseListGroup1" class="panel-collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false">
                        <ul class="list-group">
                            @foreach($product_list as $list)
                                <a class="list-group-item category-update" href="javascript:void(0);" value="{{$list['id']}}">{{ $list['title'] }}</a>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@include('modal.add_category_product')
@include('modal.update_category_product')
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

    $(".category-update").click(function () {
        var id = $(this).attr('value');
        $.get('/category/ajaxEdit',{'id': id},function (e) {

            if(e.status == 1){
                $("#category_id").val(e.data.id);
                $("#title1").val(e.data.title);
                $("#order1").val(e.data.order);
                $("#updateclass").modal('show');
            }else{
                alert(e.message);
            }

        },'json');
    });

    $("#addclassify, #updateclassify").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: '分类名称不能为空'
                    }
                }
            },
            type: {
                validators: {
                    notEmpty: {
                        message: '请选择类型！'
                    }
                }
            },
            order: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '请填写数字'
                    }
                }
            }
        }
    });

    {{--添加分类不允许重复--}}
    function sure()
    {

        var title = $("input[name='title']").val();
        var order = $("input[name='order']").val();
        var type  = 1;
        var _token = $('#_token').val();
        $.post("{{ url('/category/store') }}",{_token:_token,title:title,order:order,type:type},function(data){

            {{--console.log(data);return false;--}}

            if(data.status == 1){
                {{--alert(data.message);--}}
                layer.msg(data.message);return false;
            }else{

                layer.msg('保存成功！');
                window.location.reload();
            }

        },'json');
    }


@endsection
