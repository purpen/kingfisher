@extends('home.base')

@section('title', '商品文章')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent

@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					新增文章
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/saas/article/store') }}">
						{!! csrf_field() !!}
    					<h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
                            <label for="product_title" class="col-sm-1 control-label">选择商品</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select class="chosen-select" name="product_id" style="display: none;">
                                        <option value="">选择商品</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="article_type" class="col-sm-1 control-label">文章分类</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select class="selectpicker" name="article_type" style="display: none;">
                                        <option value="">默认</option>
                                        <option value="1">创建</option>
                                        <option value="2">抓取</option>
                                        <option value="3">分享</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-1 control-label">标题</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="title" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-sm-1 control-label">作者</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="author" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site_from" class="col-sm-1 control-label">来源</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="site_from" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="article_describe" class="col-sm-1 control-label">文章描述</label>
                            <div class="col-sm-6">
                                <textarea type="text" class="form-control" name="article_describe" value=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-1 control-label">内容</label>
                            <div class="editor col-sm-6">
                                <textarea id='myEditor' name="content" class="control-label"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">文章时间</label>
                            <div class="col-sm-6">
                                <input type="text" style="width:650px" class="input-append date" id="datetimepicker" name="article_time">
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <div class="col-sm-12">
                				<button type="submit" class="btn btn-magenta btn-lg save">确认保存</button>
                				<button type="button" class="btn btn-white cancel btn-lg once" onclick="history.back()">取消</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
	</div>
	<input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
@endsection

@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
    @include('editor::head')
@endsection

@section('customize_js')
    @parent
    {{--<script>--}}
	var _token = $('#_token').val();

    $("#add-material").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
            fields: {
                product_id: {
                    validators: {
                    notEmpty: {
                        message: '商品不能为空！'
                    }
                }
            },
            article_type: {
                validators: {
                    notEmpty: {
                        message: ' 文章分类不能为空！'
                    }
                }
            },
            title: {
                validators: {
                    notEmpty: {
                        message: ' 标题不能为空！'
                    }
                }
            },
            site_from: {
                validators: {
                    notEmpty: {
                        message: ' 文章来源不能为空！'
                    }
                }
            },
            article_describe: {
                validators: {
                    notEmpty: {
                        message: ' 文章不能为空！'
                    }
                }
            }

        }
    });

    {{--选则到货的时间--}}
    $('#datetimepicker').datetimepicker({
        language:  'zh',
        minView: "month",
        format : "yyyy-mm-dd",
        autoclose:true,
        todayBtn: true,
        todayHighlight: true,
    });

    /*搜索下拉框*/
    $(".chosen-select").chosen({
        no_results_text: "未找到：",
        search_contains: true,
        width: "100%",
    });
@endsection