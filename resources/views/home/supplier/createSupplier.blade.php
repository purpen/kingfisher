@extends('home.base')

@section('title', '新增供应商')
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
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						新增供应商
					</div>
				</div>
                @include('home.supplier.subnav')
			</div>
		</div>
	</div>
	<div class="container mainwrap">
		<div class="row formwrapper">
			<div class="col-md-12">
				<h5>供应商信息</h5>
				<hr>
				<form class="form-horizontal" id="add-supplier" role="form" method="post" action="{{ url('/supplier/store') }}">
					{!! csrf_field() !!}
					<input type="hidden" name="random" id="create_sku_random" value="{{ $random[0] }}">{{--图片上传回调随机数--}}
					<div class="form-group">
						<label for="inputLegalPerson" class="col-sm-2 control-label">公司简称<em>*</em></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputNam" name="nam" placeholder="简称">
						</div>
						@if ($errors->has('nam'))
							<span class="help-block">
                                    <strong>{{ $errors->first('nam') }}</strong>
                                </span>
						@endif
						<label for="inputTel" class="col-sm-2 control-label">类型</label>
						<div class="col-sm-3">
							<select name="type" class="form-control selectpicker">
								<option value="1">采购</option>
								<option value="2">代销</option>
								<option value="3">代发</option>
							</select>
						</div>
					</div>
					<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="inputName" class="col-sm-2 control-label">公司名称<em>*</em></label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="inputName" name="name" placeholder="公司名称">
						</div>
						@if ($errors->has('name'))
							<span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
						@endif
					</div>
					<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
						<label for="inputAddress" class="col-sm-2 control-label">注册地址</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="inputAddress" name="address" placeholder="注册地址">
						</div>
						@if ($errors->has('address'))
							<span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
						@endif
					</div>

					<div class="form-group {{ $errors->has('bank_number') ? ' has-error' : '' }}">
						<label for="inputBank_number" class="col-sm-2 control-label">开户账号</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="inputBank_number" name="bank_number" placeholder="开户行号">
						</div>
						@if ($errors->has('bank_number'))
							<span class="help-block">
                                    <strong>{{ $errors->first('bank_number') }}</strong>
                                </span>
						@endif
					</div>
					<div class="form-group {{ $errors->has('bank_address') ? ' has-error' : '' }}">
						<label for="inputBank_address" class="col-sm-2 control-label">开户银行</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputBank_address" name="bank_address" placeholder="开户银行">
							@if ($errors->has('bank_address'))
								<span class="help-block">
                                        <strong>{{ $errors->first('bank_address') }}</strong>
                                    </span>
							@endif
						</div>

						<label for="inputAddress" class="col-sm-2 control-label">税号</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputEin" name="ein" placeholder="税号">
							@if ($errors->has('ein'))
								<span class="help-block">
                                        <strong>{{ $errors->first('ein') }}</strong>
                                    </span>
							@endif
						</div>
					</div>

					<div class="form-group {{ $errors->has('general_taxpayer') ? ' has-error' : '' }}">
						<label for="inputGeneral_taxpayer" class="col-sm-2 control-label">纳税方式</label>
						<div class="col-sm-7">
							<div class="radio-inline">
								<label class="mr-3r">
									<input type="radio" name="general_taxpayer" value="1" checked>一般纳税人
								</label>
								<label class="ml-3r">
									<input type="radio" name="general_taxpayer" value="0">小规模纳税人
								</label>
							</div>
						</div>
						@if ($errors->has('general_taxpayer'))
							<span class="help-block">
                                    <strong>{{ $errors->first('general_taxpayer') }}</strong>
                                </span>
						@endif
					</div>

					<div class="form-group">
						<label for="inputLegalPerson" class="col-sm-2 control-label">折扣<em>*</em></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputDiscount" name="discount" placeholder="折扣">
						</div>
						@if ($errors->has('discount'))
							<span class="help-block">
                                    <strong>{{ $errors->first('discount') }}</strong>
                                </span>
						@endif
						<label for="inputTel" class="col-sm-2 control-label">开票税率</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputTaxRate" name="tax_rate" placeholder="开票税率">
						</div>
					</div>

					<div class="form-group {{ $errors->has('legal_person') ? ' has-error' : '' }}">
						<label for="inputLegalPerson" class="col-sm-2 control-label">公司法人</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputLegalPerson" name="legal_person" placeholder="法人">
						</div>
						@if ($errors->has('legal_person'))
							<span class="help-block">
                                    <strong>{{ $errors->first('legal_person') }}</strong>
                                </span>
						@endif
						<label for="inputTel" class="col-sm-2 control-label">电话</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputTel" name="tel" placeholder="法人电话">
						</div>
						@if ($errors->has('tel'))
							<span class="help-block">
                                    <strong>{{ $errors->first('tel') }}</strong>
                                </span>
						@endif
					</div>
					<div class="form-group {{ $errors->has('contact_user') ? ' has-error' : '' }}">
						<label for="inputContactUser" class="col-sm-2 control-label">联系人<em>*</em></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="contact_user" name="contact_user" placeholder="联系人姓名 ">
						</div>
						@if ($errors->has('contact_user'))
							<span class="help-block">
                                    <strong>{{ $errors->first('contact_user') }}</strong>
                                </span>
						@endif
						<label for="inputContactNumber" class="col-sm-2 control-label">手机<em>*</em></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputContactNumber" name="contact_number" placeholder="联系人电话">
						</div>
						@if ($errors->has('contact_number'))
							<span class="help-block">
                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                </span>
						@endif

					</div>
					<div class="form-group {{ $errors->has('contact_number') ? ' has-error' : '' }}">
						<label for="inputContactEmail" class="col-sm-2 control-label">邮箱</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputContactEmail" name="contact_email" placeholder="联系人邮箱 ">
						</div>
						@if ($errors->has('contact_email'))
							<span class="help-block">
                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                </span>
						@endif
						<label for="inputContactQQ" class="col-sm-2 control-label">QQ</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="inputContactQQ" name="contact_qq" placeholder="QQ">
						</div>
						@if ($errors->has('contact_qq'))
							<span class="help-block">
                                    <strong>{{ $errors->first('contact_qq') }}</strong>
                                </span>
						@endif
					</div>

					<div class="form-group {{ $errors->has('contact_number') ? ' has-error' : '' }}">
						<label for="inputStartTime" class="col-sm-2 control-label">开始时间</label>
						<div class="col-sm-3">
							<input type="text" class="form-control datetimepicker" name="start_time" placeholder="合作开始时间 ">
						</div>
						@if ($errors->has('start_time'))
							<span class="help-block">
                                    <strong>{{ $errors->first('start_time') }}</strong>
                                </span>
						@endif
						<label for="inputEndTime" class="col-sm-2 control-label">结束时间</label>
						<div class="col-sm-3">
							<input type="text" class="form-control datetimepicker" name="end_time" placeholder="合作结束时间">
						</div>
						@if ($errors->has('end_time'))
							<span class="help-block">
                                    <strong>{{ $errors->first('end_time') }}</strong>
                                </span>
						@endif
					</div>

					<div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
						<label for="summary" class="col-sm-2 control-label">备注</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="inputSummary" name="summary" placeholder="备注">
						</div>
						@if ($errors->has('summary'))
							<span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
                            </span>
						@endif
					</div>
					<div class="row mb-0 pt-3r pb-2r ui white">
						<div class="col-md-12">
							<h5>合作协议扫描件<small class="text-warning">［请上传pdf文件］</small><em>*</em></h5>
						</div>
					</div>
					<div class="row mb-2r sku-pic">
						<div class="col-md-2 mb-3r">
							<div id="picForm" enctype="multipart/form-data">
								<div class="img-add">
									<span class="glyphicon glyphicon-plus f46"></span>
									<p>添加协议</p>
									<div id="add-sku-uploader"></div>
								</div>
							</div>
							<input type="hidden" id="create_cover_id" name="cover_id">
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
					</div><hr>
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
	{{--添加表单验证--}}
	$("#add-supplier").formValidation({
		framework: 'bootstrap',
		icon: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			name: {
				validators: {
					notEmpty: {
						message: '公司名称不能为空！'
					},
					stringLength: {
						min:1,
						max:50,
						message: '公司名称1-50字之间！'
					}
				}
			},
			nam: {
				validators: {
					notEmpty: {
						message: '公司简称不能为空！'
					}
				}
			},
			address: {
				validators: {
					stringLength: {
						min:1,
						max:100,
						message: '公司地址1-100字之间！'
					}
				}
			},
			legal_person: {
				validators: {
					stringLength: {
						min:1,
						max:15,
						message: '公司法人长度1-15字之间！'
					}
				}
			},
			tel: {
				validators: {
					regexp: {
						regexp:/^[0-9-]+$/,
						message: '联系方式包括为数字或-'
					}
				}
			},
			contact_user: {
				validators: {
					notEmpty: {
						message: '联系人不能为空！'
					},
					stringLength: {
						min:1,
						max:15,
						message: '联系人长度1-15字之间！'
					}
				}
			},
			contact_number: {
				validators: {
					regexp: {
						regexp: /^1[34578][0-9]{9}$/,
						message: '联系人手机号码格式不正确'
					},
					notEmpty: {
						message: '手机号不能为空！'
					},
					stringLength: {
						min:1,
						max:20,
						message: '长度1-20字之间！'
					}
				}
			},
			contact_email: {
				validators: {
					emailAddress: {
						message: '邮箱格式不正确'
					},
					stringLength: {
						min:1,
						max:50,
						message: '长度1-50字之间！'
					},
					emailAddress: {
						message: '邮箱地址格式有误'
					}
				}
			},
			contact_qq: {
				validators: {
					stringLength: {
						min:1,
						max:20,
						message: '长度1-50字之间！'
					}
				}
			}
		}
	});

	{{--创建供应商信息上传图片--}}
	new qq.FineUploader({
		element: document.getElementById('add-sku-uploader'),
		autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
		// 远程请求地址（相对或者绝对地址）
		request: {
			endpoint: 'https://up.qbox.me',
			params:  {
				"token": '{{ $token }}',
				"x:random": '{{ $random[0] }}',
				"x:user_id":'{{ $user_id }}'
			},
			inputName:'file',
		},
		validation: {
			allowedExtensions: ['pdf'],
			sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
		},
        messages: {
            typeError: "仅支持后缀['pdf']格式文件",
            sizeError: "上传文件最大不超过3M"
        },
		//回调函数
		callbacks: {
			//上传完成后
			onComplete: function(id, fileName, responseJSON) {
				if (responseJSON.success) {
					$("#create_cover_id").val(responseJSON.asset_id);
					$('.sku-pic').append('<div class="col-md-2"><a href="'+responseJSON.name+'" target="_blank"><img src="{{ url('images/default/PDF-2.png') }}" style="width: 150px;" class="img-thumbnail"></a><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
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
					alert('上传PDF失败');
				}
			},
            onProgress:  function(id,  fileName,  loaded,  total)  {
			    var number = loaded/total*70;
                console.log(number);
                $("#progress_bar").parent().parent().show();
                $("#progress_bar").css({'width':number+'px'});
                if(loaded == total){
                    $("#progress_bar").parent().parent().hide();
                }

            }
		}
	});

	{{--选则到货的时间--}}
	$('.datetimepicker').datetimepicker({
		language:  'zh',
		minView: "month",
		format : "yyyy-mm-dd",
		autoclose:true,
		todayBtn: true,
		todayHighlight: true,
	});
@endsection