                                    <div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <h4 class="modal-title" id="gridSystemModalLabel">添加商品</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group">
                                                        <input id="sku_search_val" type="text" placeholder="SKU编码/商品名称" class="form-control">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-magenta query" id="sku_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                        </span>
                                                    </div>
                                                    <div class="mt-4r scrollt">
                                                        <div id="user-list"> 
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
                                                                <tbody id="sku-list">

                                                                   {{-- <tr>
                                                                        <td class="text-center">
                                                                            <input name="Order" class="sku-order" type="checkbox" active="0" value="1">
                                                                        </td>
                                                                        <td><img src="" alt="50x50" class="img-thumbnail" style="height: 50px; width: 50px;"></td>
                                                                        <td>伟哥</td>
                                                                        <td>18923405430</td>
                                                                        <td>100015</td>
                                                                        <td>北京北京市朝阳区马辛店</td>
                                                                    </tr>--}}

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer pb-r">
                                                        <div class="form-group mb-0 sublock">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                            <button type="button" id="choose-sku" class="btn btn-magenta">确定</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>