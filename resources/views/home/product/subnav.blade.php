<ul class="nav navbar-nav nav-list">
    <li @if($tab_menu == 'default')class="active"@endif><a href="{{url('/product')}}">全部</a></li>
    <li @if($tab_menu == 'unpublish')class="active"@endif><a href="{{url('/product/unpublishList')}}">待上架</a></li>
    <li @if($tab_menu == 'saled')class="active"@endif><a href="{{url('/product/saleList')}}">在售中</a></li>
    <li @if($tab_menu == 'canceled')class="active"@endif><a href="{{url('/product/cancList')}}">已取消</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <form class="navbar-form navbar-left" role="search" id="supplier_search" action="{{ url('/product/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <span>供应商</span>
            <div class="form-group">
                <div class="input-group">
                <select class="form-control chosen-select" id="add_supplier_id" onchange="submitForm(this.value);" name="supplier_id" style="display: none;">
                    <option value="0">选择供应商</option>
                    @foreach($suppliers as $supplier)
                            <option @if($supplier->id == $supplier_id) selected @endif value="{{ $supplier->id }}">{{ $supplier->nam }}</option>
                    @endforeach
                </select>
                </div>

            </div>
        </form>
    </li>
    <li>
        <form class="navbar-form navbar-left" role="search" id="search" action="{{ url('/product/search') }}" method="POST">
            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="{{$name}}" placeholder="货号、简称">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                </div>
            </div>
        </form>
    </li>
</ul>