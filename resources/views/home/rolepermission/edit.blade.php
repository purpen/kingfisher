@extends('home.base')

@section('title', '角色权限')
	
@section('customize_css')
    @parent
    .check-btn{
        width: 46px;
	    height: 30px;
	    position: relative;
    }
    .check-btn input{
        z-index: 2;
	    width: 100%;
	    height: 100%;
	    top: 6px !important;
	    opacity: 0;
	    color: transparent;
	    background: transparent;
	    cursor: pointer;
    }
    .check-btn button{
		position: absolute;
    	top: -4px;
    	left: 0;
    }
@endsection

@section('content')
    @parent
    <div class="frbird-erp">
		<div class="navbar navbar-default mb-0 border-n nav-stab">
			<div class="container mr-4r pr-4r">
				<div class="navbar-header">
					<div class="navbar-brand">
						编辑角色权限
					</div>
				</div>
			</div>
		</div>
		<form name="editPerRol" id="editPerRol" method="post" action="{{'/rolePermission/update'}}">
			<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
			<div class="form-group">
				<h5 for="category_id" class="col-sm-2 control-label">角色:</h5>
				<div class="col-sm-8">
					<select class="selectpicker" id="role_id" name="role_id">
						@foreach($role_all as $roleAll)
						<option value="{{$roleAll->id}}" {{$roleAll->id == $roles->id ? 'selected' : ''}}>{{$roleAll->display_name}}</option>
						@endforeach
					</select>
				</div>
			</div><br><hr>

			<div class="form-group">
				<h5 for="display_name" class="col-sm-2 control-label">分配权限:</h5>
				<div class="col-sm-8" >
					<table class="table">
						@for ($i = 0; $i < count($permission); $i++)
							@if ($i%2 == 0)
								<tr>
									@endif
									<td>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="permission[]" {{in_array($permission[$i]->id,$perR)?'checked' : ''}} value="{{$permission[$i]->id}}"> {{ $permission[$i]->display_name }}
											</label>
										</div>
									</td>
									@if ($i%2 == 1)
								</tr>
							@endif
						@endfor
					</table>
					<hr>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-magenta mr-r ">更改</button>
						<button type="button" class="btn btn-white cancel ">取消</button>
					</div>
				</div>
			</div>
		</form>
    </div>
@endsection
@section('customize_js')
    @parent


@endsection

