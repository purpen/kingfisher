@extends('home.base')

@section('title', '商品视频')
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
					新增视频
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-material" role="form" class="form-horizontal" method="post" action="{{ url('/saas/video/store') }}">
						{!! csrf_field() !!}
						<input type="hidden" name="random" value="{{ $random }}">{{--图片上传回调随机数--}}
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
							<label for="describe" class="col-sm-1 control-label">文字段</label>
							<div class="col-sm-6">
								<textarea  rows="10" cols="20" name="describe" class="form-control"></textarea>
							</div>
						</div>

    					<h5>商品视频<small class="text-warning">［仅支持后缀(mp4)格式文件,大小10M以内］</small><em>*</em></h5>
                        <hr>
    					<div class="row mb-2r material-video">
    						<div class="col-md-2">
    							<div id="picForm" enctype="multipart/form-data">
    								<div class="img-add">
    									<span class="glyphicon glyphicon-plus f46"></span>
    									<p class="uptitle">添加视频</p>
    									<div id="add-video-uploader"></div>
    								</div>
    							</div>
    							<input type="hidden" id="cover_id" name="cover_id">
    							<script type="text/template" id="qq-template">
    								<div id="add-img" class="qq-uploader-selector qq-uploader">
    									<div class="qq-upload-button-selector qq-upload-button">
    										<div>上传视频</div>
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
				describe: {
                    validators: {
                    notEmpty: {
                        message: '文字段不能为空！'
                    },
					stringLength: {
					max: 500,
					message:'最多为500个字符'
					}
                }
            }

        }
    });

	new qq.FineUploader({
		element: document.getElementById('add-video-uploader'),
		autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
		// 远程请求地址（相对或者绝对地址）
		request: {
			{{--endpoint: 'https://up.qbox.me',--}}
			endpoint: '{{ $material_upload_url }}',
			params:  {
				"token": '{{ $token }}',
				"x:random": '{{ $random }}',
			},
			inputName:'file',
		},
		validation: {
			{{--allowedExtensions: ['mpg' , 'm4v' , 'mp4' , 'flv' , '3gp' , 'mov' , 'avi' , 'rmvb' , 'mkv' , 'wmv' ],--}}
			allowedExtensions: ['mp4' ],
			sizeLimit: 10485760 // 10M = 10 * 1024 * 1024 bytes
		},
        messages: {
            typeError: "仅支持后缀['mp4' ]格式文件",
            sizeError: "上传文件最大不超过10MB"
        },
		//回调函数
		callbacks: {
			//上传完成后
			onComplete: function(id, fileName, responseJSON) {
				if (responseJSON.success) {
					console.log(responseJSON.success);
					$("#cover_id").val(responseJSON.asset_id);
					var videoPath = responseJSON.name;

					$('.material-video').append('<div class="col-md-2"><a onclick="AddressVideo(\''+videoPath+'\')" data-toggle="modal" data-target="#Video"><img src="{{ url('images/default/video.png') }}" style="width: 150px;" class="img-thumbnail"></a><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
                    
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
					alert('上传视频失败');
				}
			}
		}
	});

	{{--视频地址--}}
	function AddressVideo (address) {
		var address = address;
		document.getElementById("videoAddress").src = address;
	}

	/*搜索下拉框*/
	$(".chosen-select").chosen({
		no_results_text: "未找到：",
		search_contains: true,
		width: "100%",
	});
@endsection