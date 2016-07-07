@extends('home.base')

@section('title', 'console')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
	.m-92{
		min-width:92px;
		text-align:right;
	}
	.img-add{
	    width: 100px;
	    height: 100px;
	    background: #f5f5f5;
	    vertical-align: middle;
	    text-align: center;
	    padding: 24px 0;
	}
	.img-add .glyphicon{
		font-size:30px;
	}
	#picForm{
		position:relative;
		color: #f36;
	    height: 100px;
	    text-decoration: none;
	    width: 100px;
	}
	#picForm:hover{
		color:#e50039;
	}
	#picForm .form-control{
		top: 0;
	    left: 0;
	    position: absolute;
	    opacity: 0;
	    width: 100px;
	    height: 100px;
	    z-index: 3;
	    cursor: pointer;
	}
	.removeimg{
	    position: absolute;
    	left: 75px;
    	bottom: 10px;
    	font-size: 13px;
	}
	#appendsku{
		margin-left:40px;
		font-size:14px;
	}
	.qq-uploader {
	    position: relative;
	    width: 100%;
	    width: 100px;
	    height: 100px;
	    top: 0;
	    left: 0;
	    position: absolute;
	    opacity: 0;
	}
	.qq-upload-button{
		width:100px;
		height:100px;
		position:absolute !important;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						添加商品
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		<form id="add-product" role="form" method="post" action="{{ url('/product/store') }}">
			<div class="row mb-0 ui white pt-3r pb-2r">
				<div class="col-md-12">
					<h5>商品分类</h5>
				</div>
			</div>
			<div class="row ui white pb-4r">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group">请选择商品分类：</div>
						<div class="form-group">
							<select class="selectpicker" id="orderType" name="category_id" style="display: none;">
                                <option value="0">未分类</option>
                            @foreach($lists as $list)
								<option value="{{ $list->id }}">{{ $list->title }}</option>
                            @endforeach
							</select>
						</div>
					</div>
				</div>
                <div class="col-md-4">
                    <div class="form-inline">
                        <div class="form-group">请选择供应商：</div>
                        <div class="form-group">
                            <select class="selectpicker" id="orderType" name="supplier_id" style="display: none;">
                                <option value="">选择供应商</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

			</div>
			<div class="row mb-0 pt-3r pb-2r ui white">
				<div class="col-md-12">
					<h5>基本信息</h5>
				</div>
			</div>
			<div class="row mb-0 pb-4r ui white">
                <input type="hidden" name="random" value="{{ $random }}">{{--图片上传回调随机数--}}
                {{ csrf_field() }}{{--token--}}
				<input type="hidden" name="cover_id" id="cover_id">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92 {{ $errors->has('number') ? ' has-error' : '' }}">货号：</div>
						<div class="form-group">
							<input type="text" name="number" ordertype="b2cCode" class="form-control" id="b2cCode">
                            @if ($errors->has('number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                            @endif
						</div>

					</div>
				</div>
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92 {{ $errors->has('title') ? ' has-error' : '' }}">商品名称：</div>
						<div class="form-group">
							<input type="text" name="title" ordertype="b2cCode" class="form-control" id="b2cCode">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
						</div>
					</div>
				</div>
			</div>
			<div class="row pb-4r ui white">
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92 {{ $errors->has('sale_proce') ? ' has-error' : '' }}">售价(元)：</div>
						<div class="form-group">
							<input type="text" name="sale_price" ordertype="b2cCode" class="form-control" id="b2cCode">
                            @if ($errors->has('sale_price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sale_price') }}</strong>
                                </span>
                            @endif
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-inline">
						<div class="form-group m-92 {{ $errors->has('weight') ? ' has-error' : '' }}">重量(kg)：</div>
						<div class="form-group">
							<input type="text" name="weight" ordertype="b2cCode" class="form-control" id="b2cCode">
                            @if ($errors->has('weight'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                            @endif
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-0 pt-3r pb-2r ui white">
				<div class="col-md-12">
					<h5>商品图片</h5>
				</div>
			</div>
			<div class="row mb-2r addcol pb-4r ui white">

				<div class="col-md-2 mb-3r">
					<div id="picForm" enctype="multipart/form-data">
						<div class="img-add">
							<span class="glyphicon glyphicon-plus f46"></span>
							<p>添加图片</p>
							<div id="fine-uploader"></div>
						</div>
					</div>

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
			</div>

			<div class="row mt-4r pt-2r">
				<button type="submit" class="btn btn-magenta mr-r save">保存</button>
				<button type="button" class="btn btn-white cancel once">取消</button>
			</div>
		</form>
		

	</div>
@endsection
@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
@endsection
@section('customize_js')
    @parent
    {{--<script>--}}
	var _token = $('#_token').val();
    /*$('#picForm input[type=file]').change(function(){
		var filebtnn = $('#picForm input[type=file]').val();
		var pos = filebtnn.lastIndexOf("\\");
		var filename = filebtnn.substring(pos+1);
		$('#picForm .filename').html(filename);
    });
	$('#addpicUrl').click(function(){
		if( $('#picForm .form-control').val() == '' && $('.tab-pane input[type=text]').val() == '' ){
			$('#Modalerror').modal('show');
		}
		else{
			$('.addcol').prepend('<div class="col-md-2 mb-3r"><img src="" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg">删除</a></div>');
			$('#add-img').modal('hide');
		}
	})*/

    $("#add-product").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            category_id: {
                validators: {
                    notEmpty: {
                        message: '请选择商品分类！'
                    }
                }
            },
            supplier_id: {
                validators: {
                    notEmpty: {
                        message: '请选择供应商！'
                    }
                }
            },
            number: {
                validators: {
                    notEmpty: {
                        message: '货号不能为空！'
                    },
                    regexp: {
                        regexp: /^[0-9\-]+$/,
                        message: '货号格式不正确'
                    }
                }
            },
            title: {
                validators: {
                    notEmpty: {
                        message: '商品名称不能为空！'
                    }
                }
            },
            sale_price: {
                validators: {
                    notEmpty: {
                        message: '商品价格不能为空！'
                    },
                    regexp: {
                        regexp: /^[0-9\.]+$/,
                        message: '商品价格填写不正确'
                    }
                }
            },
            weight: {
                validators: {
                    regexp: {
                        regexp: /^[0-9\.]+$/,
                        message: '重量填写不正确'
                    },
                }
            }

        }
    });

	$(document).ready(function() {
			new qq.FineUploader({
			element: document.getElementById('fine-uploader'),
			autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
			// 远程请求地址（相对或者绝对地址）
			request: {
				endpoint: 'http://upload.qiniu.com/',
				params:  {
					"token": '{{ $token }}',
					"x:random": '{{ $random }}',
					"x:user_id":'{{ $user_id }}'
				},
				inputName:'file',
			},
			validation: {
				allowedExtensions: ['jpeg', 'jpg', 'png'],
				sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
			},
			//回调函数
			callbacks: {
				//上传完成后
				onComplete: function(id, fileName, responseJSON) {
					if (responseJSON.success) {
						console.log(responseJSON.success);
						$("#cover_id").val(responseJSON.asset_id);
						$('.addcol').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;height: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
					} else {
						alert('上传图片失败');
					}
				}
			}
		});
	});

	$('.removeimg').click(function(){
		$(this).parent().remove();
	});

@endsection