<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav nav-list">
        <li @if($subnav == 'auditingReceive')class="active"@endif><a href="{{url('/receive')}}">待财务审核</a></li>
        <li @if($subnav == 'waitReceive')class="active"@endif><a href="{{url('/receive/receive')}}">月结收款</a></li>
        <li @if($subnav == 'finishReceive')class="active"@endif><a href="{{url('/receive/complete')}}">已收款</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li>
            <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/receive/search')}}" method="POST">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" id="subnav" name="subnav" value="{{$subnav}}">
                
                <div class="form-group mr-2r">
                    <a href="{{url('/receive/search')}}?time=7&subnav={{$subnav}}" class="btn btn-link">最近7天</a>
                    <a href="{{url('/receive/search')}}?time=30&subnav={{$subnav}}" class="btn btn-link">最近30天</a>
                </div>
                <div class="form-group mr-2r">
                    <label class="control-label">类型：</label>
                    <select class="selectpicker" name="type">
                        <option value="">类型</option>
                        <option value="3" @if($type == 3) selected @endif>订单</option>
                        <option value="4" @if($type == 4) selected @endif>采购退货</option>
                        <option value="5" @if($type == 5) selected @endif>营销费</option>
                        <option value="6" @if($type == 6) selected @endif>货款</option>
                    </select>
                </div>
                <div class="form-group mr-2r">
                    <label class="control-label">日期：</label>
                    <input type="text" id="start_date" name="start_date" class="pickdatetime form-control" placeholder="开始日期" value="{{$start_date or ''}}">
                    至
                    <input type="text" id="end_date" name="end_date" class="pickdatetime form-control" placeholder="结束日期" value="{{$end_date or ''}}">
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="where" class="form-control" placeholder="收款单号/订单号/付款人" value="{{ $where or '' }}">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default">查询</button>
                        </div><!-- /btn-group -->
                    </div><!-- /input-group -->
                </div>
            </form>
        </li>
    </ul>
</div>