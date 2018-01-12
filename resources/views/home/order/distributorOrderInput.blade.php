<div class="modal fade" id="distributorOrderInputModal" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">渠道分销订单导入</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/quDaoDistributorInput') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">分销商：</label>
                        <div class="col-md-9">
                            <select class="chosen-select" id="distributor_id" name="distributor_id" style="display: none;">
                                <option value="">选择分销商</option>
                                @foreach($distributors as $distributor)
                                    <option value="{{$distributor->id}}">{{ $distributor->distribution ? $distributor->distribution->name : $distributor->realname.'--'.$distributor->phone}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="col-sm-3 control-label p-0 lh-34 m-56">选择文件：</label>
                        <div class="col-sm-9">

                            <input type="file" name="file" clas="form-control">
                        </div>
                    </div>


                    {{--<input type="hidden" name="distributor_id" id="2distributor_id" clas="form-control">--}}

                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" id="sku_distributor_excel" class="btn btn-magenta">确定</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
