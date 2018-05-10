<div class="modal fade" id="distributorOrderOutModal" tabindex="-1" role="dialog" aria-labelledby="addclassLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">分销订单导出</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ url('/getQuDaoDistributorData') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">分销商：</label>
                        <div class="col-md-9">
                            <select class="chosen-select" id="distributor_id" name="distributor_id" style="display: none;">
                                <option value="">选择分销商</option>
                                @foreach($distributors as $distributor)
                                    <option value="{{$distributor->id}}">{{ $distributor->distribution ? $distributor->distribution->name : $distributor->phone.'--'.$distributor->realname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">开始日期：</label>
                        <div  class="col-md-9">
                            <input type="text" name="start_date" class="pickdatetime form-control" placeholder="开始日期" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">结束日期：</label>
                        <div class="col-md-9">
                            <input type="text" name="end_date" class="pickdatetime form-control" placeholder="结束日期" value="">
                        </div>

                    </div>

                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" id="distributorOrderOutSubmit" class="btn btn-magenta">导出</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>