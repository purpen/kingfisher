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
                                    <select class="chosen-select" name="product_id" style="display: none;">
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
                            <label for="site_from" class="col-sm-1 control-label">来源</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="site_from" value="{{$article->site_from}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="article_describe" class="col-sm-1 control-label">文章描述</label>
                            <div class="col-sm-6">
                                <textarea type="text" class="form-control" name="article_describe" value="">{{$article->article_describe}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-1 control-label">内容</label>
                            <div class="editor col-sm-6">
                                <textarea id='myEditor' name="content" class="control-label">{{$article->content}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">文章时间</label>
                            <div class="col-sm-6">
                                <input type="text" style="width:650px" class="input-append date" value="{{$article->article_time}}" id="datetimepicker" name="article_time">
                            </div>
                        </div>
                        <hr>
                        <h5>封面图<small class="text-warning">［仅支持后缀(jpeg,jpg,png)格式图片，大小4MB以内］</small><em>*</em></h5>
                        <div class="row mb-2r material-pic" id="update-article-img">
                            <div class="col-md-2">
                                <div id="picForm" enctype="multipart/form-data">
                                    <div class="img-add">
                                        <span class="glyphicon glyphicon-plus f46"></span>
                                        <p class="uptitle">添加封面图</p>
                                        <div id="update-article-uploader"></div>
                                    </div>
                                </div>
                                <input type="hidden" id="cover_id" name="cover_id"  value="{{$article->cover_id}}">
                                <script type="text/template" id="qq-template">
                                    <div id="add-img" class="qq-uploader-selector qq-uploader">
                                        <div class="qq-upload-button-selector qq-upload-button">
                                            <div>上传图片</div>
                                        </div>
                                        <ul class="qq-upload-list-selector qq-upload-list">
                                            <li hidden></li>
                                        </ul>
                                    </div>
                                </script>
                            </div>
                            <div class="col-md-2 mb-3r" style="display: none">
                                <div style="width: 70px;height: 5px;background: lightblue;">
                                    <div id="progress_bar" style="width: 0px;height: 5px;background: blue;"></div>
                                </div>
                            </div>
                            @foreach($article->materialLibraries as $materialLibrary)
                                <div class="col-md-2">
                                    <div class="asset">
                                        <img src="{{ $materialLibrary->file->small }}" style="width: 150px;" class="img-thumbnail">
                                        <a class="removeimg" value="{{ $materialLibrary->id }}"><i class="glyphicon glyphicon-remove"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
            author: {
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
                    },
                    stringLength: {
                        max: 200,
                        message:'最多为200个字符'
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

    new qq.FineUploader({
        element: document.getElementById('update-article-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: '{{ $material_upload_url }}',
            params:  {
                "token": '{{ $token }}',
                "x:random": '{{ $random }}',
            },
            inputName:'file',
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png'],
            sizeLimit: 31457280 // 4M = 4 * 1024 * 1024 bytes
        },
        messages: {
            typeError: "仅支持后缀['jpeg', 'jpg', 'png']格式文件",
            sizeError: "上传文件最大不超过30M"
        },
        //回调函数
        callbacks: {
            //上传完成后
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    console.log(responseJSON.success);
                    $("#cover_id").val(responseJSON.material_id);
                    $('#update-article-img').append('<div class="col-md-2"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.material_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');

                    $('.removeimg').click(function(){
                        var id = $(this).attr("value");
                        var img = $(this);
                        $.post('{{url('/material/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                            if(e.status){
                                img.parent().remove();
                            }else{
                                console.log(e.message);
                            }
                        },'json');

                    });
                } else {
                    alert('上传图片失败');
                }
            }
        }
    });
@endsection