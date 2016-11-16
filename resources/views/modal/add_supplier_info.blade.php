{{--填加供应商弹窗--}}
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加供应商信息</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="addSupplier" role="form" method="POST" action="{{ url('/supplier/store') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="random" id="create_sku_random" value="{{ $random[0] }}">{{--图片上传回调随机数--}}
                    <div class="form-group">
                        <label for="inputLegalPerson" class="col-sm-2 control-label">公司简称<em>*</em></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputNam" name="nam" placeholder="简称">
                        </div>
                        <label for="inputTel" class="col-sm-2 control-label">类型</label>
                        <div class="col-sm-3">
                            <select name="type" class="form-control selectpicker">
                                <option value="1">采购</option>
                                <option value="2">代销</option>
                                <option value="3">代发</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="inputName" class="col-sm-2 control-label">公司名称<em>*</em></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name" placeholder="公司名称">
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="inputAddress" class="col-sm-2 control-label">注册地址</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputAddress" name="address" placeholder="注册地址">
                        </div>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('bank_number') ? ' has-error' : '' }}">
                        <label for="inputBank_number" class="col-sm-2 control-label">开户账号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputBank_number" name="bank_number" placeholder="开户行号">
                        </div>
                        @if ($errors->has('bank_number'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('bank_number') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('bank_address') ? ' has-error' : '' }}">
                        <label for="inputBank_address" class="col-sm-2 control-label">开户银行</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputBank_address" name="bank_address" placeholder="开户银行">
                            @if ($errors->has('bank_address'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('bank_address') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <label for="inputAddress" class="col-sm-2 control-label">税号</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputEin" name="ein" placeholder="税号">
                            @if ($errors->has('ein'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ein') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('general_taxpayer') ? ' has-error' : '' }}">
                        <label for="inputGeneral_taxpayer" class="col-sm-2 control-label">纳税方式</label>
                        <div class="col-sm-10">
                            <div class="radio-inline">
                                <label class="mr-3r">
                                    <input type="radio" name="general_taxpayer" value="1" checked>一般纳税人
                                </label>
                                <label class="ml-3r">
                                    <input type="radio" name="general_taxpayer" value="0">小规模纳税人
                                </label>
                            </div>
                        </div>
                        @if ($errors->has('general_taxpayer'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('general_taxpayer') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="inputLegalPerson" class="col-sm-2 control-label">折扣<em>*</em></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputDiscount" name="discount" placeholder="折扣">
                        </div>
                        <label for="inputTel" class="col-sm-2 control-label">开票税率</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputTaxRate" name="tax_rate" placeholder="开票税率">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('legal_person') ? ' has-error' : '' }}">
                        <label for="inputLegalPerson" class="col-sm-2 control-label">公司法人</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputLegalPerson" name="legal_person" placeholder="法人">
                        </div>
                        @if ($errors->has('legal_person'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('legal_person') }}</strong>
                                </span>
                        @endif
                        <label for="inputTel" class="col-sm-2 control-label">电话</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputTel" name="tel" placeholder="法人电话">
                        </div>
                        @if ($errors->has('tel'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('tel') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('contact_user') ? ' has-error' : '' }}">
                        <label for="inputContactUser" class="col-sm-2 control-label">联系人<em>*</em></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contact_user" name="contact_user" placeholder="联系人姓名 ">
                        </div>
                        @if ($errors->has('contact_user'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('contact_user') }}</strong>
                                </span>
                        @endif
                        <label for="inputContactNumber" class="col-sm-2 control-label">手机<em>*</em></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputContactNumber" name="contact_number" placeholder="联系人电话">
                        </div>
                        @if ($errors->has('contact_number'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                </span>
                        @endif

                    </div>
                    <div class="form-group {{ $errors->has('contact_number') ? ' has-error' : '' }}">
                        <label for="inputContactEmail" class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputContactEmail" name="contact_email" placeholder="联系人邮箱 ">
                        </div>
                        @if ($errors->has('contact_email'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                </span>
                        @endif
                        <label for="inputContactQQ" class="col-sm-2 control-label">QQ</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="inputContactQQ" name="contact_qq" placeholder="QQ">
                        </div>
                        @if ($errors->has('contact_qq'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('contact_qq') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('summary') ? ' has-error' : '' }}">
                        <label for="summary" class="col-sm-2 control-label">备注</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputSummary" name="summary" placeholder="备注">
                        </div>
                        @if ($errors->has('summary'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="row mb-0 pt-3r pb-2r ui white">
                        <div class="col-md-12">
                            <h5>合作协议扫描件<em>*</em></h5>
                        </div>
                    </div>
                    <div class="row mb-2r sku-pic">
                        <div class="col-md-2 mb-3r">
                            <div id="picForm" enctype="multipart/form-data">
                                <div class="img-add">
                                    <span class="glyphicon glyphicon-plus f46"></span>
                                    <p>添加协议</p>
                                    <div id="add-sku-uploader"></div>
                                </div>
                            </div>
                            <input type="hidden" id="create_cover_id" name="cover_id">
                            <script type="text/template" id="qq-template">
                                <div id="add-img" class="qq-uploader-selector qq-uploader">
                                    <div class="qq-upload-button-selector qq-upload-button">
                                        <div>上传图片</div>
                                    </div>
                                    <ul class="qq-upload-list-selector qq-upload-list">
                                        <li hidden></li>
                                    </ul>
                                </div>
                            </script>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="modal-footer pb-r">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button id="submit_supplier" type="submit" class="btn btn-magenta">确认提交</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>