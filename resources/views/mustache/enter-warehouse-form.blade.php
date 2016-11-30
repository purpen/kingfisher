<script id="enterhouse-form" type="text-x-mustache-tmpl">
<div class="form-group">
    <label for="goodsSku" class="col-sm-2 control-label">商品扫描</label>
    <div class="col-sm-6">
        <input type="text" id="goodsSku" class="form-control">
    </div>
</div>
{{ csrf_field() }}
@{{#enter_warehouse}}
<input type="hidden" name="enter_warehouse_id" value="@{{id}}">
<div class="form-group">
    <label for="number" class="col-sm-2 control-label">仓库</label>
    <div class="col-sm-6">
        <p class="form-text">@{{storage_name}}</p>
    </div>
</div>
@{{/enter_warehouse}}

<table class="table table-hover table-bordered">
    <thead>
        <tr class="active">
            <th>SKU编码</th>
            <th>商品名称</th>
            <th>商品属性</th>
            <th>需入库数量</th>
            <th>已入库数量</th>
            <th>本次入库数量</th>
        </tr>
    </thead>
    <tbody>
        @{{#enter_sku}}
            <tr>
                <td class="magenta-color">
                    @{{number}}
                </td>
                <td>@{{name}}</td>
                <td>@{{mode}}</td>
                <td>@{{count}}</td>
                <td>@{{in_count}}</td>
                <td>
                    <input type="hidden" name="enter_sku_id[]" value="@{{id}}">
                    <input type="hidden" name="sku_id[]" value="@{{sku_id}}">
                    <input type="text" not_count="@{{not_count}}" name="count[]" class="form-control input-operate integer count" value="@{{not_count}}" data-toggle="popover" data-placement="top" data-content="数量不能大于可入库数量">
                </td>
            </tr>
        @{{/enter_sku}}
    </tbody>
    <tfoot>
        <tr class="active">
            <td colspan="3">合计</td>
            @{{#enter_warehouse}}
            <td>需入库：<span id="total" class="magenta-color">@{{count}}</span></td>
            <td>已入库：<span id="changetotal" spantotal="0" class="magenta-color">@{{in_count}}</span></td>
            <td>未入库：<span id="changetotal" spantotal="0" class="magenta-color">@{{not_count}}</span></td>
            @{{/enter_warehouse}}
        </tr>
    </tfoot>
</table>
<div class="form-group">
    <label for="summary" class="col-sm-2 control-label">入库备注</label>
    <div class="col-sm-8">
        <textarea rows="2" class="form-control" name="summary">@{{summary}}</textarea>
    </div>
</div>
</script>