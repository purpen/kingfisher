<script id="role-permission-form" type="text-x-mustache-tmpl">
<div class="form-group">
	<label for="role_id" class="col-sm-1 control-label">角色</label>
	<div class="col-sm-11">
		<select class="selectpicker" name="role_id">
            @{{#roles}}
				<option class="role_id2" value="@{{ id }}" @{{ selected }}>@{{ display_name }}</option>
            @{{/roles}}
		</select>
	</div>
</div>

<div class="form-group">
	<label for="display_name" class="col-sm-1 control-label">分配权限</label>
	<div class="col-sm-11" >
		<ul class="list-group permission-list">
            @{{#permissions}}
			<li class="item">
				<div class="checkbox">
					<label>
						<input type="checkbox" class="permission" name="permission[]"  value="@{{ id }}" @{{ checked }}> @{{ display_name }}
					</label>
				</div>
			</li>
            @{{/permissions}}
		</ul>
	</div>
</div>
</script>