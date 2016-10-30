<script id="returned-product-form" type="text-x-mustache-tmpl">
@{{#purchase_sku_relation}}
<tr>
    <td><img src="@{{path}}" style="height: 50px; width: 50px;" class="img-thumbnail" alt="50x50"></td>
    <td class="fb">@{{number}}</td>
    <td>@{{name}}</td>
    <td>@{{mode}}</td>
    <td>@{{total}}元</td>
    <td>@{{count}}</td>
    <td>0</td>
    <td>
        <input type="hidden" name="sku_id[]" value="@{{sku_id}}">
        <input type="hidden" name="purchase_count[]" value="@{{count}}">
        <input type="text" class="form-control interger count" not_count="@{{count}}" placeholder="数量" name="count[]" value="">
    </td>
    <td>
        <input type="text" class="form-control interger" placeholder="金额" name="price[]" value="">
    </td>
</tr>
@{{/purchase_sku_relation}}
</script>