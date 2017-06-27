@extends('home.base')

@section('title', '商品图片')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
	.m-92{
		min-width:92px;
		text-align:right;
		vertical-align: top !important;
    	line-height: 34px;
	}
	#picForm .form-control {
		top: 0;
	    left: 0;
	    position: absolute;
	    opacity: 0;
	    width: 100px;
	    height: 100px;
	    z-index: 3;
	    cursor: pointer;
	}
	#appendsku {
		margin-left:40px;
		font-size:14px;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					新增图片
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/image/store') }}">
						{!! csrf_field() !!}
						<input type="hidden" name="random" value="{{ $random }}">{{--图片上传回调随机数--}}
						<input type="hidden" name="cover_id" id="cover_id">
    					<h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
                            <label for="product_number" class="col-sm-1 control-label {{ $errors->has('product_number') ? ' has-error' : '' }}">*商品编号</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="product_number" value="{{$product_number}}" readonly>
                              @if ($errors->has('product_number'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('product_number') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>
						<div class="form-group">
							<label for="describe" class="col-sm-1 control-label">文字段</label>
							<div class="col-sm-6">
								<textarea  rows="10" cols="20" name="describe" class="form-control"></textarea>
							</div>
						</div>

    					<h5>商品图片</h5>
                        <hr>
    					<div class="row mb-2r material-pic">
    						<div class="col-md-2">
    							<div id="picForm" enctype="multipart/form-data">
    								<div class="img-add">
    									<span class="glyphicon glyphicon-plus f46"></span>
    									<p class="uptitle">添加图片</p>
    									<div id="add-image-uploader"></div>
    								</div>
    							</div>
    							<input type="hidden" id="cover_id" name="cover_id">
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

	new qq.FineUploader({
		element: document.getElementById('add-image-uploader'),
		autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
		// 远程请求地址（相对或者绝对地址）
		request: {
			{{--endpoint: 'https://up.qbox.me',--}}
			endpoint: '{{ $material_upload_url }}',
			params:  {
				"token": '{{ $token }}',
				"x:product_number": '{{ $product_number }}',
				"x:random": '{{ $random }}',
			},
			inputName:'file',
		},
		validation: {
			allowedExtensions: ['jpeg', 'jpg', 'png'],
			sizeLimit: 31457280 // 30M = 30 * 1024 * 1024 bytes
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
					$("#cover_id").val(responseJSON.asset_id);

					$('.material-pic').append('<div class="col-md-2"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
                    
					$('.removeimg').click(function(){
						var id = $(this).attr("value");
						var img = $(this);
						$.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
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