@extends('home.base')

@section('title', '商品详情')
@section('partial_css')
	@parent
	<link rel="stylesheet" href="{{ elixir('assets/css/fineuploader.css') }}">
@endsection
@section('customize_css')
	@parent
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
	.qq-upload-button {
		width: 100px;
		height: 100px;
		position: absolute !important;
	}
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
                    商品详情
				</div>
			</div>
		</div>
	</div>
	<div class="container mainwrap">
        <div class="row">
            <div class="col-md-12">
                <div class="formwrapper">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <h3 style="color: #9c0033">{{ $error }}</h3>
                        @endforeach
                    @endif
            		<form id="add-product" role="form" method="post" class="form-horizontal" action="{{ url('/product/update') }}">
                        {{ csrf_field() }}{{--token--}}
            			<input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
            			<input type="hidden" name="url" value="{{ $url }}">
            
                        <h5>商品分类</h5>
                        <hr>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">选择商品分类</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                					<select class="selectpicker" name="category_id">
                                        <option value="0">默认分类</option>
                                         @foreach($lists as $list)
                						<option value="{{ $list->id }}" {{ $product->category_id == $list->id?'selected':'' }}>{{ $list->title }}</option>
                                        @endforeach
                					</select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">选择供应商</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                					<select class="chosen-select" name="supplier_id">
                						@foreach($suppliers as $supplier)
                						<option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id?'selected':'' }}>{{ $supplier->nam }}</option>
                						@endforeach
                					</select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id" class="col-sm-2 control-label">商品类别</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <select class="selectpicker" name="product_type" style="display: none;">
                                        <option value="">选择类别</option>
                                        <option value="1" {{ $product->product_type == 1 ? 'selected' : '' }}>众筹商品</option>
                                    </select>
                                </div>
                            </div>
                        </div>
            			<h5>基本信息</h5>
                        <hr>
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">货号</label>
                            <div class="col-sm-3">
                                <input type="text" name="number" ordertype="b2cCode" class="form-control" value="{{ $product->number }}" readonly>
                                @if ($errors->has('number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label {{ $errors->has('number') ? ' has-error' : '' }}">商品名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="title" ordertype="b2cCode" class="form-control" value="{{ $product->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label for="tit" class="col-sm-2 control-label {{ $errors->has('tit') ? ' has-error' : '' }}">商品简称</label>
                            <div class="col-sm-4">
                                <input type="text" name="tit" ordertype="b2cCode" class="form-control" value="{{ $product->tit }}">
                                @if ($errors->has('tit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label for="cost_price" class="col-sm-2 control-label {{ $errors->has('cost_price') ? ' has-error' : '' }}">成本价<small>(元)</small></label>
                            <div class="col-sm-2">
                                <input type="text" id="cost_price" name="cost_price" ordertype="b2cCode" class="form-control" value="{{ $product->cost_price }}">
                                @if ($errors->has('cost_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cost_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <label for="market_price" class="col-sm-1 control-label {{ $errors->has('market_price') ? ' has-error' : '' }}">市场售价<small>(元)</small></label>
                            <div class="col-sm-2">
                                <input type="text" id="market_price" name="market_price" ordertype="b2cCode" class="form-control" value="{{ $product->market_price }}">
                                @if ($errors->has('market_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('market_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                
                            <label for="sale_price" class="col-sm-1 control-label {{ $errors->has('sale_price') ? ' has-error' : '' }}">建议售价<small>(元)</small></label>
                            <div class="col-sm-2">
                                <input type="text" id="sale_price" name="sale_price" ordertype="b2cCode" class="form-control" value="{{ $product->sale_price }}">
                                @if ($errors->has('sale_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sale_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="weight" class="col-sm-2 control-label {{ $errors->has('weight') ? ' has-error' : '' }}">重量<small>(kg)</small></label>
                            <div class="col-sm-3">
                                <input type="text" name="weight" ordertype="b2cCode" class="form-control" value="{{ $product->weight }}">
                                @if ($errors->has('weight'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="summary" class="col-sm-2 control-label {{ $errors->has('summary') ? ' has-error' : '' }}">备注说明</label>
                            <div class="col-sm-9">
                                <input type="text" name="summary" class="form-control" value="{{ $product->summary }}">
                                @if ($errors->has('summary'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('summary') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-2r" id="update-product-img">

                            <div class="col-md-2 mb-3r" style="display: none">
                                <div style="width: 70px;height: 5px;background: lightblue;">
                                    <div id="progress_bar" style="width: 0px;height: 5px;background: blue;"></div>
                                </div>
                            </div>
            				@foreach($assets as $asset)
                            <div class="col-md-2">
            					<div class="asset">
            						<img src="{{ $asset->file->p500 }}" style="width: 150px;" class="img-thumbnail">
            						<a class="removeimg" value="{{ $asset->id }}"><i class="glyphicon glyphicon-remove"></i></a>
            					</div>
                            </div>
            				@endforeach
                        </div>
                    
                        <hr>
                        @if(isset($product->productsSku))
                        <div class="form-group">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr class="gblack">
                                        <th>序号</th>
                                        <th>图片</th>
                                        <th>SKU编码</th>
                                        <th>标准进价</th>
                                        <th>成本价</th>
                                        <th>售价</th>
                                        <th>颜色/型号</th>
                                        <th>重量（kg）</th>
                                        <th>众筹数量</th>
                                        <th>备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->productsSku as $sku)
                                    <tr class=".tr">
                                        <td>{{ $sku->id }}</td>
                                        <td>
                                            <img src="{{$sku->first_img}}" class="img-thumbnail" style="width: 80px;">
                                        </td>
                                        <td>
                                           {{ $sku->number }}
                                        </td>
                                        <td>
                                            {{$sku->bid_price}}
                                        </td>
                                        <td>
                                            {{$sku->cost_price}}
                                        </td>
                                        <td>
                                            {{ $sku->price }}
                                        </td>
                                        <td>
                                            {{ $sku->mode }}
                                        </td>
                                        <td>
                                            {{ $sku->weight }}
                                        </td>
                                        <td>
                                            {{ $sku->zc_quantity }}
                                        </td>
                                        <td>
                                            {{ $sku->summary }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            {{--<div class="col-sm-12">--}}
                				{{--<button type="submit" class="btn btn-magenta mr-r btn-lg save">确认更新</button>--}}
                				{{--<button type="button" class="btn btn-white cancel btn-lg once" onclick="history.back(-1)">取消</button>--}}
                            {{--</div>--}}
                        </div>
            		</form>
                </div>
            </div>
        </div>

	</div>
@endsection

@section('partial_js')
	@parent
	<script src="{{ elixir('assets/js/fine-uploader.js') }}"></script>
@endsection

@section('customize_js')
    @parent
    var _token = $("#_token").val();


    {{--获取sku信息--}}
    function editSku(id) {
        $.get('{{ url('/productsSku/ajaxEdit') }}', {'id':id}, function (e) {
            $('#sku-id').val(e.data.id);
            $('#up-number').val(e.data.number);
            $('#up-price').val(e.data.price);
            $('#up-bid-price').val(e.data.bid_price);
            $('#up-cost-price').val(e.data.cost_price);
            $('#up-mode').val(e.data.mode);
            $('#up-weight').val(e.data.weight);
            $('#up-summary').val(e.data.summary);
            $('#up-zc_quantity').val(e.data.zc_quantity);
            $('#updateskuModal').modal('show');

            var template = ['@{{ #assets }}<div class="col-md-2 mb-3r">',
                '<img src="@{{ path }}" style="width: 100px;height: 100px;" class="img-thumbnail">',
                '<a class="removeimg" value="@{{ id }}">删除</a>',
                '</div>@{{ /assets }}'].join("");
                
            var views = Mustache.render(template, e.data);
            $('#update-sku-img').prepend(views);

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

        },'json');
    }

	new qq.FineUploader({
		element: document.getElementById('fine-uploader'),
		autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
		// 远程请求地址（相对或者绝对地址）
		request: {
			endpoint: 'https://up.qbox.me',
			params:  {
				"token": '{{ $token }}',
				"x:user_id":'{{ $user_id }}',
				"x:target_id":'{{ $product->id }}'
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
					$('#update-product-img').append('<div class="col-md-2"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
                    $("#cover_id").val(responseJSON.asset_id);
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
            allowedExtensions: ['jpeg', 'jpg', 'png'],
            sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
        },
        //回调函数
        callbacks: {
            //上传完成后
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    console.log(responseJSON.success);
                    $("#create_cover_id").val(responseJSON.asset_id);
                    $('#create-sku-img').append('<div class="col-md-4"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
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
            },
            onProgress:  function(id,  fileName,  loaded,  total)  {
                var number = loaded/total*70;
                $("#progress_bar_sku").parent().parent().show();
                $("#progress_bar_sku").css({'width':number+'px'});
                if(loaded == total){
                    $("#progress_bar_sku").parent().parent().hide();
                }

            }
        }
    });
    
    new qq.FineUploader({
        element: document.getElementById('update-sku-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: 'https://up.qbox.me',
            params:  {
                "token": '{{ $token }}',
                "x:random": '{{ $random[1] }}',
                "x:user_id":'{{ $user_id }}',
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
                    $("#update_cover_id").val(responseJSON.asset_id);
                    $('#update-sku-img').append('<div class="col-md-4"><img src="'+responseJSON.name+'" style="width: 150px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'"><i class="glyphicon glyphicon-remove"></i></a></div>');
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
            },
            onProgress:  function(id,  fileName,  loaded,  total)  {
                var number = loaded/total*70;
                $("#progress_bar_sku_e").parent().parent().show();
                $("#progress_bar_sku_e").css({'width':number+'px'});
                if(loaded == total){
                    $("#progress_bar_sku_e").parent().parent().hide();
                }

            }
        }
    });

    
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

    {{--删除sku--}}
    function destroySku(id) {
        if(confirm('确认删除该SKU吗？')){
            $.post('/productsSku/ajaxDestroy',{"_token":_token, "id":id},function (e) {
                if(e.status == 1){
                    location.reload();
                }else{
                    alert(e.message);
                }
            },'json');
        }
    }

    /*搜索下拉框*/
    $(".chosen-select").chosen({
        no_results_text: "未找到：",
        search_contains: true,
        width: "100%",
    });
@endsection

@section('load_private')
    @parent
    $("#appendsku").click(function(){
        $.get('/productsSku/uniqueNumber',{},function (e) {
            if(e.status){
                $("#add_number").val(e.data);
                $("#cost_price1").val($("#cost_price").val());
                $("#price").val($("#sale_price").val());
                $("#bid_price").val($("#market_price").val());
            }
        },'json');


        $("#appendskuModal").modal('show');
    });




    $('.removeimg').click(function(){
        var id = $(this).attr("value");
        var img = $(this);
        $.post('{{url('/asset/ajaxDelete')}}',{'id': id,'_token': _token},function (e) {
            if(e.status){
                img.parent().parent().remove();
            }else{
                console.log(e.message);
            }
        },'json');
    });


@endsection