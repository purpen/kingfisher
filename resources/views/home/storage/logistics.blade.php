@extends('home.base')

@section('title', '物流')

@section('content')
    @parent
    <div class="frbird-erp">
        <div class="navbar navbar-default mb-0 border-n nav-stab">
            <div class="container mr-4r pr-4r">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        物流
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-list">
                        <li class="active"><a href="#">物流设置</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container mainwrap">
            <div class="row">
                <button type="button" class="btn btn-white" data-toggle="modal" data-target="#addlog">添加物流公司</button>
            </div>
            {{--  弹出框 --}}
            <div class="modal fade" id="addlog" tabindex="-1" role="dialog" aria-labelledby="addlogLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">物流公司信息</h4>
                        </div>
                        <div class="modal-body">
                            <form id="addusername">
                                <div class="row">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">快递名称：</div>
                                            <div class="form-group">
                                                <input type="text" name="username" ordertype="discountFee" class="form-control float" id="orderFee" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">对应快递公司：</div>
                                            <div class="form-group mb-0">
                                                <select class="selectpicker" id="orderType" style="display: none;">
                                                    <option value=" ">申通</option>
                                                    <option value=" ">顺丰</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group mr-3r">联系人：</div>
                                            <div class="form-group">
                                                <input type="text" name="username" ordertype="discountFee" class="form-control float" id="orderFee" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group">联系方式：</div>
                                            <div class="form-group">
                                                <input type="text" name="username" ordertype="discountFee" class="form-control float" id="orderFee" placeholder=" ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 lh-34">
                                        <div class="form-inline">
                                            <div class="form-group mr-3r pl-3r">备注：</div>
                                            <div class="form-group">
                                                <input type="text" name="username" ordertype="discountFee" class="form-control float" id="orderFee" placeholder=" " style="width: 475px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button id="submit_supplier" type="button" class="btn btn-magenta">保存</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="gblack">
                        <th>设为默认发货物流</th>
                        <th>物流公司</th>
                        <th>联系人</th>
                        <th>联系方式</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="checkbox mtb-0">
                                <label>
                                    <input type="checkbox">
                                    <div class="btn btn-gray btn-xs">默认</div>
                                </label>
                            </div>
                        </td>
                        <td>物流公司</td>
                        <td>物流公司</td>
                        <td>1323213231</td>
                        <td>
                            <button class="btn btn-gray btn-sm mr-2r" type="button" >停用</button>
                            <a href="javascript:void(0);" class="magenta-color">修改</a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>


    </div>
@endsection

@section('customize_js');
@parent

@endsection