<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav nav-list">
        <li @if($subnav == 'waitReceive')class="active"@endif><a href="{{url('/receive')}}">应收款</a></li>
        <li @if($subnav == 'finishReceive')class="active"@endif><a href="{{url('/receive/complete')}}">已收款</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right mr-0" style="position: absolute;right: 0;">
        <li>
            <form class="navbar-form navbar-left" role="search" id="search" action="{{url('/receive/search')}}" method="POST">
                <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="subnav" value="{{$subnav}}">
                
                <div class="form-group mr-2r">
                    <a href="" class="btn btn-link">最近7天</a>
                    <a href="" class="btn btn-link">最近30天</a>
                </div>
                <div class="form-group mr-2r">
                    <label class="control-label">类型：</label>
                    <select class="selectpicker" name="type">
                        <option value="">收支类型</option>
                        <option value="3">订单</option>
                        <option value="4">采购退货</option>
                        <option value="5">营销费</option>
                        <option value="6">毛营业务收入</option>
                    </select>
                </div>
                <div class="form-group mr-2r">
                    <label class="control-label">日期：</label>
                    <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期" value="{{$start_date}}">
                    至
                    <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期" value="{{$end_date}}">
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="where" class="form-control" placeholder="编号">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default">查询</button>
                        </div><!-- /btn-group -->
                    </div><!-- /input-group -->
                </div>
            </form>
        </li>
    </ul>
</div>