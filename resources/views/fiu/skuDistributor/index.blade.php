@extends('fiu.base')

@section('customize_css')
    @parent
        .check-btn{
            padding: 10px 0;
    		height: 30px;
    		position: relative;
    		margin-bottom: 10px !important;
    		margin-left: 10px !important;
        }
        .check-btn input{
	        z-index: 2;
		    width: 100%;
		    height: 100%;
		    top: 6px !important;
		    opacity: 0;
		    left: 0;
    		margin-left: 0 !important;
		    color: transparent;
		    background: transparent;
		    cursor: pointer;
        }
        .check-btn button{
			position: relative;
		    top: -11px;
		    left: 0;
        }
@endsection
@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="navbar-header">
				<div class="navbar-brand">
					SKU分销管理
				</div>
			</div>
			<div class="navbar-collapse collapse">
				@include('fiu.skuDistributor.subnav')
			</div>
		</div>
		@if (session('error_message'))
			<div class="alert alert-success error_message">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<p class="text-danger">{{ session('error_message') }}</p>
			</div>
		@endif
		<div class="container mainwrap">
			<div class="row">
                <div class="col-md-12">
					<a type="button" class="btn btn-white" href="{{url('/fiu/saas/skuDistributor/create')}}">
						<i class="glyphicon glyphicon-edit"></i> 添加SKU分销
					</a>
                </div>
			</div>
			

			<div class="row">
                <div class="col-md-12">
    				<table class="table table-bordered table-striped">
    					<thead>
    						<tr class="gblack">
								<th>分销id</th>
								<th>sku编号</th>
								<th>sku名称</th>
								<th>分销名称</th>
								<th>分销sku编号</th>
								<th>操作</th>
    						</tr>
    					</thead>
    					<tbody>
    						@foreach ($skuDistributors as $skuDistributor)
    							<tr>
									<td>{{ $skuDistributor->distributor_id}}</td>
									<td>{{ $skuDistributor->sku_number }}</td>
									<td>{{ $skuDistributor->sku_name}}</td>
									<td>{{ $skuDistributor->distributor_name}}</td>
									<td>{{ $skuDistributor->distributor_number}}</td>
    								<td>
										<a type="button" class="btn btn-default btn-sm" href="/fiu/saas/skuDistributor/edit?id={{ $skuDistributor->id }}">修改</a>
										<button class="btn btn-default btn-sm mr-2r" onclick=" destroySkuDistributor({{ $skuDistributor->id }})" value="{{ $skuDistributor->id }}">删除</button>
    								</td>
    							</tr>
    						@endforeach
    					</tbody>
    				</table>
                </div>
            </div>
            <div class="row">
				@if($skuDistributors->render())
					<div class="col-md-12 text-center">
						{!! $skuDistributors->appends(['search' => $search ])->render() !!}
					</div>
				@endif
			</div>


		</div>
    </div>
@endsection
@section('customize_js')
    @parent

    var _token = $("#_token").val();
    
	$('#addDistributorUser').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            account: {
                validators: {
                    notEmpty: {
                        message: '帐号不能为空！'
                    }
                }
            },
			realname: {
				validators: {
					notEmpty: {
						message: '昵称不能为空！'
					}
				}
			},
            phone: {
                validators: {
                    notEmpty: {
                        message: '手机号不能为空！'
                    },
					regexp: {
						regexp: /^1[34578][0-9]{9}$/,
						message: '手机号码不合法！'
					}
                }
            },
        }
    });

	function editSkuDistributor(id) {
		$.get('/fiu/saas/skuDistributor/ajaxEdit',{'id':id},function (e) {
			if (e.status == 1){
			$("#sku_dis_id").val(e.data.id);
			$("#sku_number2").val(e.data.sku_number);
			$("#distributor_number2").val(e.data.distributor_number);
			$('select').val(e.data.distributor_id);
			$('.selectpicker').selectpicker('refresh');
			$('#updateSkuDistributor').modal('show');
			}
		},'json');
	}

	function destroySkuDistributor (id) {
		if(confirm('确认删除该用户吗？')){
			$.post('/fiu/saas/skuDistributor/destroy',{"_token":_token,"id":id},function (e) {
				if(e.status == 1){
					location.reload();
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
    {{--<script>--}}
	@parent
	$(".check-btn input").click(function(){
		var keys = $(this).attr('key');
		if( $("input[key= "+keys+"]").is(':checked') ){
			$(this).siblings().addClass('active');
		}else{
			$(this).siblings().removeClass('active');
		}
	});

	$(".user-show").click(function () {
        var user_id = $(this).val();
        $.get('{{url('/fiu/saas/user/ajaxUserInfo')}}',{'id':user_id},function (e) {
            if(e.status == 1){
                var data = e.data;

                var template = $('#user_show_tmp').html();
                var views = Mustache.render(template, e.data);
                $("#user_show_content").html(views);

                console.log(data);
                $("#user_show").modal('show');
            }else if(e.status == 0){
                alert(e.message);
            }else{
                alert(e.msg);
            }
        },'json');

    });
@endsection