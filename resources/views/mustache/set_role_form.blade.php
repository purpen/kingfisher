<script id="set-role-form" type="text-x-mustache-tmpl">
	<div class="form-group">
        <label for="role_id" class="col-sm-2 control-label">角色</label> 
		<div class="col-sm-10"> 
            <ul class="list-group permission-list">
                @{{#roles}}
            	<li class="item">
            		<div class="checkbox">
            			<label>
            				<input type="checkbox" class="permission" name="role_id"  value="@{{ id }}" @{{ checked }}> @{{ display_name }}
            			</label>
            		</div>
            	</li>
                @{{/roles}}
            </ul>
		</div>
	</div>
</script>