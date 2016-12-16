<div class="modal fade bs-example-modal-lg" id="add_split_order" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">拆单</h4>
            </div>
            <div class="modal-body">
                <div  id="new_order">
                </div>
                <script id="new_order_list" type="text-x-mustache-tmpl">
                        <p>订单编号：<span class="magenta-color">@{{ number }}</span></p>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr class="gblack">
                                <th>SKU编码</th>
                                <th>名称</th>
                                <th>型号</th>
                                <th>价格</th>
                                <th>数量</th>
                                <th>优惠</th>
                            </tr>
                            </thead>
                            <tbody>
                                    @{{ #order_sku }}<tr>
                                        <td>@{{ number }}</td>
                                        <td>@{{ name }}</td>
                                        <td>@{{ mode }}</td>
                                        <td>@{{ sku_price }}</td>
                                        <td>@{{ quantity }}</td>
                                        <td>@{{ discount }}</td>
                                    </tr>@{{ /order_sku }}
                    </tbody>
                </table>
                <hr>
            </script>
                <div id="append_split_order">
                </div>
                <script id="split_order_list" type="text-x-mustache-tmpl">
                        <p>订单编号：<span class="magenta-color">@{{ order.number }}</span></p>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr class="gblack">
                                <th class="text-center"></th>
                                <th>SKU编码</th>
                                <th>名称</th>
                                <th>型号</th>
                                <th>价格</th>
                                <th>数量</th>
                                <th>优惠</th>
                            </tr>
                            </thead>
                            <tbody>
                                    @{{ #order_sku }}<tr>
                                        <td class="text-center">
                                            <input name="split_order" class="sku-order" type="checkbox" active="0" value="@{{ id }}">
                                        </td>
                                        <td>@{{ number }}</td>
                                        <td>@{{ name }}</td>
                                        <td>@{{ mode }}</td>
                                        <td>@{{ sku_price }}</td>
                                        <td>@{{ quantity }}</td>
                                        <td>@{{ discount }}</td>
                                    </tr>@{{ /order_sku }}
                    </tbody>
                </table>
            </script>
                <div class="row">
                    <button type="button" id="split_button" class="btn btn-magenta col-md-1 col-md-offset-10">拆单</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" id="split_order_true" class="btn btn-magenta">确定</button>
            </div>
        </div>
    </div>
</div>