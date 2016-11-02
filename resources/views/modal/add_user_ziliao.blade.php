{{--更改--}}
<div class="modal fade" id="updateuser1" tabindex="-1" role="dialog" aria-labelledby="updateuser1Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">更改个人资料</h4>
            </div>
            <div class="modal-body">
                <form id="updateuser" role="form" class="form-horizontal" method="post" action="{{ url('/update') }}">
                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id" id="user_id" value="{{Auth::user()->id}}" >
                    <div class="form-group">
                        <label for="account" class="col-sm-2 control-label p-0 lh-34 m-56">帐号：</label>
                        <div class="col-sm-8">
                            <input type="text" name="account" class="form-control float" id="account1" placeholder="帐号" value="{{Auth::user()->account}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label p-0 lh-34 m-56">手机号：</label>
                        <div class="col-sm-8">
                            <input type="text" name="phone" class="form-control float" value="{{Auth::user()->phone}}" id="phone1" placeholder="手机号码">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sex" class="col-sm-2 control-label  p-0 lh-34 m-56">性别 : </label>
                        <div class="col-sm-8">
                            @if(Auth::user()->sex == 1)
                                男<input type="radio" checked value="1" name="sex" id="sex1">&nbsp&nbsp
                                女<input type="radio" value="0" name="sex" id="sex0">
                            @else
                                男<input type="radio" value="1" name="sex" id="sex1">&nbsp&nbsp
                                女<input type="radio" checked value="0" name="sex" id="sex0">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="realname" class="col-sm-2 control-label p-0 lh-34 m-56">姓名：</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{Auth::user()->realname}}" name="realname" class="form-control float" id="realname1" placeholder="姓名">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label p-0 lh-34 m-56">邮箱：</label>
                        <div class="col-sm-8">
                            <input type="text" value="{{Auth::user()->email}}" name="email" class="form-control float" id="email1" placeholder="邮箱">
                        </div>
                    </div>
                    <div class="row mb-2r user-pic">
                        <div class="col-md-2 mb-3r">
                            <div id="picForm" enctype="multipart/form-data">
                                <div class="img-add">
                                    <span class="glyphicon glyphicon-plus f46"></span>
                                    <p>添加头像</p>
                                    <div id="fine-user-uploader"></div>
                                </div>
                            </div>
                            <input type="hidden" id="cover_id" name="cover_id">
                            <script type="text/template" id="qq-template">
                                <div id="add-img" class="qq-uploader-selector qq-uploader">
                                    <div class="qq-upload-button-selector qq-upload-button">
                                        <div>上传头像</div>
                                    </div>
                                    <ul class="qq-upload-list-selector qq-upload-list">
                                        <li hidden></li>
                                    </ul>
                                </div>
                            </script>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="modal-footer pb-0">
                            <button type="submit" class="btn btn-magenta">确定</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>