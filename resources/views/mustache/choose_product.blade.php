<script id="choose-product-form" type="text-x-mustache-tmpl">
<table class="table table-bordered table-striped">
    <thead>
        <tr class="gblack">
            <th class="text-center"><input type="checkbox" id="checkAll"></th>
            <th>商品图</th>
            <th>SKU编码</th>
            <th>商品名称</th>
            <th>属性</th>
            <th>库存</th>
        </tr>
    </thead>
    <tbody>
        @{{#data}}
        <tr>
            <td class="text-center"><input class="sku-order" type="checkbox" active="0" value="@{{id}}"></td>
            <td><img src="@{{ path }}" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
            <td>@{{ number }}</td>
            <td>@{{ name }}</td>
            <td>@{{ mode }}</td>
            <td>@{{ count }}</td>
        </tr>
        @{{/data}}
    </tbody>
</table>
</script>