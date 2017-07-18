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
    @include('UEditor::head');
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					编辑文章
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/saas/article/update') }}">
						{!! csrf_field() !!}
    					<h5>基本信息</h5>
                        <hr>
                        <input type="hidden" id="article_id" name="article_id" value="{{ $article->id }}">

                        <div class="form-group">
                            <label for="product_title" class="col-sm-1 control-label">选择商品</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select class="selectpicker" name="product_id" style="display: none;">
                                        <option value="">选择商品</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}"{{$product->number == $article->product_number ? 'selected' : ''}}>{{$product->title}}</option>
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
                                        <option value="0">默认</option>
                                        <option value="1"{{$article->article_type == 1 ? 'selected' : ''}}>创建</option>
                                        <option value="2"{{$article->article_type == 2 ? 'selected' : ''}}>抓取</option>
                                        <option value="3"{{$article->article_type == 3 ? 'selected' : ''}}>分享</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-1 control-label">标题</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="title" value="{{$article->title}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-sm-1 control-label">作者</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="author" value="{{$article->author}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="article_source" class="col-sm-1 control-label">来源</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="article_source" value="{{$article->article_source}}">
                            </div>
                        </div>
						<div class="form-group">
                            <label for="title" class="col-sm-1 control-label">内容</label>

                            <div class="col-sm-6">
                                <script id="container" style="height:200px;width:650px" name="content" type="text/plain">
                                    {!! $article->content !!}
                                </script>
                            </div>
						</div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">文章时间</label>
                            <div class="col-sm-6">
                                <input type="text" style="width:650px" class="input-append date" value="{{$article->article_time}}" id="datetimepicker" name="article_time">
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

    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'insertimage', 'fullscreen' , 'insertvideo' , 'source']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: true,
            wordCount: false,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        });        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        });
    </script>
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
                product_number: {
                    validators: {
                    notEmpty: {
                        message: '商品编号不能为空！'
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
@endsection