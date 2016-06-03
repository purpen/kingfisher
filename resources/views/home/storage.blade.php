 @extends('home.base')

@section('title', '仓储')

@section('customize_css')
    @parent
    #erp_storage {
    width: auto;
    height: 460px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: auto;
    }
@endsection
@section('content')
    @parent
    <div class = 'container-fluid'>
        <div class="row">
            <div class="col-md-6">
                <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1"> 全部
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2"> 空闲
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <h5 style="padding: 0px 20px; line-height: 30px;">
                   <strong>仓库</strong>
                    <span class="pull-right">
                        <button class="btn btn-default" type="button">添加仓库</button>
                    </span>
                </h5>
                <div id="erp_storage">
                    <div class="list-group">
                        <a href="" class="list-group-item">
                            <h5 class="list-group-item-heading">默认仓库
                                <i class="glyphicon"> (空闲)</i>
                                <span class="pull-right">
                                <button class="btn btn-default btn-xs" type="button">删除</button>
                                <button class="btn btn-default btn-xs" type="button">信息</button>
                                </span>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <h5 style="padding: 0px 20px; line-height: 30px;">
                    <strong>仓区</strong>
                    <span class="pull-right">
                        <button class="btn btn-default" type="button">添加仓区</button>
                    </span>
                </h5>
                <div id="erp_storage">
                    <div class="list-group">
                        <a href="" class="list-group-item">
                            <h5 class="list-group-item-heading">默认仓区
                                <i class="glyphicon"> (空闲)</i>
                                <span class="pull-right">
                                <button class="btn btn-default btn-xs" type="button">删除</button>
                                <button class="btn btn-default btn-xs" type="button">信息</button>
                                </span>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <h5 style="padding: 0px 20px; line-height: 30px;">
                    <strong>仓位</strong>
                    <span class="pull-right">
                        <button class="btn btn-default" type="button">添加仓位</button>
                    </span>
                </h5>
                <div id="erp_storage">
                    <div class="list-group">
                        <a href="" class="list-group-item">
                            <h5 class="list-group-item-heading">默认仓库
                                <i class="glyphicon"> (空闲)</i>
                                <span class="pull-right">
                                <button class="btn btn-default btn-xs" type="button">删除</button>
                                <button class="btn btn-default btn-xs" type="button">信息</button>
                                </span>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection