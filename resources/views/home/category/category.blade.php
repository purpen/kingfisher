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
                                @if($list['type'] == 1)
                                <a class="list-group-item category-update" href="javascript:void(0);" value="{{$list['id']}}">{{ $list['title'] }}</a>
                                @endif
                            @endforeach
                        </ul>

                    </div>
                </div>

                <div class="panel-group" role="tablist">
                    <div class="panel-heading" role="tab">
                        <a class="panel-title collapsed" href="#collapseListGroup2" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseListGroup2">
                            <span class="glyphicon glyphicon-triangle-bottom mr-r" aria-hidden="true"></span>授权类型
                        </a>
                    </div>
                    <div id="collapseListGroup2" class="panel-collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false">
                        <ul class="list-group">
                            @foreach($product_list as $list)
                                @if($list['type'] == 2)
                                <a class="list-group-item category-update" href="javascript:void(0);" value="{{$list['id']}}">{{ $list['title'] }}</a>
                            @endif
                                    @endforeach
                        </ul>
                    </div>
                </div>

                <div class="panel-group" role="tablist">
                    <div class="panel-heading" role="tab">
                        <a class="panel-title collapsed" href="#collapseListGroup3" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseListGroup3">
                            <span class="glyphicon glyphicon-triangle-bottom mr-r" aria-hidden="true"></span>地域分类
                        </a>
                    </div>
                    <div id="collapseListGroup3" class="panel-collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false">
                        <ul class="list-group">
                            @foreach($product_list as $list)
                                @if($list['type'] == 3)
                                <a class="list-group-item category-update" href="javascript:void(0);" value="{{$list['id']}}">{{ $list['region'] }}</a>
                            @endif
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
                    if(e.data.type == 1){
                        {{--$("#type1").find("option[value=1]").attr("selected",true);--}}
                        {{--$("#type1").find("option[value=2]").attr("disabled","disabled");--}}
                        $("#type1").val('商品');
                    }else if(e.data.type == 2){
                        {{--$("#type1").find("option[value=2]").attr("selected",true);--}}
                        {{--$("#type1").find("option[value=1]").attr("disabled","disabled");--}}
                        $("#type1").val('授权类型');
                    }

                if(e.data.status == 1){
                    $("#status1").prop("checked", true);
                }else{
                    $("#status0").prop("checked", true);
                }
                $("#updateclass").modal('show');
            }else{
                alert(e.message);
            }

        },'json');
    });

    //根据下拉选框切换模块
    $(document).on("change","select[name='type']",function(){
        var _this = $(this);
        var val = $("select[name='type'] option:selected").val();
        if(val == 3){
            $("#showtwo").show();
            $("#showthree").show();
            $("#showfour").show();
            $("#showone").hide();
        }else{
            $("#showtwo").hide();
            $("#showthree").hide();
            $("#showfour").hide();
            $("#showone").show();
        }
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

    {{--返回城市--}}
    $(document).on("click","#showtwo",function () {
        var ids = $("select[name='province']").val();
        var _token = $('#_token').val();
        $.post("{{ url('/category/getCitys') }}",{_token:_token,id:ids},function(data){
            if(data.status){
                var str = "";
                for(var i=0;i< data.data.length;i++){
    str += "<input type='checkbox' name='city[]' id='city' class='checkcla' value='"+data.data[i].oid+"' style='margin: 5px'>"+data.data[i].name+""
                }
                $("#d1").append(str);
            }else{
                alert(data.message);
            }
        },'json');
    });

    {{--返回区/县--}}
    function okay()
    {
        obj = document.getElementsByName("city[]");
        var check_val = [];
        for(k in obj){
        if(obj[k].checked)
        check_val.push(obj[k].value);
        }
        var _token = $('#_token').val();
        $.post("{{ url('/category/getAreas') }}",{_token:_token,oid:check_val},function(data){
            if(data.status){
                var str = "";
                for(var i=0;i< data.data.length;i++){
                    str += "<input type='checkbox' name='area[]' id='area' class='checkcla' value='"+data.data[i].oid+"' style='margin: 5px'>"+data.data[i].name+""
                }
                $("#d2").append(str);
            }else{
                alert(data.message);
            }
        },'json');
    }

    $(document).on("click","#chooses",function () {
        {{--function chooses()--}}
        {{--{--}}
        obj = document.getElementsByName("area[]");
        var check_val = [];
        for(k in obj){
        if(obj[k].checked)
        check_val.push(obj[k].value);
        }
        var _token = $('#_token').val();
            $.post("{{ url('/category/getAll') }}",{_token:_token,oid:check_val},function(data){
                if(data.status)
                {
                    {{--layer.msg(data.message);--}}
                    {{--return false;--}}
                }else{
                 }
    });
    });



    {{--添加分类不允许重复--}}
    function sure()
    {
        var title = $("input[name='title']").val();
        var order = $("input[name='order']").val();
        var type  = $("select[name='type']").val();
        var _token = $('#_token').val();
        $.post("{{ url('/category/store') }}",{_token:_token,title:title,order:order,type:type},function(data){

            $("input[name='title']").val("");
            if(data.status == 1){
                layer.msg(data.message);
                return false;
            }else{
                layer.msg('保存成功！');
                window.location.reload();
            }
        },'json');
    }





@endsection
