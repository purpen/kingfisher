<div class="modal fade" id="add_order_user" tabindex="-1" role="dialog" aria-labelledby="adduserLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="gridSystemModalLabel">选择用户</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input id="order_user_search_val" type="text" placeholder="用户名/收件人/手机" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-magenta query" id="order_user_search" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
                <div class="mt-4r scrollt">
                    <div id="user-list-option">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr class="gblack">
                                <th>用户名</th>
                                <th>收件人</th>
                                <th>联系方式</th>
                                <th>地址</th>
                            </tr>
                            </thead>
                            <tbody id="user-list-info">

                             {{--<tr class="order_user_id" value="1">--}}
                                 {{--<td>搜索</td>--}}
                                 {{--<td>伟哥</td>--}}
                                 {{--<td>渠道</td>--}}
                                 {{--<td>15619902233</td>--}}
                                 {{--<td>北京北京市朝阳区马辛店</td>--}}
                             {{--</tr>--}}

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer pb-r">
                    <div class="form-group mb-0 sublock">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>