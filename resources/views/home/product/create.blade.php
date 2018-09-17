@extends('home.base')

@section('title', '新增商品')
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
					新增商品
				</div>
			</div>
            <div class="navbar-collapse collapse">
                @include('home.product.subnav')
            </div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    <form id="add-product" role="form" class="form-horizontal" method="post" action="{{ url('/product/store') }}">
                        <input type="hidden" name="random" value="{{ $random }}">{{--图片上传回调随机数--}}
                        {{ csrf_field() }}{{--token--}}
        				<input type="hidden" name="cover_id" id="cover_id">
                        <h5>商品分类</h5>
                        <hr>
                        <div class="form-group">
                            <label for="category_id" class="col-sm-2 control-label">选择商品分类<em>*</em></label>
                            <div class="col-sm-3">
                                <div class="input-group  col-md-12">
        							<select class="selectpicker" name="category_id" style="display: none;">
                                        <option value="0">默认分类</option>
                                        @foreach($lists as $list)
                                            @if($list['type'] == 1)
        								<option value="{{ $list->id }}">{{ $list->title }}</option>
                                            @endif
                                        @endforeach
        							</select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="authorization_id" class="col-sm-2 control-label">选择授权类型<em>*</em></label>
                            <div class="col-sm-3">
                                <div class="input-group  col-md-12">
                                    <div class="col-sm-8" style="padding-top:5px">
                                        @foreach($lists as $list)
                                            @if($list['type'] == 2)
                                                <input type="checkbox" name="authorization_id" id="authorization_id" class="checkcla" required value="{{ $list->id }}">{{ $list->title }}
                                            @endif
                                        @endforeach

                                </div>
                                    <input type="hidden" name="Jszzdm" id="Jszzdm" value="@Model.Jszzdm" />
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="region_id" class="col-sm-2 control-label">选择地域分类<em>*</em></label>
                            <div class="col-sm-3">
                                <input type="checkbox" name="select_all" id="select_all">全选/取消全选
                                <div class="input-group  col-md-12">
                                    <div class="col-sm-8" style="width: 100%;margin-left: -15px">
                                        {{--<select class="chosen-select" name="region_id" style="display: none">--}}
                                            {{--<option value="">请选择省份</option>--}}
                                            @foreach($provinces as $v)
                                                <input type="checkbox" name="region_id" id="region_id" class="checkcla" value="{{ $v->id }}">{{ $v->name }}
                                                {{--<option value="{{ $v->id }}">{{ $v->name }}</option>--}}
                                            @endforeach
                                        {{--</select>--}}
                                </div>
                                    <input type="hidden" name="diyu" id="diyu" value="@Model.diyu" />
                            </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id" class="col-sm-2 control-label">选择供应商<em>*</em></label>
                            <div class="col-sm-3">
                                <div class="input-group col-md-11">
                                    <select class="chosen-select" name="supplier_id">
                                        <option value="">请选择供应商</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{--<label for="supplier_id" class="col-sm-2 control-label">商品类别</label>--}}
                            {{--<div class="col-sm-3">--}}
                                {{--<div class="input-group">--}}
                                    {{--<select class="selectpicker" name="product_type" style="display: none;">--}}
                                            {{--<option value="">选择类别</option>--}}
                                            {{--<option value="1">众筹商品</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
    					<h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">编号<em>*</em></label>
                            <div class="col-sm-3">
                                <input type="text" name="number" class="form-control" id="b2cCode" value="{{$number}}" readonly>
                                @if ($errors->has('number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label {{ $errors->has('title') ? ' has-error' : '' }}">商品名称<em>*</em></label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="title">
                              @if ($errors->has('title'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('title') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tit" class="col-sm-2 control-label {{ $errors->has('tit') ? ' has-error' : '' }}">商品简称<em>*</em></label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="tit">
                              @if ($errors->has('tit'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('tit') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="market_price" class="col-sm-2 control-label {{ $errors->has('cost_price') ? ' has-error' : '' }}">成本价<small>(元)</small><em>*</em></label>
                            <div class="col-sm-2">
                                <input type="text" name="cost_price" class="form-control">
                                @if ($errors->has('cost_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cost_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="market_price" class="col-sm-1 control-label {{ $errors->has('market_price') ? ' has-error' : '' }}">市场售价<small>(元)</small><em>*</em></label>
                            <div class="col-sm-2">
                              <input type="text" class="form-control" name="market_price" >
                              @if ($errors->has('market_price'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('market_price') }}</strong>
                                  </span>
                              @endif
                            </div>

                            <label for="sale_proce" class="col-sm-1 control-label {{ $errors->has('sale_proce') ? ' has-error' : '' }}">供货价<small>(元)</small><em>*</em></label>
                            <div class="col-sm-2">
        						<input type="text" name="sale_price" class="form-control">
                                @if ($errors->has('sale_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sale_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mode" class="col-sm-2 control-label">选择是否能月结<em>*</em></label>
                            <div class="col-sm-3">
                                <div class="input-group col-md-8">
                                    <select class="chosen-select" name="mode">
                                        {{--<option value="" >请选择是否月结</option>--}}
                                        <option value="2">非月结</option>
                                        <option value="1">月结</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    
                        <div class="form-group">
                            <label for="weight" class="col-sm-2 control-label {{ $errors->has('weight') ? ' has-error' : '' }}">重量(kg)</label>
                            <div class="col-sm-2">
                              <input type="text" class="form-control" name="weight">
                              @if ($errors->has('weight'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('weight') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="summary" class="col-sm-2 control-label {{ $errors->has('summary') ? ' has-error' : '' }}">备注说明</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="summary">
                              @if ($errors->has('summary'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('summary') }}</strong>
                                  </span>
                              @endif
                            </div>
                        </div>
    					<h5>商品图片<small class="text-warning">［仅支持后缀(jpeg,jpg,png)格式图片，大小3MB以内］</small></h5>
                        <hr>
    					<div class="row mb-2r sku-pic">
    						<div class="col-md-2">
    							<div id="picForm" enctype="multipart/form-data">
    								<div class="img-add">
    									<span class="glyphicon glyphicon-plus f46"></span>
    									<p class="uptitle">添加图片</p>
    									<div id="fine-uploader"></div>
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

                        <h5>商品介绍展示图片<small class="text-warning">［仅支持后缀(jpeg,jpg,png)格式图片，规格800*800，大小3MB以内］</small></h5>
                        <hr>
    					{{--<div class="row mb-2r product-pic">--}}
    						{{--<div class="col-md-2">--}}
    							{{--<div id="picForm" enctype="multipart/form-data">--}}
    								{{--<div class="image-add">--}}
    									{{--<span class="glyphicon glyphicon-plus f46"></span>--}}
    									{{--<p class="uptitles">添加图片</p>--}}
    									{{--<div id="fine-uploaders"></div>--}}
    								{{--</div>--}}
    							{{--</div>--}}
    							{{--<input type="hidden" id="product_details" name="product_details">--}}
    							{{--<script type="text/template" id="qq-template">--}}
    								{{--<div id="add-imgs" class="qq-uploader-selector qq-uploader">--}}
    									{{--<div class="qq-upload-button-selector qq-upload-button">--}}
    										{{--<div>上传图片</div>--}}
    									{{--</div>--}}
    									{{--<ul class="qq-upload-list-selector qq-upload-list">--}}
    										{{--<li hidden></li>--}}
    									{{--</ul>--}}
    								{{--</div>--}}
    							{{--</script>--}}
    						{{--</div>--}}
    					{{--</div>--}}
                        <div class="form-group">
                            <div class="editor col-sm-6">
                                <textarea id='myEditor' name="content" class="control-label"></textarea>
                            </div>
                        </div>
                        <br>

                        {{--<div class="form-group">--}}
                            {{--<label for="content" class="col-sm-2 control-label {{ $errors->has('content') ? ' has-error' : '' }}">商品展示</label>--}}
                            {{--<br>--}}
                            {{--<div class="col-sm-12">--}}
                                {{--<textarea id="container" style="height:300px;width:100%;" name="content"></textarea>--}}
                                {{--<script id="container" name="content" type="text/plain">--}}


                                {{--</script>--}}
                            {{--</div>--}}
                        {{--</div>--}}


                        <div class="form-group">
                            <div class="col-sm-12">
                				<button type="submit" class="btn btn-magenta btn-lg save">确认保存</button>
                                <button type="button" class="btn btn-white cancel btn-lg once"  onclick="window.history.back()">取消</button>
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
            authorization_id: {
                validators: {
                    notEmpty: {
                        message: '请选择授权类型！'
                    }
                }
            },
            region_id: {
            validators: {
            notEmpty: {
            message: '请选择地域分类'
            }
            }
            },
            {{--supplier_id: {--}}
                {{--validators: {--}}
                    {{--notEmpty: {--}}
                        {{--message: '请选择供应商！'--}}
                    {{--}--}}
                {{--}--}}
            {{--},--}}
            number: {
                validators: {
                    notEmpty: {
                        message: '编号不能为空！'
                    },
                    regexp: {
                        regexp: /^[0-9\-]+$/,
                        message: '编号格式不正确'
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
			tit: {
				validators: {
					notEmpty: {
						message: '商品简称不能为空！'
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
			market_price: {
				validators: {
					notEmpty: {
						message: '标准进价不能为空！'
					},
					regexp: {
						regexp: /^[0-9\.]+$/,
						message: '标准进价填写不正确'
					}
				}
			},
			cost_price: {
				validators: {
					notEmpty: {
						message: '成本价格不能为空！'
					},
					regexp: {
						regexp: /^[0-9\.]+$/,
						message: '成本价格填写不正确'
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


	new qq.FineUploader({
		element: document.getElementById('fine-uploader'),
		autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
		// 远程请求地址（相对或者绝对地址）
		request: {
			endpoint: 'https://up.qbox.me',
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
        messages: {
            typeError: "仅支持后缀['jpeg', 'jpg', 'png']格式文件",
            sizeError: "上传文件最大不超过3M"
        },
		//回调函数
		callbacks: {
			//上传完成后
			onComplete: function(id, fileName, responseJSON) {
				if (responseJSON.success) {
					console.log(responseJSON.success);
					$("#cover_id").val(responseJSON.asset_id);
                    
					$('.sku-pic').append('<div class="col-md-2"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
                    
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


    /*搜索下拉框*/
    $(".chosen-select").chosen({
        no_results_text: "未找到：",
        search_contains: true,
        width: "100%",
    });

    {{--授权条件--}}
        $("input[name='authorization_id']").change(function(){
            $('#Jszzdm').val($("input[name='authorization_id']:checked").map(function(){
    return this.value
    }).get().join(','))
        })

    {{--地域分类--}}
    $("input[name='region_id']").change(function(){
            $('#diyu').val($("input[name='region_id']:checked").map(function(){
    return this.value
    }).get().join(','))
        })

    {{--全选/全不选--}}
    $("#select_all").click(function(){
    if(this.checked){
    $("input[name='region_id']").prop("checked","true");
    $('#diyu').val($("input[name='region_id']:checked").map(function(){
    return this.value
    }).get().join(','))
    }else{
    $("input[name='region_id']").removeAttr("checked","true");
    $('#diyu').val($("input[name='region_id']:checked").map(function(){
    return this.value
    }).get().join(','))
    }
    })

@endsection